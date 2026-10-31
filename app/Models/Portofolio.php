<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Portofolio extends Model
{
    use HasFactory;

    protected $table = 'portofolios';

    protected $fillable = [
        'uuid',
        'kategori_id',
        'nama',
        'keterangan',
        'link',
        'foto',
    ];

    protected $casts = [
        'foto' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Relasi ke Master Kategori Portofolio.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriPortofolio::class, 'kategori_id');
    }
}
