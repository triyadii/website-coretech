<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class KategoriPortofolio extends Model
{
    use HasFactory;

    protected $table = 'kategori_portofolios';

    protected $fillable = [
        'uuid',
        'nama',
        'slug',
        'keterangan',
        'warna',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model): void {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->nama);
            }
        });

        static::updating(function (self $model): void {
            if ($model->isDirty('nama') && empty($model->slug)) {
                $model->slug = Str::slug($model->nama);
            }
        });
    }

    /**
     * Relasi ke Portofolio yang berada di kategori ini.
     */
    public function portofolios(): HasMany
    {
        return $this->hasMany(Portofolio::class, 'kategori_id');
    }
}
