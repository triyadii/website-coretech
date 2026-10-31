@extends('layouts.public')

@section('title', 'Portofolio & Karya Rekayasa Teknologi — ' . ($profil->namaPerusahaan ?? 'PT Coretech Rekayasa Digital'))
@section('meta_description', 'Jelajahi rekam jejak portofolio proyek enterprise, aplikasi finansial, ERP rantai pasok, dan solusi digital yang dibangun oleh Coretech.')

@section('styles')
<style>
  .portfolio-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 2.25rem;
  }

  .portfolio-card {
    display: flex;
    flex-direction: column;
    height: 100%;
  }

  .portfolio-media {
    position: relative;
    height: 250px;
    overflow: hidden;
    background: #0d0d12;
  }

  .portfolio-media img.main-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
  }

  .glass-card:hover .portfolio-media img.main-img {
    transform: scale(1.05);
  }

  .portfolio-tag {
    position: absolute;
    top: 1rem;
    left: 1rem;
    background: rgba(8, 8, 12, 0.85);
    border: 1px solid rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    color: #ffffff;
    font-size: 0.76rem;
    font-weight: 600;
    padding: 0.35rem 0.8rem;
    border-radius: 9999px;
    z-index: 2;
  }

  .portfolio-photo-count {
    position: absolute;
    bottom: 1rem;
    right: 1rem;
    background: rgba(8, 8, 12, 0.85);
    border: 1px solid rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    color: #e2e8f0;
    font-size: 0.74rem;
    font-weight: 600;
    padding: 0.3rem 0.75rem;
    border-radius: 9999px;
    display: flex;
    align-items: center;
    gap: 0.4rem;
    z-index: 2;
  }

  /* Category Filter Pills */
  .category-filter-wrap {
    margin-top: 2rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    position: relative;
    z-index: 5;
  }

  .category-filter-bar {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 0.6rem;
    padding: 0.45rem 0.6rem;
    background: rgba(14, 14, 20, 0.7);
    border: 1px solid rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(16px);
    border-radius: 9999px;
    max-width: 100%;
  }

  .filter-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.45rem 1.05rem;
    border-radius: 9999px;
    font-size: 0.84rem;
    font-weight: 500;
    color: #94a3b8;
    text-decoration: none;
    background: transparent;
    border: 1px solid transparent;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  }

  .filter-pill:hover {
    color: #ffffff;
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(255, 255, 255, 0.12);
  }

  .filter-pill.active {
    color: #ffffff;
    background: rgba(167, 139, 250, 0.15);
    border-color: rgba(167, 139, 250, 0.4);
    font-weight: 600;
    box-shadow: 0 0 15px rgba(167, 139, 250, 0.2);
  }

  .filter-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
  }

  .filter-count {
    font-size: 0.72rem;
    padding: 0.1rem 0.45rem;
    border-radius: 9999px;
    background: rgba(255, 255, 255, 0.08);
    color: #cbd5e1;
  }

  .filter-pill.active .filter-count {
    background: rgba(167, 139, 250, 0.3);
    color: #ffffff;
  }

  .active-filter-indicator {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    font-size: 0.85rem;
    color: #94a3b8;
    background: rgba(167, 139, 250, 0.08);
    border: 1px solid rgba(167, 139, 250, 0.2);
    padding: 0.4rem 1rem;
    border-radius: 9999px;
  }

  .active-filter-indicator strong {
    color: #a78bfa;
  }

  .filter-sep {
    color: rgba(255, 255, 255, 0.2);
  }

  .filter-sub {
    color: #64748b;
    font-size: 0.8rem;
  }

  .btn-clear-filter {
    color: #f43f5e;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.8rem;
    margin-left: 0.5rem;
    padding-left: 0.5rem;
    border-left: 1px solid rgba(255, 255, 255, 0.15);
  }

  .btn-clear-filter:hover {
    color: #fb7185;
    text-decoration: underline;
  }

  /* Multi-photo thumbnail bar */
  .photo-thumbs-bar {
    display: flex;
    gap: 0.5rem;
    padding: 0.75rem 1.75rem 0;
    background: rgba(14, 14, 20, 0.5);
  }

  .thumb-item {
    width: 52px;
    height: 40px;
    border-radius: 8px;
    overflow: hidden;
    border: 1.5px solid rgba(255, 255, 255, 0.1);
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .thumb-item:hover, .thumb-item.active {
    border-color: var(--accent);
    transform: translateY(-2px);
  }

  .thumb-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .portfolio-body {
    padding: 1.75rem;
    display: flex;
    flex-direction: column;
    flex: 1;
  }

  .portfolio-title {
    font-size: 1.35rem;
    font-weight: 700;
    line-height: 1.3;
    letter-spacing: -0.015em;
    color: #ffffff;
    margin-bottom: 0.85rem;
  }

  .portfolio-desc {
    color: #94a3b8;
    font-size: 0.94rem;
    line-height: 1.65;
    margin-bottom: 1.75rem;
    flex: 1;
  }

  .portfolio-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
    padding-top: 1.25rem;
    border-top: 1px solid rgba(255, 255, 255, 0.06);
  }

  .btn-live {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.65rem 1.25rem;
    border-radius: 9999px;
    background: #f8fafc;
    color: #09090b;
    font-size: 0.86rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .btn-live:hover {
    background: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 255, 255, 0.2);
  }

  .btn-gallery {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.65rem 1.1rem;
    border-radius: 9999px;
    background: rgba(255, 255, 255, 0.06);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #e2e8f0;
    font-size: 0.86rem;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .btn-gallery:hover {
    background: rgba(167, 139, 250, 0.15);
    border-color: rgba(167, 139, 250, 0.4);
    color: #ffffff;
  }

  /* Bottom CTA Banner */
  .portfolio-cta-banner {
    margin-top: 5rem;
    padding: 3.5rem 2rem;
    border-radius: 24px;
    background: linear-gradient(135deg, rgba(24, 24, 34, 0.85) 0%, rgba(14, 14, 22, 0.95) 100%);
    border: 1px solid rgba(167, 139, 250, 0.3);
    text-align: center;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
  }

  .portfolio-cta-banner::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 600px;
    height: 300px;
    background: radial-gradient(circle, rgba(167, 139, 250, 0.12), transparent 70%);
    pointer-events: none;
  }

  .cta-title {
    font-size: clamp(1.6rem, 2.5vw, 2.2rem);
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 1rem;
    position: relative;
  }

  .cta-desc {
    color: #94a3b8;
    max-width: 620px;
    margin: 0 auto 2rem;
    font-size: 1.02rem;
    line-height: 1.6;
    position: relative;
  }

  .btn-cta-lg {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.9rem 2rem;
    border-radius: 9999px;
    background: linear-gradient(135deg, #ffffff, #f1f5f9);
    color: #09090b;
    font-size: 0.95rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2);
    position: relative;
  }

  .btn-cta-lg:hover {
    background: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(167, 139, 250, 0.35);
  }

  /* Modal Lightbox for Photos */
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.88);
    -webkit-backdrop-filter: blur(16px);
    backdrop-filter: blur(16px);
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 2rem;
  }

  .modal-overlay.active {
    display: flex;
  }

  .modal-content {
    max-width: 900px;
    width: 100%;
    background: #0f0f14;
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.8);
  }

  .modal-close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.6);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
  }

  .modal-img-container {
    width: 100%;
    max-height: 520px;
    background: #000;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .modal-img-container img {
    max-width: 100%;
    max-height: 520px;
    object-fit: contain;
  }

  .modal-footer {
    padding: 1.25rem 1.75rem;
    background: #14141c;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .modal-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #ffffff;
  }

  @media (max-width: 768px) {
    .portfolio-grid {
      grid-template-columns: 1fr;
    }
  }
