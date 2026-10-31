<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\Konsultasi;
use App\Models\ManajemenMasterJasa;
use App\Models\ManajemenProfil;
use App\Models\Portofolio;
use App\Models\Qa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'username' => 'superadmin',
            'nama' => 'Super Admin',
        ]);
    }

    public function test_can_manage_portofolio(): void
    {
        // 1. Create
        $response = $this->actingAs($this->admin)->post(route('admin.portofolio.store'), [
            'nama' => 'Enterprise Banking Mobile App',
            'keterangan' => 'Modern cross-platform banking system with biometric auth.',
            'link' => 'https://example.com/banking',
            'foto_urls' => "https://example.com/pic1.jpg\nhttps://example.com/pic2.jpg",
        ]);

        $response->assertRedirect(route('admin.portofolio.index'));
        $this->assertDatabaseHas('portofolios', ['nama' => 'Enterprise Banking Mobile App']);

        $portofolio = Portofolio::where('nama', 'Enterprise Banking Mobile App')->first();
        $this->assertNotEmpty($portofolio->uuid);
        $this->assertCount(2, $portofolio->foto);

        // 2. Update
        $updateResponse = $this->actingAs($this->admin)->put(route('admin.portofolio.update', $portofolio->id), [
            'nama' => 'Enterprise Banking Mobile App v2',
            'keterangan' => 'Updated keterangan description.',
            'link' => 'https://example.com/banking-v2',
        ]);
        $updateResponse->assertRedirect(route('admin.portofolio.index'));
        $this->assertDatabaseHas('portofolios', ['nama' => 'Enterprise Banking Mobile App v2']);

        // 3. Delete
        $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.portofolio.destroy', $portofolio->id));
        $deleteResponse->assertRedirect(route('admin.portofolio.index'));
        $this->assertDatabaseMissing('portofolios', ['id' => $portofolio->id]);
    }

    public function test_can_manage_qa(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.qa.store'), [
            'nama' => 'Siti Rahma',
            'perusahaan' => 'PT Solusi Bangsa',
            'keterangan' => 'Pengerjaan sangat cepat dan arsitektur kode rapi.',
        ]);

        $response->assertRedirect(route('admin.qa.index'));
        $this->assertDatabaseHas('qas', ['nama' => 'Siti Rahma']);

        $qa = Qa::where('nama', 'Siti Rahma')->first();
        $this->assertNotEmpty($qa->uuid);

        // Delete
        $this->actingAs($this->admin)->delete(route('admin.qa.destroy', $qa->id))
            ->assertRedirect(route('admin.qa.index'));
        $this->assertDatabaseMissing('qas', ['id' => $qa->id]);
    }

    public function test_can_manage_berita(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.berita.store'), [
            'judul' => 'Tren AI & High-Performance Computing 2026',
            'keterangan' => 'Ulasan komprehensif mengenai revolusi agen mandiri dalam pengembangan sistem perangkat lunak skala global.',
            'status' => 'published',
            'gambar_url' => 'https://example.com/ai.jpg',
        ]);

        $response->assertRedirect(route('admin.berita.index'));
        $this->assertDatabaseHas('beritas', ['judul' => 'Tren AI & High-Performance Computing 2026']);

        $berita = Berita::where('judul', 'Tren AI & High-Performance Computing 2026')->first();
        $this->assertNotEmpty($berita->uuid);

        // Update
        $this->actingAs($this->admin)->put(route('admin.berita.update', $berita->id), [
            'judul' => 'Tren AI & High-Performance Computing 2026 (Updated)',
            'keterangan' => 'Keterangan baru.',
            'status' => 'draft',
            'gambar_url' => 'https://example.com/ai2.jpg',
        ])->assertRedirect(route('admin.berita.index'));

        $this->assertDatabaseHas('beritas', ['status' => 'draft']);
    }

    public function test_can_manage_company_profile(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.profil.update'), [
            'namaPerusahaan' => 'Coretech Global Solusindo',
            'alamat' => 'Sudirman Central Business District, Jakarta',
            'email' => 'hello@coretech.co.id',
            'nomorTelepon' => '+62 811 9988 7766',
            'instagram' => '@coretech.solusindo',
            'tiktok' => '@coretech_global',
            'treads' => '@coretech.threads',
            'linkedIN' => 'coretech-global',
        ]);

        $response->assertRedirect(route('admin.profil.index'));
        $this->assertDatabaseHas('manajemen_profils', [
            'namaPerusahaan' => 'Coretech Global Solusindo',
            'email' => 'hello@coretech.co.id',
        ]);

        $profil = ManajemenProfil::first();
        $this->assertNotEmpty($profil->uuid);
    }

    public function test_can_manage_master_jasa(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.master-jasa.store'), [
            'jasa' => 'SaaS MVP Development',
            'harga' => 35000000,
        ]);

        $response->assertRedirect(route('admin.master-jasa.index'));
        $this->assertDatabaseHas('manajemen_master_jasas', ['jasa' => 'SaaS MVP Development', 'harga' => 35000000]);

        $jasa = ManajemenMasterJasa::where('jasa', 'SaaS MVP Development')->first();
        $this->assertNotEmpty($jasa->uuid);

        // Delete
        $this->actingAs($this->admin)->delete(route('admin.master-jasa.destroy', $jasa->id))
            ->assertRedirect(route('admin.master-jasa.index'));
        $this->assertDatabaseMissing('manajemen_master_jasas', ['id' => $jasa->id]);
    }

    public function test_can_manage_users(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.user.store'), [
            'nama' => 'Staff IT Admin',
            'username' => 'staffadmin',
            'password' => 'secret123',
            'email' => 'staff@coretech.id',
        ]);

        $response->assertRedirect(route('admin.user.index'));
        $this->assertDatabaseHas('users', ['username' => 'staffadmin']);

        $user = User::where('username', 'staffadmin')->first();
        $this->assertNotEmpty($user->uuid);

        // Self delete prevention
        $preventResponse = $this->actingAs($this->admin)->delete(route('admin.user.destroy', $this->admin->id));
        $preventResponse->assertRedirect(route('admin.user.index'));
        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);

        // Delete other user
        $this->actingAs($this->admin)->delete(route('admin.user.destroy', $user->id))
            ->assertRedirect(route('admin.user.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_visitor_can_submit_consultation(): void
    {
        $response = $this->post(route('konsultasi.store'), [
            'nama' => 'Hendra Kusuma',
            'email' => 'hendra@megacorp.id',
            'nomor_telepon' => '081234567890',
            'perusahaan' => 'PT Mega Corp Indonesia',
            'layanan' => 'Custom Web Application Enterprise',
            'pesan' => 'Kami membutuhkan konsultasi arsitektur cloud untuk sistem ERP terdistribusi.',
        ]);

        $response->assertRedirect(url('/#consultation'));
        $this->assertDatabaseHas('konsultasis', [
            'nama' => 'Hendra Kusuma',
            'email' => 'hendra@megacorp.id',
            'status' => 'baru',
        ]);

        $inquiry = Konsultasi::where('email', 'hendra@megacorp.id')->first();
        $this->assertNotEmpty($inquiry->uuid);
    }

    public function test_admin_can_manage_consultations(): void
    {
        $inquiry = Konsultasi::factory()->create([
            'nama' => 'Test Lead Client',
            'status' => 'baru',
        ]);

        // 1. View index
        $indexResponse = $this->actingAs($this->admin)->get(route('admin.konsultasi.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Test Lead Client');

        // 2. Update status and notes
        $updateResponse = $this->actingAs($this->admin)->put(route('admin.konsultasi.update', $inquiry->id), [
            'status' => 'dihubungi',
            'catatan_admin' => 'Sudah ditelepon, proposal dikirim via email.',
        ]);
        $updateResponse->assertRedirect(route('admin.konsultasi.index'));
        $this->assertDatabaseHas('konsultasis', [
            'id' => $inquiry->id,
            'status' => 'dihubungi',
            'catatan_admin' => 'Sudah ditelepon, proposal dikirim via email.',
        ]);

        // 3. Delete inquiry
        $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.konsultasi.destroy', $inquiry->id));
        $deleteResponse->assertRedirect(route('admin.konsultasi.index'));
        $this->assertDatabaseMissing('konsultasis', ['id' => $inquiry->id]);
    }
}
