<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Konsultasi extends Model
{
    use HasFactory;

    protected $table = 'konsultasis';

    protected $fillable = [
        'uuid',
        'nama',
        'email',
        'nomor_telepon',
        'perusahaan',
        'layanan',
        'pesan',
        'status',
        'catatan_admin',
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