</style>
@endsection

@section('content')
<div class="page-hero">
  <div class="badge-pill">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
    Showcase & Rekayasa Solusi
  </div>
  <h1 class="page-title">
    Portofolio <span class="text-gradient">Karya Teknologi</span>
  </h1>
  <p class="page-subtitle">
    Jelajahi portofolio sistem perbankan skala enterprise, ERP rantai pasok cerdas, integrasi telematika, dan solusi software tangguh yang dirancang oleh Coretech.
  </p>

  <!-- Category Filter Bar -->
  <div class="category-filter-wrap">
    <div class="category-filter-bar">
      <a href="{{ route('portofolio.public') }}" class="filter-pill {{ empty($selectedKategori) ? 'active' : '' }}">
        <span class="filter-dot" style="background: #a78bfa;"></span>
        Semua Proyek
      </a>
      @foreach($kategoris as $kat)
        <a href="{{ route('portofolio.public', ['kategori' => $kat->slug]) }}" 
           class="filter-pill {{ (!empty($selectedKategori) && $selectedKategori->id === $kat->id) ? 'active' : '' }}"
           style="{{ (!empty($selectedKategori) && $selectedKategori->id === $kat->id && $kat->warna) ? 'border-color: '.$kat->warna.'; background: rgba(167, 139, 250, 0.15);' : '' }}">
          @if($kat->warna)
            <span class="filter-dot" style="background: {{ $kat->warna }};"></span>
          @endif
          <span>{{ $kat->nama }}</span>
          @if(isset($kat->portofolios_count))
            <span class="filter-count">{{ $kat->portofolios_count }}</span>
          @endif
        </a>
      @endforeach
    </div>

    @if(!empty($selectedKategori))
      <div class="active-filter-indicator">
        <span>Menampilkan kategori: <strong>{{ $selectedKategori->nama }}</strong></span>
        @if($selectedKategori->keterangan)
          <span class="filter-sep">•</span>
          <span class="filter-sub">{{ $selectedKategori->keterangan }}</span>
        @endif
        <a href="{{ route('portofolio.public') }}" class="btn-clear-filter">
          Reset Filter &times;
        </a>
      </div>
    @endif
  </div>
