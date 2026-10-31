@extends('layouts.public')

@section('title', 'Kabar & Wawasan Teknologi — ' . ($profil->namaPerusahaan ?? 'PT Coretech Rekayasa Digital'))
@section('meta_description', 'Eksplorasi artikel teknologi, arsitektur software modern, kecerdasan buatan enterprise, dan cloud computing dari Coretech.')

@section('styles')
<style>
  .news-search-bar {
    max-width: 580px;
    margin: 2rem auto 0;
    position: relative;
  }

  .news-search-input {
    width: 100%;
    padding: 0.95rem 1.25rem 0.95rem 3rem;
    border-radius: 9999px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.12);
    color: #ffffff;
    font-size: 0.95rem;
    font-family: inherit;
    outline: none;
    transition: all 0.25s ease;
  }

  .news-search-input:focus {
    background: rgba(255, 255, 255, 0.08);
    border-color: var(--accent);
    box-shadow: 0 0 20px rgba(167, 139, 250, 0.25);
  }

  .news-search-icon {
    position: absolute;
    left: 1.15rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    pointer-events: none;
  }

  /* Featured Article Banner */
  .featured-banner {
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    gap: 2.5rem;
    align-items: center;
    background: linear-gradient(135deg, rgba(24, 24, 32, 0.8) 0%, rgba(14, 14, 20, 0.9) 100%);
    border: 1px solid rgba(167, 139, 250, 0.25);
    border-radius: 24px;
    padding: 2rem;
    margin-bottom: 3.5rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5), 0 0 30px rgba(167, 139, 250, 0.08);
    position: relative;
    overflow: hidden;
  }

  .featured-banner::before {
    content: '';
    position: absolute;
    top: -50px;
    right: -50px;
    width: 250px;
    height: 250px;
    background: radial-gradient(circle, rgba(167, 139, 250, 0.18), transparent 70%);
    pointer-events: none;
  }

  .featured-img-wrap {
    position: relative;
    border-radius: 18px;
    overflow: hidden;
    height: 340px;
    background: #111116;
  }

  .featured-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
  }

  .featured-banner:hover .featured-img-wrap img {
    transform: scale(1.03);
  }

  .featured-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .featured-meta {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
    font-size: 0.82rem;
    color: #94a3b8;
  }

  .featured-badge {
    background: linear-gradient(135deg, #a78bfa, #818cf8);
    color: #09090b;
    font-size: 0.74rem;
    font-weight: 700;
    padding: 0.3rem 0.75rem;
    border-radius: 9999px;
    letter-spacing: 0.03em;
    text-transform: uppercase;
  }

  .featured-title {
    font-size: clamp(1.4rem, 2.2vw, 1.95rem);
    font-weight: 800;
    line-height: 1.25;
    letter-spacing: -0.02em;
    margin-bottom: 1rem;
  }

  .featured-title a {
    color: #ffffff;
    text-decoration: none;
    transition: color 0.2s ease;
  }

  .featured-title a:hover {
    color: var(--accent);
  }

  .featured-excerpt {
    color: #94a3b8;
    font-size: 0.98rem;
    line-height: 1.65;
    margin-bottom: 1.75rem;
  }

  .btn-read {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.75rem 1.4rem;
    border-radius: 9999px;
    background: #ffffff;
    color: #09090b;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    align-self: flex-start;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  }

  .btn-read:hover {
    background: #a78bfa;
    color: #000000;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(167, 139, 250, 0.4);
  }

  .btn-read svg {
    transition: transform 0.2s ease;
  }

  .btn-read:hover svg {
    transform: translateX(4px);
  }

  /* News Grid */
  .news-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
    gap: 2rem;
  }

  .news-card-inner {
    display: flex;
    flex-direction: column;
    height: 100%;
  }

  .news-thumb-box {
    position: relative;
    height: 220px;
    overflow: hidden;
    background: #111116;
  }

  .news-thumb-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
  }

  .glass-card:hover .news-thumb-box img {
    transform: scale(1.05);
  }

  .news-card-body {
    padding: 1.6rem;
    display: flex;
    flex-direction: column;
    flex: 1;
  }

  .news-card-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.85rem;
    font-size: 0.8rem;
    color: #94a3b8;
  }

  .news-cat-pill {
    padding: 0.25rem 0.65rem;
    border-radius: 9999px;
    background: rgba(167, 139, 250, 0.12);
    border: 1px solid rgba(167, 139, 250, 0.25);
    color: var(--accent);
    font-weight: 600;
    font-size: 0.74rem;
  }

  .news-card-title {
    font-size: 1.22rem;
    font-weight: 700;
    line-height: 1.35;
    letter-spacing: -0.01em;
    margin-bottom: 0.85rem;
  }

  .news-card-title a {
    color: #ffffff;
    text-decoration: none;
    transition: color 0.2s ease;
  }

  .news-card-title a:hover {
    color: var(--accent);
  }

  .news-card-desc {
    color: #94a3b8;
    font-size: 0.9rem;
    line-height: 1.6;
    margin-bottom: 1.5rem;
    flex: 1;
  }

  .news-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 1.1rem;
    border-top: 1px solid rgba(255, 255, 255, 0.06);
    font-size: 0.84rem;
  }

  .news-author {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    color: #e2e8f0;
  }

  .news-author-avatar {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: linear-gradient(135deg, #a78bfa, #6366f1);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.72rem;
    font-weight: 700;
  }

  .news-link-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    color: var(--accent);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.85rem;
    transition: transform 0.2s ease, color 0.2s ease;
  }

  .news-link-btn:hover {
    color: #ffffff;
    transform: translateX(3px);
  }

  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 5rem 1.5rem;
    background: rgba(255, 255, 255, 0.02);
    border: 1px dashed rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    max-width: 500px;
    margin: 2rem auto;
  }

  .empty-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    background: rgba(167, 139, 250, 0.1);
    color: var(--accent);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
  }

  @media (max-width: 900px) {
    .featured-banner {
      grid-template-columns: 1fr;
      padding: 1.5rem;
    }
    .featured-img-wrap {
      height: 240px;
    }
    .news-grid {
      grid-template-columns: 1fr;
    }
  }
