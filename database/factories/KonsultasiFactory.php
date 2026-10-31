<?php

namespace Database\Factories;

use App\Models\Konsultasi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Konsultasi>
 */
class KonsultasiFactory extends Factory
{
    protected $model = Konsultasi::class;

    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'email' => fake()->safeEmail(),
            'nomor_telepon' => fake()->phoneNumber(),
            'perusahaan' => fake()->company(),
            'layanan' => fake()->randomElement([
                'Custom Web Application Enterprise',
                'Mobile App Development (iOS & Android)',
                'Enterprise ERP & Supply Chain System',
                'Cloud Infrastructure & DevOps CI/CD Setup',
                'AI & Machine Learning Agent Integration',
            ]),
            'pesan' => fake()->paragraph(),
            'status' => fake()->randomElement(['baru', 'dihubungi', 'selesai']),
            'catatan_admin' => fake()->optional()->sentence(),
        ];
    }
}