</div>

<div class="content-container">
  <div class="portfolio-grid">
    @forelse($portofolios as $port)
      @php
        $photos = is_array($port->foto) ? $port->foto : (json_decode($port->foto, true) ?? []);
        $mainPhoto = !empty($photos) ? $photos[0] : null;
      @endphp
      <div class="glass-card portfolio-card" id="card-{{ $port->uuid }}">
        <div class="portfolio-media">
          <span class="portfolio-tag" style="{{ $port->kategori && $port->kategori->warna ? 'border-color: '.$port->kategori->warna.'55; color: '.$port->kategori->warna : '' }}">
            {{ $port->kategori->nama ?? 'Enterprise Solution' }}
          </span>

          @if(!empty($photos) && count($photos) > 1)
            <div class="portfolio-photo-count">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
              <span>{{ count($photos) }} Foto</span>
            </div>
          @endif

          @if($mainPhoto)
            <img src="{{ $mainPhoto }}" alt="{{ $port->nama }}" class="main-img" id="main-img-{{ $port->uuid }}" loading="lazy">
          @else
            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #1f1b2e, #0e0f17); display: flex; align-items: center; justify-content: center; color: #a78bfa;">
              <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
            </div>
          @endif
        </div>

        @if(!empty($photos) && count($photos) > 1)
          <div class="photo-thumbs-bar">
            @foreach($photos as $index => $photo)
              <div class="thumb-item {{ $index === 0 ? 'active' : '' }}" onclick="switchCardPhoto('{{ $port->uuid }}', '{{ $photo }}', this)">
                <img src="{{ $photo }}" alt="Thumbnail {{ $index + 1 }}">
              </div>
            @endforeach
          </div>
        @endif

        <div class="portfolio-body">
          <h2 class="portfolio-title">{{ $port->nama }}</h2>
          <p class="portfolio-desc">{{ $port->keterangan }}</p>

          <div class="portfolio-actions">
            @if($port->link)
              <a href="{{ $port->link }}" target="_blank" rel="noopener noreferrer" class="btn-live">
                Kunjungi Live Demo
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
              </a>
            @endif

            @if($mainPhoto)
              <button type="button" class="btn-gallery" onclick="openPhotoModal('{{ $mainPhoto }}', '{{ addslashes($port->nama) }}')">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/></svg>
                Perbesar
              </button>
            @endif
          </div>
        </div>
      </div>
    @empty
      <div style="grid-column: 1/-1; text-align: center; padding: 4.5rem 1.5rem; color: #94a3b8; background: rgba(14, 14, 20, 0.4); border: 1px dashed rgba(255, 255, 255, 0.1); border-radius: 20px;">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 1.25rem; color: #64748b; display: block;"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
        <div style="font-size: 1.15rem; font-weight: 700; color: #f1f5f9; margin-bottom: 0.5rem;">Belum ada portofolio pada kategori ini</div>
        <p style="font-size: 0.92rem; color: #64748b; max-width: 440px; margin: 0 auto 1.5rem; line-height: 1.6;">Proyek untuk kategori ini sedang dalam tahap perakitan dan dokumentasi arsitektur. Silakan jelajahi kategori lainnya.</p>
        <a href="{{ route('portofolio.public') }}" class="btn-live">
          Lihat Semua Portofolio
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </a>
      </div>
    @endforelse
  </div>

  <div class="pagination-wrap">
    {{ $portofolios->links() }}
  </div>

  <!-- CTA Banner -->
  <div class="portfolio-cta-banner">
    <h3 class="cta-title">Punya Ide Proyek atau Kebutuhan Solusi Serupa?</h3>
    <p class="cta-desc">
      Diskusikan kebutuhan arsitektur aplikasi enterprise, integrasi cloud, atau modernisasi sistem lawas Anda bersama tim software architect Coretech.
    </p>
    <a href="{{ route('home') }}#consultation" class="btn-cta-lg">
      Konsultasikan Proyek Anda
      <svg width="16" height="14" viewBox="0 0 12 10" fill="none">
        <path d="M0.8 5h10M7.1 1.4 10.9 5l-3.8 3.6" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </a>
  </div>
