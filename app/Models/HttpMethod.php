<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HttpMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'method',
    ];

    public function endpoints(): HasMany
    {
        return $this->hasMany(Endpoint::class, 'method_id');
    }
} 