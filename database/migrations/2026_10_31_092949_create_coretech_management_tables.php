<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Portofolio
        Schema::create('portofolios', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('nama');
            $table->text('keterangan');
            $table->string('link')->nullable();
            $table->json('foto')->nullable(); // max 3 photos stored as JSON array
            $table->timestamps();
        });

        // 2. QA
        Schema::create('qas', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('nama');
            $table->string('perusahaan');
            $table->text('keterangan');
            $table->timestamps();
        });

        // 3. Berita
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('judul');
            $table->longText('keterangan');
            $table->string('gambar')->nullable();
            $table->string('status')->default('published');
            $table->timestamps();
        });

        // 4. Manajemen Profil
        Schema::create('manajemen_profils', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('namaPerusahaan');
            $table->text('alamat');
            $table->string('email');
            $table->string('nomorTelepon');
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('treads')->nullable();
            $table->string('linkedIN')->nullable();
            $table->timestamps();
        });

        // 5. Update Users for Manajemen User
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique()->after('id');
            $table->string('username')->nullable()->unique()->after('uuid');
            $table->string('nama')->nullable()->after('username');
            $table->string('email')->nullable()->change();
        });

        // 6. Manajemen Master Jasa
        Schema::create('manajemen_master_jasas', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('jasa');
            $table->unsignedBigInteger('harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manajemen_master_jasas');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'username', 'nama']);
        });

        Schema::dropIfExists('manajemen_profils');
        Schema::dropIfExists('beritas');
        Schema::dropIfExists('qas');
        Schema::dropIfExists('portofolios');
    }
};
