<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ManajemenMasterJasa extends Model
{
    use HasFactory;

    protected $table = 'manajemen_master_jasas';

    protected $fillable = [
        'uuid',
        'jasa',
        'harga',
    ];

    protected $casts = [
        'harga' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }
}
