@extends('layouts.public')

@section('title', $berita->judul . ' — ' . ($profil->namaPerusahaan ?? 'PT Coretech Rekayasa Digital'))
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($berita->keterangan), 155))

@section('styles')
<style>
  .article-layout {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 360px;
    gap: 3.5rem;
    align-items: start;
    margin-top: 1.5rem;
  }

  /* Breadcrumb */
  .breadcrumb-nav {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    font-size: 0.86rem;
    color: #94a3b8;
    margin-bottom: 2rem;
    flex-wrap: wrap;
  }

  .breadcrumb-nav a {
    color: #94a3b8;
    text-decoration: none;
    transition: color 0.2s ease;
  }

  .breadcrumb-nav a:hover {
    color: #ffffff;
  }

  .breadcrumb-nav .separator {
    color: #475569;
  }

  .breadcrumb-nav .current {
    color: var(--accent);
    font-weight: 500;
  }

  /* Article Main */
  .article-main {
    background: var(--bg-card);
    border: 1px solid var(--border-card);
    border-radius: 24px;
    padding: 3rem;
    backdrop-filter: blur(12px);
  }

  .article-header {
    margin-bottom: 2.25rem;
  }

  .article-top-meta {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
    flex-wrap: wrap;
    font-size: 0.85rem;
    color: #94a3b8;
  }

  .article-badge {
    background: rgba(167, 139, 250, 0.15);
    border: 1px solid rgba(167, 139, 250, 0.3);
    color: var(--accent);
    padding: 0.3rem 0.8rem;
    border-radius: 9999px;
    font-weight: 600;
    font-size: 0.78rem;
  }

  .article-title {
    font-size: clamp(1.85rem, 3.2vw, 2.75rem);
    font-weight: 800;
    line-height: 1.2;
    letter-spacing: -0.025em;
    color: #ffffff;
    margin-bottom: 1.5rem;
  }

  .article-author-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.1rem 1.4rem;
    border-radius: 16px;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.06);
    flex-wrap: wrap;
    gap: 1rem;
  }

  .author-left {
    display: flex;
    align-items: center;
    gap: 0.85rem;
  }

  .author-avatar-lg {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: linear-gradient(135deg, #a78bfa, #6366f1);
    color: #ffffff;
    font-weight: 700;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .author-name-title {
    font-weight: 600;
    color: #ffffff;
    font-size: 0.95rem;
  }

  .author-role-sub {
    font-size: 0.8rem;
    color: #94a3b8;
  }

  /* Cover Image */
  .article-cover {
    width: 100%;
    border-radius: 18px;
    overflow: hidden;
    margin-bottom: 2.5rem;
    background: #111116;
    border: 1px solid rgba(255, 255, 255, 0.08);
  }

  .article-cover img {
    width: 100%;
    height: auto;
    max-height: 520px;
    object-fit: cover;
    display: block;
  }

  /* Content typography */
  .article-body {
    color: #cbd5e1;
    font-size: 1.08rem;
    line-height: 1.85;
    letter-spacing: -0.01em;
  }

  .article-body p {
    margin-bottom: 1.5rem;
  }

  .article-quote-box {
    margin: 2.5rem 0;
    padding: 1.75rem 2rem;
    background: rgba(167, 139, 250, 0.06);
    border-left: 4px solid var(--accent);
    border-radius: 0 16px 16px 0;
    font-size: 1.15rem;
    font-style: italic;
    color: #f1f5f9;
    line-height: 1.6;
  }

  .article-divider {
    height: 1px;
    background: rgba(255, 255, 255, 0.08);
    margin: 3rem 0 2rem;
  }

  /* Share and back buttons */
  .article-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1.5rem;
  }

  .share-group {
    display: flex;
    align-items: center;
    gap: 0.65rem;
  }

  .share-label {
    font-size: 0.85rem;
    color: #94a3b8;
    font-weight: 500;
  }

  .share-btn {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.06);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #e2e8f0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .share-btn:hover {
    background: rgba(167, 139, 250, 0.25);
    border-color: rgba(167, 139, 250, 0.5);
    color: #ffffff;
    transform: translateY(-2px);
  }

  .btn-back-news {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.25rem;
    border-radius: 9999px;
    background: rgba(255, 255, 255, 0.06);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #ffffff;
    font-size: 0.88rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .btn-back-news:hover {
    background: rgba(255, 255, 255, 0.12);
    transform: translateX(-3px);
  }

  /* ============================================================
     SIDEBAR: LIST BERITA KECIL & WIDGETS
     ============================================================ */
  .article-sidebar {
    position: sticky;
    top: 95px;
    display: flex;
    flex-direction: column;
    gap: 2rem;
  }

  .sidebar-widget {
    background: var(--bg-card);
    border: 1px solid var(--border-card);
    border-radius: 20px;
    padding: 1.75rem;
    backdrop-filter: blur(12px);
  }

  .widget-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.25rem;
    padding-bottom: 0.85rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.07);
  }

  .widget-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #ffffff;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .widget-title svg {
    color: var(--accent);
  }

  /* List Berita Kecil Items */
  .small-news-list {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
  }

  .small-news-card {
    display: grid;
    grid-template-columns: 80px 1fr;
    gap: 1rem;
    text-decoration: none;
    align-items: center;
    padding: 0.6rem;
    border-radius: 14px;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    background: transparent;
  }

  .small-news-card:hover {
    background: rgba(255, 255, 255, 0.05);
    transform: translateX(3px);
  }

  .small-thumb {
    width: 80px;
    height: 80px;
    border-radius: 12px;
    overflow: hidden;
    background: #111116;
    border: 1px solid rgba(255, 255, 255, 0.08);
    flex-shrink: 0;
  }

  .small-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
  }

  .small-news-card:hover .small-thumb img {
    transform: scale(1.08);
  }

  .small-news-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .small-news-date {
    font-size: 0.74rem;
    color: #94a3b8;
    margin-bottom: 0.35rem;
    display: flex;
    align-items: center;
    gap: 0.35rem;
  }

  .small-news-title {
    font-size: 0.92rem;
    font-weight: 600;
    line-height: 1.35;
    color: #e2e8f0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color 0.2s ease;
  }

  .small-news-card:hover .small-news-title {
    color: var(--accent);
  }

  /* Consultation Card Widget */
  .consult-sidebar-card {
    background: linear-gradient(135deg, rgba(167, 139, 250, 0.12) 0%, rgba(99, 102, 241, 0.08) 100%);
    border: 1px solid rgba(167, 139, 250, 0.3);
    border-radius: 20px;
    padding: 1.75rem;
    text-align: center;
    position: relative;
    overflow: hidden;
  }

  .consult-sidebar-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: linear-gradient(135deg, #a78bfa, #6366f1);
    color: #09090b;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.1rem;
    box-shadow: 0 10px 20px rgba(167, 139, 250, 0.3);
  }

  .consult-sidebar-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 0.6rem;
  }

  .consult-sidebar-desc {
    font-size: 0.88rem;
    color: #cbd5e1;
    line-height: 1.55;
    margin-bottom: 1.25rem;
  }

  .btn-consult-sidebar {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    width: 100%;
    padding: 0.8rem 1rem;
    border-radius: 9999px;
    background: #ffffff;
    color: #09090b;
    font-size: 0.88rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  }

  .btn-consult-sidebar:hover {
    background: var(--accent);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(167, 139, 250, 0.4);
  }

  /* Toast Notification */
  .toast-notification {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    background: #181824;
    border: 1px solid rgba(167, 139, 250, 0.4);
    color: #ffffff;
    padding: 0.85rem 1.4rem;
    border-radius: 12px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.9rem;
    font-weight: 500;
    z-index: 9999;
    opacity: 0;
    pointer-events: none;
    transform: translateY(15px);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
  }

  .toast-notification.show {
    opacity: 1;
    pointer-events: auto;
    transform: translateY(0);
  }

  @media (max-width: 1024px) {
    .article-layout {
      grid-template-columns: 1fr;
      gap: 3rem;
    }
    .article-main {
      padding: 2rem 1.5rem;
    }
    .article-sidebar {
      position: static;
    }
  }