</style>
@endsection

@section('content')
<div class="page-hero">
  <div class="badge-pill">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
    Wawasan & Publikasi Resmi
  </div>
  <h1 class="page-title">
    Kabar & Analisis <span class="text-gradient">Teknologi Terkini</span>
  </h1>
  <p class="page-subtitle">
    Eksplorasi wawasan arsitektur sistem berskala besar, implementasi Private AI, zero-trust cybersecurity, dan inovasi rekayasa software dari para praktisi Coretech.
  </p>

  <form action="{{ route('berita.public') }}" method="GET" class="news-search-bar">
    <svg class="news-search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="11" cy="11" r="8"></circle>
      <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
    </svg>
    <input 
      type="text" 
      name="q" 
      class="news-search-input" 
      placeholder="Cari artikel berdasarkan topik atau kata kunci..."
      value="{{ request('q') }}"
    >
  </form>
</div>

<div class="content-container">
  {{-- Show Featured Article if on page 1 without search --}}
  @if(!request('q') && request('page', 1) == 1 && $featuredBerita)
    <div class="featured-banner">
      <div class="featured-img-wrap">
        @if($featuredBerita->gambar)
          <img src="{{ $featuredBerita->gambar }}" alt="{{ $featuredBerita->judul }}">
        @else
          <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #1e1b4b, #0f172a); display: flex; align-items: center; justify-content: center; color: #a78bfa;">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
          </div>
        @endif
      </div>
      <div class="featured-content">
        <div class="featured-meta">
          <span class="featured-badge">Artikel Utama</span>
          <span>•</span>
          <span>{{ $featuredBerita->created_at ? $featuredBerita->created_at->format('d M Y') : date('d M Y') }}</span>
          <span>•</span>
          <span>{{ $featuredBerita->created_at ? $featuredBerita->created_at->diffForHumans() : 'Baru' }}</span>
        </div>
        <h2 class="featured-title">
          <a href="{{ route('berita.show', $featuredBerita->uuid) }}">{{ $featuredBerita->judul }}</a>
        </h2>
        <p class="featured-excerpt">
          {{ \Illuminate\Support\Str::limit($featuredBerita->keterangan, 190) }}
        </p>
        <a href="{{ route('berita.show', $featuredBerita->uuid) }}" class="btn-read">
          Baca Selengkapnya
          <svg width="15" height="13" viewBox="0 0 12 10" fill="none" aria-hidden="true">
            <path d="M0.8 5h10M7.1 1.4 10.9 5l-3.8 3.6" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>
      </div>
    </div>
  @endif

  @if($beritas->count() > 0)
    <div class="news-grid">
      @foreach($beritas as $item)
        <article class="glass-card">
          <div class="news-card-inner">
            <div class="news-thumb-box">
              @if($item->gambar)
                <img src="{{ $item->gambar }}" alt="{{ $item->judul }}" loading="lazy">
              @else
                <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #181822, #0d0d12); display: flex; align-items: center; justify-content: center; color: #a78bfa;">
                  <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polygon points="12 2 2 7 12 12 22 7 12 2"/></svg>
                </div>
              @endif
            </div>

            <div class="news-card-body">
              <div class="news-card-meta">
                <span class="news-cat-pill">Teknologi & Solusi</span>
                <span>{{ $item->created_at ? $item->created_at->format('d M Y') : date('d M Y') }}</span>
              </div>

              <h3 class="news-card-title">
                <a href="{{ route('berita.show', $item->uuid) }}">{{ $item->judul }}</a>
              </h3>

              <p class="news-card-desc">
                {{ \Illuminate\Support\Str::limit($item->keterangan, 125) }}
              </p>

              <div class="news-card-footer">
                <div class="news-author">
                  <div class="news-author-avatar">CT</div>
                  <span>Editorial Coretech</span>
                </div>
                <a href="{{ route('berita.show', $item->uuid) }}" class="news-link-btn">
                  Baca Artikel
                  <svg width="13" height="11" viewBox="0 0 12 10" fill="none">
                    <path d="M0.8 5h10M7.1 1.4 10.9 5l-3.8 3.6" stroke="currentColor" stroke-width="1.35" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </a>
              </div>
            </div>
          </div>
        </article>
      @endforeach
    </div>

    <div class="pagination-wrap">
      {{ $beritas->links() }}
    </div>
  @else
    <div class="empty-state">
      <div class="empty-icon">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
      </div>
      <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; color: #ffffff;">Tidak Ada Artikel Ditemukan</h3>
      <p style="color: #94a3b8; font-size: 0.92rem; margin-bottom: 1.5rem;">
        Tidak ada berita yang cocok dengan kata kunci "{{ request('q') }}". Silakan gunakan kata kunci lain.
      </p>
      <a href="{{ route('berita.public') }}" class="btn-read" style="margin: 0 auto;">
        Lihat Semua Berita
      </a>
    </div>
  @endif
</div>
@endsection