</div>

<!-- Modal Lightbox -->
<div class="modal-overlay" id="photoModal" onclick="closePhotoModal(event)">
  <div class="modal-content" onclick="event.stopPropagation()">
    <button type="button" class="modal-close" onclick="closePhotoModal()">&times;</button>
    <div class="modal-img-container">
      <img src="" id="modalImg" alt="Preview Portofolio">
    </div>
    <div class="modal-footer">
      <div class="modal-title" id="modalTitle"></div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  function switchCardPhoto(uuid, photoUrl, thumbEl) {
    const mainImg = document.getElementById('main-img-' + uuid);
    if (mainImg) {
      mainImg.src = photoUrl;
    }
    const thumbsBar = thumbEl.parentElement;
    if (thumbsBar) {
      thumbsBar.querySelectorAll('.thumb-item').forEach(el => el.classList.remove('active'));
      thumbEl.classList.add('active');
    }
  }

  function openPhotoModal(imgUrl, title) {
    const modal = document.getElementById('photoModal');
    const modalImg = document.getElementById('modalImg');
    const modalTitle = document.getElementById('modalTitle');
    if (modal && modalImg) {
      modalImg.src = imgUrl;
      modalTitle.textContent = title;
      modal.classList.add('active');
    }
  }

  function closePhotoModal(event) {
    const modal = document.getElementById('photoModal');
    if (modal) {
      modal.classList.remove('active');
    }
  }

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closePhotoModal();
    }
  });
</script>
@endsection
