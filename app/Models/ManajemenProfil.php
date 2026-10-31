<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ManajemenProfil extends Model
{
    use HasFactory;

    protected $table = 'manajemen_profils';

    protected $fillable = [
        'uuid',
        'namaPerusahaan',
        'alamat',
        'email',
        'nomorTelepon',
        'instagram',
        'tiktok',
        'treads',
        'linkedIN',
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
