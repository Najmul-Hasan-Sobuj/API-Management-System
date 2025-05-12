<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TemplatePage extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_id',
        'title',
        'slug',
        'content',
        'data',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'data' => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    protected function getDataAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }
        return $value ?? [];
    }

    protected function setDataAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['data'] = json_encode($value);
        } else {
            $this->attributes['data'] = $value;
        }
    }

    public function getFieldValue(string $fieldName)
    {
        $data = $this->data;
        return $data[$fieldName] ?? null;
    }

    public function setFieldValue(string $fieldName, $value)
    {
        $data = $this->data;
        $data[$fieldName] = $value;
        $this->data = $data;
    }

    public function toArray()
    {
        $array = parent::toArray();
        if (isset($array['data']) && is_array($array['data'])) {
            $array['data'] = array_map(function ($value) {
                if (is_array($value)) {
                    return json_encode($value);
                }
                return $value;
            }, $array['data']);
        }
        return $array;
    }
} 