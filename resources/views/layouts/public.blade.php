<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'PT Coretech Rekayasa Digital — Enterprise IT Solution & Software House')</title>
  <meta name="description" content="@yield('meta_description', 'Penyedia Enterprise IT Solution, Custom Software Architecture, dan Digital Transformation terkemuka di Indonesia.')">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    :root {
      --bg: #060608;
      --bg-card: rgba(18, 18, 24, 0.7);
      --bg-card-hover: rgba(28, 28, 38, 0.85);
      --border-card: rgba(255, 255, 255, 0.08);
      --border-card-hover: rgba(167, 139, 250, 0.35);
      --ink: #ffffff;
      --ink-muted: #94a3b8;
      --ink-dim: #64748b;
      --accent: #a78bfa;
      --accent-rgb: 167, 139, 250;
      --accent-glow: rgba(167, 139, 250, 0.25);
      --panel: #111116;
      --white-btn: #f8fafc;
      --btn-ink: #09090b;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    html {
      scroll-behavior: smooth;
      scroll-padding-top: 85px;
    }

    body {
      background-color: var(--bg);
      color: var(--ink);
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      line-height: 1.6;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      overflow-x: hidden;
      -webkit-font-smoothing: antialiased;
    }

    /* Ambient background gradient mesh */
    .bg-mesh {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: 600px;
      pointer-events: none;
      z-index: 0;
      background: radial-gradient(circle at 50% -10%, rgba(167, 139, 250, 0.15), transparent 70%),
                  radial-gradient(circle at 10% 20%, rgba(99, 102, 241, 0.08), transparent 50%),
                  radial-gradient(circle at 90% 30%, rgba(14, 165, 233, 0.08), transparent 50%);
    }

    /* ============================================================
       TOP NAVIGATION BAR
       ============================================================ */
    .site-nav {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: 72px;
      z-index: 1000;
      display: flex;
      align-items: center;
      background: rgba(8, 8, 12, 0.88);
      -webkit-backdrop-filter: blur(20px);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
      transition: background 0.3s ease, border-color 0.3s ease;
    }

    .nav-container {
      max-width: 1360px;
      width: 100%;
      margin: 0 auto;
      padding: 0 1.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1.25rem;
    }

    .logo {
      font-weight: 800;
      font-size: 1.35rem;
      letter-spacing: -0.02em;
      line-height: 1;
      color: var(--ink);
      text-decoration: none;
      white-space: nowrap;
      display: inline-flex;
      align-items: center;
      gap: 0.65rem;
      flex-shrink: 0;
    }

    .logo-icon {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      background: linear-gradient(135deg, rgba(167, 139, 250, 0.25), rgba(99, 102, 241, 0.15));
      border: 1px solid rgba(167, 139, 250, 0.4);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--accent);
    }

    .logo span {
      background: linear-gradient(135deg, #ffffff 40%, #a78bfa 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 0.35rem;
      margin: 0 auto;
      list-style: none;
    }

    .nav-links a {
      color: #cbd5e1;
      text-decoration: none;
      font-size: 0.88rem;
      font-weight: 500;
      letter-spacing: -0.01em;
      line-height: 1;
      padding: 0.55rem 0.95rem;
      border-radius: 9999px;
      transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
      white-space: nowrap;
      display: inline-flex;
      align-items: center;
    }

    .nav-links a:hover {
      color: #ffffff;
      background: rgba(255, 255, 255, 0.08);
    }

    .nav-links a.active {
      color: #ffffff;
      background: rgba(167, 139, 250, 0.18);
      border: 1px solid rgba(167, 139, 250, 0.3);
      font-weight: 600;
    }

    .nav-actions {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      flex-shrink: 0;
    }

    .btn-login {
      display: inline-flex;
      align-items: center;
      height: 38px;
      padding: 0 1.1rem;
      border-radius: 9999px;
      background: rgba(255, 255, 255, 0.06);
      border: 1px solid rgba(255, 255, 255, 0.1);
      color: #e2e8f0;
      font-size: 0.86rem;
      font-weight: 500;
      text-decoration: none;
      white-space: nowrap;
      transition: all 0.2s ease;
    }

    .btn-login:hover {
      background: rgba(255, 255, 255, 0.12);
      color: #ffffff;
      border-color: rgba(255, 255, 255, 0.2);
    }

    .btn-cta {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      height: 38px;
      padding: 0 1.25rem;
      border-radius: 9999px;
      background: #f8fafc;
      color: #09090b;
      font-size: 0.86rem;
      font-weight: 600;
      text-decoration: none;
      white-space: nowrap;
      transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
      box-shadow: 0 4px 15px rgba(255, 255, 255, 0.15);
    }

    .btn-cta:hover {
      background: #ffffff;
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(167, 139, 250, 0.3);
    }

    .btn-cta svg {
      transition: transform 0.2s ease;
    }

    .btn-cta:hover svg {
      transform: translateX(3px);
    }

    /* Burger button */
    .burger-btn {
      display: none;
      width: 42px;
      height: 42px;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.06);
      border: 1px solid rgba(255, 255, 255, 0.1);
      color: #e2e8f0;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      padding: 0;
    }

    .mobile-drawer {
      position: fixed;
      top: 72px;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(6, 6, 8, 0.98);
      -webkit-backdrop-filter: blur(25px);
      backdrop-filter: blur(25px);
      z-index: 999;
      display: none;
      flex-direction: column;
      padding: 1.5rem;
      gap: 0.75rem;
      overflow-y: auto;
    }

    .mobile-drawer.open {
      display: flex;
    }

    .mobile-drawer a {
      color: #e2e8f0;
      font-size: 1.05rem;
      font-weight: 500;
      padding: 0.85rem 1rem;
      border-radius: 10px;
      text-decoration: none;
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid rgba(255, 255, 255, 0.05);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .mobile-drawer a.active {
      background: rgba(167, 139, 250, 0.15);
      border-color: rgba(167, 139, 250, 0.3);
      color: #ffffff;
      font-weight: 600;
    }

    @media (max-width: 1024px) {
      .nav-links, .nav-actions {
        display: none;
      }
      .burger-btn {
        display: inline-flex;
      }
    }

    /* ============================================================
       PAGE CONTENT CONTAINER
       ============================================================ */
    .page-main {
      flex: 1;
      padding-top: 72px;
      position: relative;
      z-index: 1;
    }

    /* Page Hero Banner */
    .page-hero {
      padding: 4.5rem 1.5rem 3rem;
      text-align: center;
      max-width: 900px;
      margin: 0 auto;
    }

    .badge-pill {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.35rem 0.9rem;
      border-radius: 9999px;
      background: rgba(167, 139, 250, 0.12);
      border: 1px solid rgba(167, 139, 250, 0.28);
      color: var(--accent);
      font-size: 0.82rem;
      font-weight: 600;
      letter-spacing: 0.02em;
      margin-bottom: 1.25rem;
    }

    .page-title {
      font-size: clamp(2rem, 4.5vw, 3.25rem);
      font-weight: 800;
      line-height: 1.15;
      letter-spacing: -0.03em;
      margin-bottom: 1.1rem;
      color: #ffffff;
    }

    .page-title .text-gradient {
      background: linear-gradient(135deg, #ffffff 30%, #a78bfa 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .page-subtitle {
      font-size: clamp(1rem, 1.8vw, 1.15rem);
      color: var(--ink-muted);
      max-width: 680px;
      margin: 0 auto;
      line-height: 1.65;
    }

    /* Shared Content Section */
    .content-container {
      max-width: 1360px;
      margin: 0 auto;
      padding: 0 1.5rem 5rem;
    }

    /* Shared Card Styles */
    .glass-card {
      background: var(--bg-card);
      border: 1px solid var(--border-card);
      border-radius: 20px;
      backdrop-filter: blur(12px);
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      overflow: hidden;
    }

    .glass-card:hover {
      background: var(--bg-card-hover);
      border-color: var(--border-card-hover);
      transform: translateY(-4px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), 0 0 25px rgba(167, 139, 250, 0.12);
    }

    /* Pagination Styling */
    .pagination-wrap {
      display: flex;
      justify-content: center;
      margin-top: 3.5rem;
    }

    .pagination-wrap nav {
      display: flex;
      gap: 0.5rem;
      align-items: center;
    }

    .pagination-wrap .page-item,
    .pagination-wrap .relative.inline-flex {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      color: #e2e8f0;
      padding: 0.5rem 0.95rem;
      border-radius: 10px;
      text-decoration: none;
      font-size: 0.88rem;
      transition: all 0.2s ease;
    }

    /* ============================================================
       SITE FOOTER
       ============================================================ */
    .site-footer {
      background: #040406;
      border-top: 1px solid rgba(255, 255, 255, 0.07);
      padding: 5rem 1.5rem 2.5rem;
      position: relative;
      z-index: 1;
      margin-top: auto;
    }

    .footer-container {
      max-width: 1360px;
      margin: 0 auto;
    }

    .footer-grid {
      display: grid;
      grid-template-columns: 1.8fr 1.1fr 1fr 1.3fr;
      gap: 3.5rem;
      margin-bottom: 4rem;
    }

    .footer-brand .f-logo {
      font-weight: 800;
      font-size: 1.45rem;
      text-decoration: none;
      color: #ffffff;
      display: inline-flex;
      align-items: center;
      gap: 0.65rem;
      margin-bottom: 1rem;
    }

    .footer-brand .f-logo span {
      background: linear-gradient(135deg, #ffffff 40%, #a78bfa 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .footer-brand p {
      color: #94a3b8;
      font-size: 0.92rem;
      line-height: 1.7;
      margin-bottom: 1.5rem;
    }

    .cert-badges {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
    }

    .cert-pill {
      font-size: 0.72rem;
      font-weight: 600;
      padding: 0.3rem 0.75rem;
      border-radius: 9999px;
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid rgba(255, 255, 255, 0.08);
      color: #cbd5e1;
    }

    .footer-title {
      font-size: 0.95rem;
      font-weight: 700;
      color: #ffffff;
      letter-spacing: -0.01em;
      margin-bottom: 1.25rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .footer-links {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
    }

    .footer-links a {
      color: #94a3b8;
      text-decoration: none;
      font-size: 0.9rem;
      transition: color 0.2s ease, transform 0.2s ease;
      display: inline-block;
    }

    .footer-links a:hover {
      color: #ffffff;
      transform: translateX(3px);
    }

    .contact-item {
      display: flex;
      gap: 0.85rem;
      margin-bottom: 1.1rem;
      font-size: 0.9rem;
      color: #94a3b8;
      line-height: 1.5;
    }

    .contact-item svg {
      flex-shrink: 0;
      margin-top: 0.2rem;
      color: var(--accent);
    }

    .contact-item a {
      color: #e2e8f0;
      text-decoration: none;
      transition: color 0.2s ease;
    }

    .contact-item a:hover {
      color: var(--accent);
    }

    .social-links {
      display: flex;
      gap: 0.75rem;
      margin-top: 1.5rem;
      flex-wrap: wrap;
    }

    .social-btn {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid rgba(255, 255, 255, 0.08);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #cbd5e1;
      text-decoration: none;
      transition: all 0.2s ease;
    }

    .social-btn:hover {
      background: rgba(167, 139, 250, 0.2);
      border-color: rgba(167, 139, 250, 0.4);
      color: #ffffff;
      transform: translateY(-2px);
    }

    .footer-bottom {
      border-top: 1px solid rgba(255, 255, 255, 0.06);
      padding-top: 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 0.85rem;
      color: #64748b;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .legal-links {
      display: flex;
      gap: 1.5rem;
    }

    .legal-links a {
      color: #64748b;
      text-decoration: none;
      transition: color 0.2s ease;
    }

    .legal-links a:hover {
      color: #cbd5e1;
    }

    @media (max-width: 992px) {
      .footer-grid {
        grid-template-columns: 1fr 1fr;
        gap: 2.5rem;
      }
    }

    @media (max-width: 640px) {
      .footer-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
      }
      .footer-bottom {
        flex-direction: column;
        text-align: center;
      }
      .legal-links {
        justify-content: center;
      }
    }
  </style>

  @yield('styles')
</head>
<body>
  <div class="bg-mesh"></div>

  <!-- ============================================================
       TOP NAVIGATION BAR
       ============================================================ -->
  <header class="site-nav" id="mainNav">
    <div class="nav-container">
      <a href="{{ route('home') }}" class="logo">
        <div class="logo-icon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="12 2 2 7 12 12 22 7 12 2"/>
            <polyline points="2 17 12 22 22 17"/>
            <polyline points="2 12 12 17 22 12"/>
          </svg>
        </div>
        <span>{{ $profil->namaPerusahaan ?? 'Coretech' }}</span>
      </a>

      <nav class="nav-links" aria-label="Primary">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
        <a href="{{ route('home') }}#advantages">Keunggulan</a>
        <a href="{{ route('home') }}#services">Layanan</a>
        <a href="{{ route('portofolio.public') }}" class="{{ request()->routeIs('portofolio.*') ? 'active' : '' }}">Portofolio</a>
        <a href="{{ route('berita.public') }}" class="{{ request()->routeIs('berita.*') ? 'active' : '' }}">Berita</a>
        <a href="{{ route('home') }}#faq">FAQ</a>
        <a href="{{ route('home') }}#contact">Kontak</a>
      </nav>

      <div class="nav-actions">
        <a href="{{ route('home') }}#consultation" class="btn-cta">
          Konsultasi
          <svg width="14" height="12" viewBox="0 0 12 10" fill="none" aria-hidden="true">
            <path d="M0.8 5h10M7.1 1.4 10.9 5l-3.8 3.6" stroke="currentColor" stroke-width="1.35" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>
      </div>

      <button class="burger-btn" id="burgerBtn" aria-label="Toggle navigation menu">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="3" y1="12" x2="21" y2="12"></line>
          <line x1="3" y1="6" x2="21" y2="6"></line>
          <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
      </button>
    </div>
  </header>

  <!-- Mobile Drawer Menu -->
  <div class="mobile-drawer" id="mobileDrawer">
    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
      Beranda
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
    </a>
    <a href="{{ route('home') }}#advantages">
      Keunggulan Solusi
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
    </a>
    <a href="{{ route('home') }}#services">
      Layanan & Master Jasa
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
    </a>
    <a href="{{ route('portofolio.public') }}" class="{{ request()->routeIs('portofolio.*') ? 'active' : '' }}">
      Portofolio Proyek
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
    </a>
    <a href="{{ route('berita.public') }}" class="{{ request()->routeIs('berita.*') ? 'active' : '' }}">
      Berita & Wawasan
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
    </a>
    <a href="{{ route('home') }}#faq">
      Tanya Jawab (FAQ)
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
    </a>
    <a href="{{ route('home') }}#consultation">
      Form Konsultasi
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
    </a>
    <a href="{{ route('home') }}#contact">
      Profil & Kontak
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
    </a>

    <div style="margin-top: 1rem; display: flex; flex-direction: column; gap: 0.75rem;">
      <a href="{{ route('home') }}#consultation" style="background: #ffffff; color: #09090b; justify-content: center; font-weight: 700;">Ajukan Konsultasi Gratis</a>
    </div>
  </div>

  <!-- ============================================================
       MAIN CONTENT INJECTION
       ============================================================ -->
  <main class="page-main">
    @yield('content')
  </main>

  <!-- ============================================================
       SITE FOOTER
       ============================================================ -->
  <footer id="contact" class="site-footer">
    <div class="footer-container">
      <div class="footer-grid">
        <div class="footer-brand">
          <a href="{{ route('home') }}" class="f-logo">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="color:#a78bfa">
              <polygon points="12 2 2 7 12 12 22 7 12 2"/>
              <polyline points="2 17 12 22 22 17"/>
              <polyline points="2 12 12 17 22 12"/>
            </svg>
            <span>{{ $profil->namaPerusahaan ?? 'Coretech' }}</span>
          </a>
          <p>
            {{ $profil->namaPerusahaan ?? 'PT Coretech Rekayasa Digital' }} adalah penyedia solusi IT (Enterprise IT Solution) dan software engineering terkemuka di Indonesia. Kami berdedikasi membangun ekosistem teknologi kelas dunia yang andal, aman, scalable, dan berdaya saing global.
          </p>
          <div class="cert-badges">
            <span class="cert-pill">ISO 27001 Certified</span>
            <span class="cert-pill">PSE Terdaftar Kominfo</span>
            <span class="cert-pill">Enterprise SLA 99.9%</span>
          </div>

          @if($profil)
            <div class="social-links">
              @if($profil->instagram)
                <a href="https://instagram.com/{{ ltrim($profil->instagram, '@') }}" target="_blank" class="social-btn" title="Instagram">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                  </svg>
                </a>
              @endif
              @if($profil->tiktok)
                <a href="https://tiktok.com/{{ $profil->tiktok }}" target="_blank" class="social-btn" title="TikTok">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path>
                  </svg>
                </a>
              @endif
              @if($profil->treads)
                <a href="https://threads.net/{{ $profil->treads }}" target="_blank" class="social-btn" title="Threads">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M16 12a4 4 0 1 0-8 0 4 4 0 0 0 8 0zm0 0v1.5a2.5 2.5 0 0 0 5 0V12a9 9 0 1 0-9 9"></path>
                  </svg>
                </a>
              @endif
              @if($profil->linkedIN)
                <a href="{{ $profil->linkedIN }}" target="_blank" class="social-btn" title="LinkedIn">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                    <rect x="2" y="9" width="4" height="12"></rect>
                    <circle cx="4" cy="4" r="2"></circle>
                  </svg>
                </a>
              @endif
            </div>
          @endif
        </div>

        <div>
          <h4 class="footer-title">Layanan IT Solution</h4>
          <ul class="footer-links">
            <li><a href="{{ route('home') }}#services">Custom Web Application Enterprise</a></li>
            <li><a href="{{ route('home') }}#services">Mobile App Development (iOS & Android)</a></li>
            <li><a href="{{ route('home') }}#services">Enterprise ERP & Core Systems</a></li>
            <li><a href="{{ route('home') }}#services">Cloud Infrastructure & DevOps CI/CD</a></li>
            <li><a href="{{ route('home') }}#services">AI & Machine Learning Integration</a></li>
            <li><a href="{{ route('home') }}#services">Penetration Testing & Security Audit</a></li>
          </ul>
        </div>

        <div>
          <h4 class="footer-title">Navigasi Utama</h4>
          <ul class="footer-links">
            <li><a href="{{ route('home') }}">Beranda Utama</a></li>
            <li><a href="{{ route('home') }}#advantages">Keunggulan Rekayasa</a></li>
            <li><a href="{{ route('portofolio.public') }}">Daftar Portofolio</a></li>
            <li><a href="{{ route('berita.public') }}">Kabar & Berita IT</a></li>
            <li><a href="{{ route('home') }}#faq">Tanya Jawab (FAQ)</a></li>
            <li><a href="{{ route('home') }}#consultation">Konsultasi Project</a></li>
          </ul>
        </div>

        <div>
          <h4 class="footer-title">Kontak & Kantor</h4>
          
          <div class="contact-item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
              <circle cx="12" cy="10" r="3"></circle>
            </svg>
            <div>
              <strong style="color: #ffffff;">Head Office:</strong><br>
              {{ $profil->alamat ?? 'Cyber 2 Tower Lantai 18, Jl. H.R. Rasuna Said, Jakarta Selatan 12950' }}
            </div>
          </div>

          <div class="contact-item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
            </svg>
            <div>
              <a href="tel:{{ $profil->nomorTelepon ?? '+6281198765432' }}">{{ $profil->nomorTelepon ?? '+62 811-9876-5432' }}</a>
            </div>
          </div>

          <div class="contact-item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
              <polyline points="22,6 12,13 2,6"></polyline>
            </svg>
            <div>
              <a href="mailto:{{ $profil->email ?? 'halo@coretech.id' }}">{{ $profil->email ?? 'halo@coretech.id' }}</a>
            </div>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        <div>
          &copy; {{ date('Y') }} {{ $profil->namaPerusahaan ?? 'PT Coretech Rekayasa Digital' }}. Hak Cipta Dilindungi Undang-Undang.
        </div>
        <div class="legal-links">
          <a href="{{ route('home') }}#advantages">Tentang Kami</a>
          <a href="{{ route('home') }}#faq">Privasi & Keamanan</a>
          <a href="{{ route('home') }}#contact">Syarat Ketentuan</a>
        </div>
      </div>
    </div>
  </footer>

  <script>
    // Mobile Drawer Toggle
    const burgerBtn = document.getElementById('burgerBtn');
    const mobileDrawer = document.getElementById('mobileDrawer');
    if (burgerBtn && mobileDrawer) {
      burgerBtn.addEventListener('click', () => {
        mobileDrawer.classList.toggle('open');
      });
      // Close drawer on link click
      mobileDrawer.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
          mobileDrawer.classList.remove('open');
        });
      });
    }
  </script>

  @yield('scripts')
</body>
</html>
