<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\Konsultasi;
use App\Models\ManajemenMasterJasa;
use App\Models\ManajemenProfil;
use App\Models\Portofolio;
use App\Models\Qa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Manajemen User
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'uuid' => (string) Str::uuid(),
                'username' => 'admin',
                'nama' => 'Super Administrator Coretech',
                'name' => 'Super Administrator Coretech',
                'email' => 'admin@coretech.id',
                'password' => Hash::make('admin123'),
            ]
        );

        User::updateOrCreate(
            ['username' => 'developer'],
            [
                'uuid' => (string) Str::uuid(),
                'username' => 'developer',
                'nama' => 'Lead Engineer',
                'name' => 'Lead Engineer',
                'email' => 'developer@coretech.id',
                'password' => Hash::make('dev123'),
            ]
        );

        // 2. Manajemen Profil Perusahaan
        ManajemenProfil::updateOrCreate(
            ['email' => 'halo@coretech.id'],
            [
                'uuid' => (string) Str::uuid(),
                'namaPerusahaan' => 'PT Coretech Rekayasa Digital',
                'alamat' => 'Cyber 2 Tower Lantai 18, Jl. H.R. Rasuna Said Blok X-5, Kuningan, Jakarta Selatan 12950',
                'email' => 'halo@coretech.id',
                'nomorTelepon' => '+62 811-9876-5432',
                'instagram' => '@coretech.id',
                'tiktok' => '@coretech.official',
                'treads' => '@coretech.id',
                'linkedIN' => 'https://linkedin.com/company/coretech-digital',
            ]
        );

        // 3. Portofolio (max 3 foto per item)
        $portofolios = [
            [
                'nama' => 'FinCore — Cross-Border Treasury & Payment Engine',
                'keterangan' => 'Platform kliring dan likuiditas multi-mata uang dengan rekonsiliasi otomatis real-time, integrasi gateway perbankan internasional, dan deteksi anomali anti-fraud.',
                'link' => 'https://fincore.example.com',
                'foto' => [
                    'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1559526324-4b87b5e36e44?w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&auto=format&fit=crop',
                ],
            ],
            [
                'nama' => 'Omnix — AI Supply Chain & Fleet Telematics',
                'keterangan' => 'Sistem ERP rantai pasok multinasional dengan machine learning untuk peramalan permintaan stok, optimasi rute armada real-time, dan pelacakan pergudangan IoT.',
                'link' => 'https://omnix.example.com',
                'foto' => [
                    'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1553413077-190dd305871c?w=800&auto=format&fit=crop',
                ],
            ],
            [
                'nama' => 'MediConnect — Unified Telehealth & Hospital EMR',
                'keterangan' => 'Ekosistem rekam medis elektronik (EMR) terintegrasi untuk 40+ rumah sakit swasta, konsultasi video dokter HD terenkripsi, dan integrasi BPJS / asuransi instan.',
                'link' => 'https://mediconnect.example.com',
                'foto' => [
                    'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?w=800&auto=format&fit=crop',
                ],
            ],
            [
                'nama' => 'GovSmart — Smart City Public Service Portal',
                'keterangan' => 'Portal terpadu pelayanan publik pemerintah daerah yang melayani 2.5 juta warga untuk perizinan online, monitoring bansos, dan sistem tanggap darurat bencana berbasis GIS geolokasi.',
                'link' => 'https://govsmart.example.com',
                'foto' => [
                    'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&auto=format&fit=crop',
                ],
            ],
            [
                'nama' => 'InsureCore — Autonomous Claims & Policy Engine',
                'keterangan' => 'Mesin pemrosesan klaim asuransi otomatis dengan Computer Vision untuk analisis kerusakan kendaraan, integrasi bengkel rekanan, dan validasi polis instan dalam 3 menit.',
                'link' => 'https://insurecore.example.com',
                'foto' => [
                    'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=800&auto=format&fit=crop',
                ],
            ],
        ];

        foreach ($portofolios as $p) {
            Portofolio::updateOrCreate(
                ['nama' => $p['nama']],
                array_merge($p, ['uuid' => (string) Str::uuid()])
            );
        }

        // 4. QA
        $qas = [
            [
                'nama' => 'Budi Santoso',
                'perusahaan' => 'Bank Mandiri Utama',
                'keterangan' => 'Berapa lama rata-rata estimasi pengerjaan arsitektur core banking dan bagaimana jaminan kepatuhan keamanan finansialnya?',
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'perusahaan' => 'PT Logistik Nusantara',
                'keterangan' => 'Apakah sistem ERP yang dikembangkan Coretech dapat diintegrasikan dengan sensor telematika armada kami yang sudah beroperasi?',
            ],
            [
                'nama' => 'Hendro Wijaya',
                'perusahaan' => 'Medika Sehat Prima',
                'keterangan' => 'Bagaimana prosedur serah terima seluruh hak cipta intellectual property dan source code setelah go-live?',
            ],
            [
                'nama' => 'Rian Kurniawan',
                'perusahaan' => 'Fintech Asia Group',
                'keterangan' => 'Apakah Coretech menyediakan dukungan dedicated engineer standby 24 jam untuk monitoring sistem transaksi kritis?',
            ],
            [
                'nama' => 'Maya Anggraini',
                'perusahaan' => 'eCommerce Global Network',
                'keterangan' => 'Bagaimana skema pembayaran dan termin proyek? Apakah menggunakan milestone-based delivery sesuai sprint mingguan?',
            ],
        ];

        foreach ($qas as $q) {
            Qa::updateOrCreate(
                ['nama' => $q['nama'], 'perusahaan' => $q['perusahaan']],
                array_merge($q, ['uuid' => (string) Str::uuid()])
            );
        }

        // 5. Berita
        $beritas = [
            [
                'judul' => 'Evolusi Microservices & Event-Driven 2026: Kapan Perusahaan Harus Beralih?',
                'keterangan' => 'Analisis mendalam tentang bagaimana arsitektur event-driven memecahkan bottleneck pada sistem monolitik tradisional untuk jutaan transaksi concurrent tanpa downtime. Dalam dunia finansial modern, latensi dan integritas data adalah taruhan utama. Kami membedah pola Saga, distributed tracing OpenTelemetry, dan implementasi Kafka untuk menjamin konsistensi data antar-layanan terisolasi.',
                'gambar' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=800&auto=format&fit=crop',
                'status' => 'published',
            ],
            [
                'judul' => 'Mengintegrasikan Private LLM & AI Agents dalam Workflow Korporasi',
                'keterangan' => 'Panduan komprehensif mengadopsi model kecerdasan buatan mandiri secara on-premise atau private cloud tanpa membocorkan data sensitif perusahaan ke pihak ketiga. Dengan arsitektur Retrieval-Augmented Generation (RAG) berbasis vector database internal, tim internal dapat mengekstraksi insight dari jutaan dokumen legal dan audit secara instan dengan tata kelola keamanan ketat.',
                'gambar' => 'https://images.unsplash.com/photo-1677442136019-21780efad99a?w=800&auto=format&fit=crop',
                'status' => 'published',
            ],
            [
                'judul' => 'Menerapkan Zero-Trust Security pada Ekosistem API Finansial Modern',
                'keterangan' => 'Strategi implementasi otentikasi adaptif mTLS, enkripsi database berlapis, dan deteksi intrusi otomatis untuk mencegah kebocoran data di era komputasi terbuka. Pelajari bagaimana standar ISO 27001 dan regulasi perlindungan data pribadi (UU PDP) dapat dipenuhi tanpa mengorbankan performa kecepatan response time aplikasi mobile.',
                'gambar' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?w=800&auto=format&fit=crop',
                'status' => 'published',
            ],
            [
                'judul' => 'Cloud Native vs Hybrid Cloud: Menentukan Arsitektur Ideal untuk Skalabilitas Bisnis',
                'keterangan' => 'Komparasi mendalam efisiensi biaya dan keandalan operasional antara fully cloud-native di AWS/GCP dengan skema hybrid on-premise untuk kepatuhan regulasi data sovereign perbankan dan asuransi di Indonesia.',
                'gambar' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?w=800&auto=format&fit=crop',
                'status' => 'published',
            ],
            [
                'judul' => 'Best Practice CI/CD Pipeline Otomatis dengan Kubernetes & GitOps ArgoCD',
                'keterangan' => 'Bagaimana tim engineering Coretech mempercepat siklus rilis fitur dari hitungan minggu menjadi beberapa jam per hari dengan automated testing, zero-downtime canary deployment, dan automated rollback.',
                'gambar' => 'https://images.unsplash.com/photo-1618401471353-b98afee0b2eb?w=800&auto=format&fit=crop',
                'status' => 'published',
            ],
            [
                'judul' => 'Strategi Mengoptimalkan Database PostgreSQL untuk Beban Kerja High-Throughput OLTP',
                'keterangan' => 'Eksplorasi teknik table partitioning, indexing pg_stat_statements, connection pooling PgBouncer, dan tuning memori kernel Linux untuk menangani lebih dari 25.000 transaksi per detik tanpa lag.',
                'gambar' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=800&auto=format&fit=crop',
                'status' => 'published',
            ],
        ];

        foreach ($beritas as $b) {
            Berita::updateOrCreate(
                ['judul' => $b['judul']],
                array_merge($b, ['uuid' => (string) Str::uuid()])
            );
        }

        // 6. Manajemen Master Jasa
        $jasas = [
            ['jasa' => 'Custom Web Application Enterprise', 'harga' => 45000000],
            ['jasa' => 'Mobile App Development (iOS & Android Flutter)', 'harga' => 60000000],
            ['jasa' => 'Enterprise ERP & Supply Chain System', 'harga' => 120000000],
            ['jasa' => 'Cloud Infrastructure & DevOps CI/CD Setup', 'harga' => 25000000],
            ['jasa' => 'AI & Machine Learning Agent Integration', 'harga' => 35000000],
            ['jasa' => 'Penetration Testing & Security Audit', 'harga' => 20000000],
        ];

        foreach ($jasas as $j) {
            ManajemenMasterJasa::updateOrCreate(
                ['jasa' => $j['jasa']],
                array_merge($j, ['uuid' => (string) Str::uuid()])
            );
        }

        // 7. Konsultasi
        $konsultasis = [
            [
                'nama' => 'Aditya Pratama',
                'email' => 'aditya@inovasidana.co.id',
                'nomor_telepon' => '081298765432',
                'perusahaan' => 'PT Inovasi Dana Solusindo',
                'layanan' => 'Custom Web Application Enterprise',
                'pesan' => 'Kami memerlukan modernisasi sistem portal payment gateway kami dengan SLA 99.99% dan enkripsi HSM.',
                'status' => 'baru',
            ],
            [
                'nama' => 'Dewi Sartika',
                'email' => 'dewi@logistikunggul.com',
                'nomor_telepon' => '082155667788',
                'perusahaan' => 'Logistik Unggul Express',
                'layanan' => 'Enterprise ERP & Supply Chain System',
                'pesan' => 'Ingin konsultasi pengembangan ERP pelacakan armada distribusi nasional terintegrasi IoT.',
                'status' => 'dihubungi',
                'catatan_admin' => 'Sudah dikontak via WhatsApp, jadwal meeting zoom hari Selasa jam 14:00.',
            ],
        ];

        foreach ($konsultasis as $k) {
            Konsultasi::updateOrCreate(
                ['email' => $k['email']],
                array_merge($k, ['uuid' => (string) Str::uuid()])
            );
        }
    }
}
