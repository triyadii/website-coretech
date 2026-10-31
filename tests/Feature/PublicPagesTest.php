<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\KategoriPortofolio;
use App\Models\ManajemenMasterJasa;
use App\Models\ManajemenProfil;
use App\Models\Portofolio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        ManajemenProfil::create([
            'uuid' => (string) Str::uuid(),
            'namaPerusahaan' => 'PT Coretech Rekayasa Digital',
            'alamat' => 'Cyber 2 Tower, Jakarta',
            'email' => 'halo@coretech.id',
            'nomorTelepon' => '+62 811-9876-5432',
        ]);

        ManajemenMasterJasa::create([
            'uuid' => (string) Str::uuid(),
            'jasa' => 'Custom Web Application Enterprise',
            'harga' => 50000000,
        ]);
    }

    public function test_landing_page_renders_with_tidied_navbar_and_links(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('PT Coretech Rekayasa Digital');
        $response->assertSee(route('portofolio.public'));
        $response->assertSee(route('berita.public'));
        $response->assertSee('nav-container');
        $response->assertSee('favicon.svg');
        $response->assertSee('favicon.ico');
        $response->assertDontSee('Login Admin');
        $response->assertDontSee('Login Administrator');
    }

    public function test_portofolio_public_listing_page(): void
    {
        $kategori1 = KategoriPortofolio::create([
            'nama' => 'Fintech & Payment',
            'slug' => 'fintech-payment',
            'warna' => '#10b981',
        ]);

        $kategori2 = KategoriPortofolio::create([
            'nama' => 'Healthcare & AI',
            'slug' => 'healthcare-ai',
            'warna' => '#06b6d4',
        ]);

        $project1 = Portofolio::create([
            'uuid' => (string) Str::uuid(),
            'kategori_id' => $kategori1->id,
            'nama' => 'FinCore Payment Engine',
            'keterangan' => 'Modern Treasury System',
            'link' => 'https://fincore.example.com',
            'foto' => ['https://example.com/pic1.jpg'],
        ]);

        $project2 = Portofolio::create([
            'uuid' => (string) Str::uuid(),
            'kategori_id' => $kategori2->id,
            'nama' => 'MediCare Telehealth Core',
            'keterangan' => 'Electronic Health Record and Diagnostics',
            'link' => 'https://medicare.example.com',
            'foto' => ['https://example.com/pic2.jpg'],
        ]);

        // 1. All projects listing
        $response = $this->get(route('portofolio.public'));

        $response->assertStatus(200);
        $response->assertSee('Portofolio');
        $response->assertSee('FinCore Payment Engine');
        $response->assertSee('Fintech &amp; Payment', false);
        $response->assertSee('MediCare Telehealth Core');
        $response->assertSee('Healthcare &amp; AI', false);
        $response->assertSee('Semua Proyek');

        // 2. Filter by fintech category
        $filteredResponse = $this->get(route('portofolio.public', ['kategori' => 'fintech-payment']));
        $filteredResponse->assertStatus(200);
        $filteredResponse->assertSee('FinCore Payment Engine');
        $filteredResponse->assertDontSee('MediCare Telehealth Core');
        $filteredResponse->assertSee('Menampilkan kategori:');

        // 3. Filter by empty category
        $emptyCat = KategoriPortofolio::create([
            'nama' => 'Smart City',
            'slug' => 'smart-city',
        ]);
        $emptyResponse = $this->get(route('portofolio.public', ['kategori' => 'smart-city']));
        $emptyResponse->assertStatus(200);
        $emptyResponse->assertSee('Belum ada portofolio pada kategori ini');

        // 4. Landing page should show category badge
        $homeResponse = $this->get(route('home'));
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('FinCore Payment Engine');
        $homeResponse->assertSee('Fintech &amp; Payment', false);
    }

    public function test_berita_public_listing_page_and_search(): void
    {
        $publishedNews = Berita::create([
            'uuid' => (string) Str::uuid(),
            'judul' => 'Inovasi AI Agent untuk Enterprise 2026',
            'keterangan' => 'Ulasan mendalam implementasi autonomous agent.',
            'gambar' => 'https://example.com/ai.jpg',
            'status' => 'published',
        ]);

        $draftNews = Berita::create([
            'uuid' => (string) Str::uuid(),
            'judul' => 'Rahasia Internal Tidak Dipublikasikan',
            'keterangan' => 'Draft artikel rahasia.',
            'status' => 'draft',
        ]);

        $response = $this->get(route('berita.public'));

        $response->assertStatus(200);
        $response->assertSee('Inovasi AI Agent untuk Enterprise 2026');
        $response->assertDontSee('Rahasia Internal Tidak Dipublikasikan');

        // Test search filter
        $searchResponse = $this->get(route('berita.public', ['q' => 'Inovasi AI']));
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('Inovasi AI Agent untuk Enterprise 2026');

        $searchEmptyResponse = $this->get(route('berita.public', ['q' => 'NonExistentTopicXYZ']));
        $searchEmptyResponse->assertStatus(200);
        $searchEmptyResponse->assertSee('Tidak Ada Artikel Ditemukan');
    }

    public function test_berita_detail_page_renders_with_sidebar_small_news_list(): void
    {
        $mainArticle = Berita::create([
            'uuid' => (string) Str::uuid(),
            'judul' => 'Arsitektur Microservices Skala Jutaan Transaksi',
            'keterangan' => 'Penjelasan komprehensif event-driven architecture.',
            'gambar' => 'https://example.com/microservices.jpg',
            'status' => 'published',
        ]);

        $otherArticle = Berita::create([
            'uuid' => (string) Str::uuid(),
            'judul' => 'Penerapan Zero-Trust Security pada Cloud API',
            'keterangan' => 'Keamanan API modern dengan mTLS dan ISO 27001.',
            'gambar' => 'https://example.com/security.jpg',
            'status' => 'published',
        ]);

        $response = $this->get(route('berita.show', $mainArticle->uuid));

        $response->assertStatus(200);
        $response->assertSee('Arsitektur Microservices Skala Jutaan Transaksi');
        $response->assertSee('Penjelasan komprehensif event-driven architecture.');
        // Verify sidebar list berita kecil
        $response->assertSee('Berita Terkini Lainnya');
        $response->assertSee('Penerapan Zero-Trust Security pada Cloud API');
        $response->assertSee('small-news-card');
        $response->assertSee(route('berita.show', $otherArticle->uuid));
    }

    public function test_draft_berita_detail_returns_404(): void
    {
        $draft = Berita::create([
            'uuid' => (string) Str::uuid(),
            'judul' => 'Draft Unreleased News',
            'keterangan' => 'Not published yet',
            'status' => 'draft',
        ]);

        $response = $this->get(route('berita.show', $draft->uuid));

        $response->assertStatus(404);
    }
}