</style>
@endsection

@section('content')
<div class="content-container" style="padding-top: 2rem;">
  <!-- Breadcrumb -->
  <nav class="breadcrumb-nav" aria-label="Breadcrumb">
    <a href="{{ route('home') }}">Beranda</a>
    <span class="separator">/</span>
    <a href="{{ route('berita.public') }}">Berita</a>
    <span class="separator">/</span>
    <span class="current">{{ \Illuminate\Support\Str::limit($berita->judul, 45) }}</span>
  </nav>

  <div class="article-layout">
    <!-- ============================================================
         LEFT COLUMN: DETAIL BERITA LENGKAP
         ============================================================ -->
    <article class="article-main">
      <header class="article-header">
        <div class="article-top-meta">
          <span class="article-badge">Publikasi Resmi</span>
          <span>•</span>
          <span>{{ $berita->created_at ? $berita->created_at->format('d F Y') : date('d F Y') }}</span>
          <span>•</span>
          <span>{{ $berita->created_at ? $berita->created_at->diffForHumans() : 'Baru' }}</span>
        </div>

        <h1 class="article-title">{{ $berita->judul }}</h1>

        <div class="article-author-card">
          <div class="author-left">
            <div class="author-avatar-lg">CT</div>
            <div>
              <div class="author-name-title">Tim Redaksi & Engineer Coretech</div>
              <div class="author-role-sub">{{ $profil->namaPerusahaan ?? 'PT Coretech Rekayasa Digital' }}</div>
            </div>
          </div>
          <div style="font-size: 0.85rem; color: #94a3b8;">
            Estimasi baca: ~{{ max(2, (int) ceil(str_word_count(strip_tags($berita->keterangan)) / 150)) }} menit
          </div>
        </div>
      </header>

      @if($berita->gambar)
        <div class="article-cover">
          <img src="{{ $berita->gambar }}" alt="{{ $berita->judul }}">
        </div>
      @endif

      <div class="article-body">
        {!! nl2br(e($berita->keterangan)) !!}
      </div>

      <div class="article-quote-box">
        "Transformasi digital bukan sekadar migrasi teknologi, melainkan pembangunan kapabilitas rekayasa yang adaptif terhadap percepatan perubahan bisnis masa depan."
      </div>

      <div class="article-divider"></div>

      <div class="article-actions">
        <a href="{{ route('berita.public') }}" class="btn-back-news">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
          Daftar Berita Lainnya
        </a>

        <div class="share-group">
          <span class="share-label">Bagikan:</span>
          <button type="button" class="share-btn" onclick="copyArticleUrl()" title="Salin Tautan">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
          </button>
          <a href="https://api.whatsapp.com/send?text={{ urlencode($berita->judul . ' ' . url()->current()) }}" target="_blank" class="share-btn" title="Bagikan ke WhatsApp">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
          </a>
          <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" class="share-btn" title="Bagikan ke LinkedIn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
          </a>
        </div>
      </div>
    </article>

    <!-- ============================================================
         RIGHT COLUMN: SIDEBAR DENGAN LIST BERITA KECIL
         ============================================================ -->
    <aside class="article-sidebar">
      <!-- 1. LIST BERITA KECIL WIDGET -->
      <div class="sidebar-widget">
        <div class="widget-header">
          <h3 class="widget-title">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
            Berita Terkini Lainnya
          </h3>
          <span style="font-size: 0.75rem; color: #94a3b8; font-weight: 600;">Update</span>
        </div>

        <div class="small-news-list">
          @forelse($recentBeritas as $recent)
            <a href="{{ route('berita.show', $recent->uuid) }}" class="small-news-card">
              <div class="small-thumb">
                @if($recent->gambar)
                  <img src="{{ $recent->gambar }}" alt="{{ $recent->judul }}" loading="lazy">
                @else
                  <div style="width: 100%; height: 100%; background: #1f1f2e; display: flex; align-items: center; justify-content: center; color: #a78bfa;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polygon points="12 2 2 7 12 12 22 7 12 2"/></svg>
                  </div>
                @endif
              </div>
              <div class="small-news-content">
                <span class="small-news-date">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                  {{ $recent->created_at ? $recent->created_at->format('d M Y') : date('d M Y') }}
                </span>
                <h4 class="small-news-title">{{ $recent->judul }}</h4>
              </div>
            </a>
          @empty
            <p style="font-size: 0.85rem; color: #94a3b8; text-align: center; padding: 1rem 0;">
              Belum ada berita lainnya.
            </p>
          @endforelse
        </div>
      </div>

      <!-- 2. QUICK CONSULTATION CTA CARD -->
      <div class="consult-sidebar-card">
        <div class="consult-sidebar-icon">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
          </svg>
        </div>
        <h3 class="consult-sidebar-title">Rancang Solusi IT Anda</h3>
        <p class="consult-sidebar-desc">
          Konsultasikan kebutuhan software enterprise, arsitektur cloud, atau automasi AI Anda langsung dengan tim lead engineer Coretech.
        </p>
        <a href="{{ route('home') }}#consultation" class="btn-consult-sidebar">
          Konsultasi Gratis
          <svg width="14" height="12" viewBox="0 0 12 10" fill="none">
            <path d="M0.8 5h10M7.1 1.4 10.9 5l-3.8 3.6" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>
      </div>

      <!-- 3. LAYANAN UNGGULAN -->
      @if(isset($masterJasas) && $masterJasas->count() > 0)
        <div class="sidebar-widget">
          <div class="widget-header">
            <h3 class="widget-title">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
              Layanan Rekayasa
            </h3>
          </div>
          <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.75rem;">
            @foreach($masterJasas->take(4) as $jasa)
              <li>
                <a href="{{ route('home') }}#services" style="color: #cbd5e1; text-decoration: none; font-size: 0.88rem; display: flex; align-items: center; justify-content: space-between; padding: 0.4rem 0; transition: color 0.2s ease;">
                  <span>{{ $jasa->jasa }}</span>
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#a78bfa" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
              </li>
            @endforeach
          </ul>
        </div>
      @endif
    </aside>
  </div>
</div>

<!-- Toast notification for copy link -->
<div class="toast-notification" id="copyToast">
  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#a78bfa" stroke-width="2.2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
  <span>Tautan artikel berhasil disalin ke papan klip!</span>
</div>
@endsection

@section('scripts')
<script>
  function copyArticleUrl() {
    navigator.clipboard.writeText(window.location.href).then(() => {
      const toast = document.getElementById('copyToast');
      if (toast) {
        toast.classList.add('show');
        setTimeout(() => {
          toast.classList.remove('show');
        }, 3200);
      }
    }).catch(err => {
      prompt("Salin tautan artikel:", window.location.href);
    });
  }
</script>
@endsection
