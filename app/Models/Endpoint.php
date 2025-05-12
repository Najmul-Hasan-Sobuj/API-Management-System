<?php

namespace App\Models;

use App\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Endpoint extends Model
{
    use HasFactory, SoftDeletes, HasUserTracking;

    protected $fillable = [
        'name',
        'uri',
        'description',
        'status',
        'group_id',
        'collection_id',
        'method_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function method(): BelongsTo
    {
        return $this->belongsTo(HttpMethod::class, 'method_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function headers(): HasMany
    {
        return $this->hasMany(Header::class);
    }

    public function payloads(): HasMany
    {
        return $this->hasMany(Payload::class);
    }
} 