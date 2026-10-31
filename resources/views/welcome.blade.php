<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <title>{{ $profil->namaPerusahaan ?? 'Coretech Studio' }} — Enterprise IT Solution & Software House</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=block" rel="stylesheet">
  <style>
    @font-face {
      font-family: 'PJS';
      src: local('Plus Jakarta Sans');
    }

    :root {
      --u: min(calc(100vw / 1280), calc(100dvh / 760));

      --ink:        #ffffff;
      --ink-muted:  #ededed;
      --panel:      #181818;
      --white-btn:  #fdfdfd;
      --btn-ink:    #050505;
      --glass-fill: rgba(0, 0, 0, 0.78);
      --glass-line: rgba(255, 255, 255, 0.09);

      --accent-purple: #a78bfa;
      --accent-glow:   rgba(167, 139, 250, 0.22);
      --card-bg:       rgba(14, 14, 18, 0.75);
      --card-border:   rgba(255, 255, 255, 0.08);

      --dx: 8.5;
      --dy: 13.1;

      --e-reveal: cubic-bezier(.16, 1, .3, 1);
      --e-soft:   cubic-bezier(.25, .8, .3, 1);
    }

    @supports not (height: 100dvh) {
      :root {
        --u: min(calc(100vw / 1280), calc(100vh / 760));
      }
    }

    * {
      box-sizing: border-box;
    }

    html {
      scroll-behavior: smooth;
      scroll-padding-top: 85px;
    }

    body {
      margin: 0;
      padding: 0;
      overflow-x: hidden;
      overflow-y: visible;
      background: #060608;
      color: var(--ink);
      font-family: 'PJS', 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      text-rendering: geometricPrecision;
      min-height: 100vh;
    }

    section[id], footer[id] {
      scroll-margin-top: 85px;
    }

    /* ============================================================
       HERO & VIDEO BACKGROUND
       ============================================================ */
    .hero {
      position: relative;
      width: 100%;
      height: 100dvh;
      min-height: 620px;
      overflow: hidden;
      background: #000;
    }

    @supports not (height: 100dvh) {
      .hero {
        height: 100vh;
      }
    }

    .bg {
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      width: max(100vw, calc(100dvh * 1.6));
      height: max(62.5vw, 100dvh);
      background-color: #000;
    }

    @supports not (height: 100dvh) {
      .bg {
        width: max(100vw, calc(100vh * 1.6));
        height: max(62.5vw, 100vh);
      }
    }

    .bg-video {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: 51% 8%;
      display: block;
      background-color: #000;
      pointer-events: none;
      opacity: 0;
      transition: opacity .9s linear;
    }

    .bg-video.is-active {
      opacity: 1;
    }

    /* ============================================================
       NAVBAR (FIXED WITH BLUR ON SCROLL)
       ============================================================ */
    .nav {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: 72px;
      display: flex;
      align-items: center;
      padding: 0 1.5rem;
      z-index: 100;
      transition: background 0.3s ease, backdrop-filter 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .nav.scrolled {
      background: rgba(8, 8, 12, 0.88);
      -webkit-backdrop-filter: blur(20px);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    .nav-container {
      max-width: 1360px;
      width: 100%;
      margin: 0 auto;
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
      color: var(--accent-purple);
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
      white-space: nowrap;
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
      transition: all .2s cubic-bezier(.16, 1, .3, 1);
    }

    .nav-links a:hover,
    .nav-links a.active {
      color: #fff;
      background: rgba(255, 255, 255, 0.08);
    }

    .nav-actions {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      flex-shrink: 0;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-family: inherit;
      text-decoration: none;
      white-space: nowrap;
      border: 0;
      cursor: pointer;
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
      transition: all .2s ease;
    }

    .btn-login:hover {
      background: rgba(255, 255, 255, 0.12);
      color: #fff;
      border-color: rgba(255, 255, 255, 0.2);
    }

    .btn-nav-start {
      display: inline-flex;
      align-items: center;
      height: 38px;
      padding: 0 1.25rem;
      border-radius: 9999px;
      background: #f8fafc;
      color: #09090b;
      font-size: 0.86rem;
      font-weight: 600;
      gap: 0.5rem;
      text-decoration: none;
      white-space: nowrap;
      transition: all .2s cubic-bezier(.16, 1, .3, 1);
      box-shadow: 0 4px 15px rgba(255, 255, 255, 0.15);
    }

    .btn-nav-start:hover {
      background: #fff;
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(167, 139, 250, 0.3);
    }

    .btn-nav-start .arw {
      width: 12px;
      height: 10px;
    }

    .burger {
      display: none;
      margin-left: auto;
      width: calc(40 * var(--u));
      height: calc(30 * var(--u));
      align-items: center;
      justify-content: center;
      background: var(--panel);
      border-radius: calc(15 * var(--u));
      border: 0;
      cursor: pointer;
      padding: 0;
    }

    .burger span {
      display: block;
      width: 16px;
      height: 1.5px;
      background: #ededed;
      border-radius: 2px;
      position: relative;
    }

    .burger span::before,
    .burger span::after {
      content: "";
      position: absolute;
      left: 0;
      width: 16px;
      height: 1.5px;
      background: #ededed;
      border-radius: 2px;
    }

    .burger span::before {
      top: -5px;
    }

    .burger span::after {
      top: 5px;
    }

    .arw {
      flex: 0 0 auto;
      display: block;
      transition: transform 0.2s ease;
    }

    .btn:hover .arw {
      transform: translateX(2px);
    }

    /* ============================================================
       HERO INNER CONTENT
       ============================================================ */
    .hero-inner {
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%) translate(calc(var(--dx) * var(--u)), calc(var(--dy) * var(--u)));
      width: max-content;
      text-align: center;
      z-index: 2;
    }

    h1 {
      margin: 0;
      font-weight: 500;
      font-size: calc(89 * var(--u));
      line-height: calc(90 * var(--u));
      letter-spacing: calc(-1 * var(--u));
      color: var(--ink);
    }

    .ln {
      display: block;
    }

    .ln-i {
      display: block;
    }

    .sub {
      margin: calc(16.1 * var(--u)) 0 0;
      font-weight: 300;
      font-size: calc(17.4 * var(--u));
      line-height: calc(27 * var(--u));
      letter-spacing: calc(-0.30 * var(--u));
      color: #f6f6f6;
    }

    .ctas {
      margin-top: calc(21.8 * var(--u));
      display: flex;
      align-items: center;
      justify-content: center;
      transform: translateX(calc(-0.75 * var(--u)));
      gap: calc(8 * var(--u));
    }

    .btn-lg {
      height: calc(39 * var(--u));
      border-radius: calc(19.5 * var(--u));
      font-size: calc(13.3 * var(--u));
      font-weight: 500;
      letter-spacing: calc(-0.3 * var(--u));
      gap: calc(9 * var(--u));
    }

    .btn-primary {
      background: var(--white-btn);
      color: var(--btn-ink);
      padding-left: calc(18.2 * var(--u));
      padding-right: calc(19.2 * var(--u));
      transition: background .18s ease, transform .18s ease, box-shadow .18s ease;
    }

    .btn-primary:hover {
      background: #fff;
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
    }

    .btn-ghost {
      background: var(--glass-fill);
      color: #d9d9d9;
      padding: 0 calc(17.4 * var(--u));
      border: 1px solid var(--glass-line);
      -webkit-backdrop-filter: blur(2px);
      backdrop-filter: blur(2px);
      transition: background .18s ease, border-color .18s ease, transform .18s ease;
    }

    .btn-ghost:hover {
      background: rgba(0, 0, 0, 0.66);
      border-color: rgba(255, 255, 255, 0.25);
      color: #fff;
      transform: translateY(-2px);
    }

    .btn-lg .arw {
      width: calc(13 * var(--u));
      height: calc(10.8 * var(--u));
    }

    a:focus-visible,
    button:focus-visible {
      outline: 2px solid #a78bfa;
      outline-offset: 3px;
      border-radius: 99px;
    }

    .menu {
      display: none;
    }

    @keyframes menuIn {
      from {
        opacity: 0;
        transform: translateY(-6px) scale(.985);
      }
      to {
        opacity: 1;
        transform: none;
      }
    }

    /* ============================================================
       SHARED SECTION STYLES
       ============================================================ */
    .section-wrap {
      position: relative;
      padding: 110px 0;
      border-top: 1px solid rgba(255, 255, 255, 0.06);
      background: radial-gradient(circle at 50% 0%, rgba(167, 139, 250, 0.05) 0%, transparent 70%), #060608;
    }

    .sec-container {
      width: 100%;
      max-width: 1240px;
      margin: 0 auto;
      padding: 0 24px;
    }

    .sec-header {
      text-align: center;
      max-width: 760px;
      margin: 0 auto 60px;
    }

    .sec-badge {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      padding: 6px 16px;
      border-radius: 999px;
      background: rgba(167, 139, 250, 0.1);
      border: 1px solid rgba(167, 139, 250, 0.24);
      color: #c4b5fd;
      font-size: 13px;
      font-weight: 600;
      letter-spacing: 0.02em;
      text-transform: uppercase;
      margin-bottom: 18px;
    }

    .sec-title {
      font-size: clamp(30px, 4.2vw, 48px);
      font-weight: 700;
      line-height: 1.15;
      letter-spacing: -0.03em;
      color: #fff;
      margin: 0 0 18px;
    }

    .sec-title .highlight {
      background: linear-gradient(135deg, #ffffff 30%, #a78bfa 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .sec-desc {
      font-size: clamp(15px, 1.8vw, 17px);
      line-height: 1.65;
      color: #a1a1aa;
      margin: 0;
      font-weight: 400;
    }

    .sec-btn-wrap {
      text-align: center;
      margin-top: 48px;
    }

    .btn-view-more {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      padding: 14px 32px;
      border-radius: 999px;
      background: var(--white-btn);
      color: #050505;
      font-size: 14.5px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
      box-shadow: 0 4px 20px rgba(255, 255, 255, 0.12);
    }

    .btn-view-more:hover {
      background: #ffffff;
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(167, 139, 250, 0.3);
    }

    .btn-view-more.ghost {
      background: rgba(255, 255, 255, 0.05);
      color: #f4f4f5;
      border: 1px solid rgba(255, 255, 255, 0.12);
      box-shadow: none;
    }

    .btn-view-more.ghost:hover {
      background: rgba(255, 255, 255, 0.1);
      border-color: rgba(167, 139, 250, 0.5);
      color: #fff;
    }

    /* ============================================================
       1. KELEBIHAN PERUSAHAAN (ADVANTAGES)
       ============================================================ */
    .adv-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
    }

    .adv-card {
      position: relative;
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 20px;
      padding: 34px 28px;
      overflow: hidden;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      -webkit-backdrop-filter: blur(12px);
      backdrop-filter: blur(12px);
    }

    .adv-card::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent, rgba(167, 139, 250, 0.6), transparent);
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .adv-card:hover {
      border-color: rgba(167, 139, 250, 0.35);
      transform: translateY(-4px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5), 0 0 30px rgba(167, 139, 250, 0.08);
    }

    .adv-card:hover::before {
      opacity: 1;
    }

    .adv-icon-wrap {
      width: 52px;
      height: 52px;
      border-radius: 14px;
      background: linear-gradient(135deg, rgba(167, 139, 250, 0.16), rgba(99, 102, 241, 0.08));
      border: 1px solid rgba(167, 139, 250, 0.28);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 22px;
      color: #c4b5fd;
    }

    .adv-card-title {
      font-size: 19px;
      font-weight: 600;
      color: #fff;
      margin: 0 0 12px;
      letter-spacing: -0.01em;
    }

    .adv-card-desc {
      font-size: 14.5px;
      line-height: 1.6;
      color: #a1a1aa;
      margin: 0;
    }

    .metrics-bar {
      margin-top: 56px;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      background: rgba(255, 255, 255, 0.02);
      border: 1px solid rgba(255, 255, 255, 0.06);
      border-radius: 18px;
      padding: 30px;
      text-align: center;
    }

    .metric-item .m-value {
      font-size: clamp(28px, 3.5vw, 40px);
      font-weight: 800;
      color: #fff;
      letter-spacing: -0.03em;
      line-height: 1;
      margin-bottom: 6px;
      background: linear-gradient(135deg, #ffffff 40%, #a78bfa 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .metric-item .m-label {
      font-size: 13.5px;
      color: #71717a;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    /* ============================================================
       MASTER JASA SHOWCASE
       ============================================================ */
    .jasa-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-top: 40px;
    }

    .jasa-card {
      background: rgba(255, 255, 255, 0.02);
      border: 1px solid rgba(255, 255, 255, 0.07);
      border-radius: 16px;
      padding: 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: all 0.25s ease;
    }

    .jasa-card:hover {
      border-color: rgba(167, 139, 250, 0.4);
      background: rgba(167, 139, 250, 0.04);
      transform: translateY(-2px);
    }

    .jasa-name {
      font-size: 15px;
      font-weight: 600;
      color: #f4f4f5;
    }

    .jasa-price {
      font-size: 15px;
      font-weight: 700;
      color: #a78bfa;
      white-space: nowrap;
    }

    /* ============================================================
       2. PORTOFOLIO (MAX 3 ITEMS)
       ============================================================ */
    .port-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 28px;
    }

    .port-card {
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 22px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .port-card:hover {
      border-color: rgba(167, 139, 250, 0.4);
      transform: translateY(-6px);
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.6), 0 0 40px rgba(167, 139, 250, 0.1);
    }

    .port-preview {
      height: 220px;
      background: #0f0f14;
      position: relative;
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      padding: 20px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.06);
      overflow: hidden;
    }

    .port-preview-bg {
      position: absolute;
      inset: 0;
      opacity: 0.6;
      background-size: cover;
      background-position: center;
      transition: transform 0.5s ease;
    }

    .port-card:hover .port-preview-bg {
      transform: scale(1.05);
    }

    .port-tag {
      position: relative;
      align-self: flex-start;
      background: rgba(10, 10, 14, 0.85);
      border: 1px solid rgba(255, 255, 255, 0.12);
      color: #c4b5fd;
      font-size: 12px;
      font-weight: 600;
      padding: 5px 12px;
      border-radius: 999px;
      -webkit-backdrop-filter: blur(8px);
      backdrop-filter: blur(8px);
      margin-bottom: auto;
    }

    .port-stat-pill {
      position: relative;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(167, 139, 250, 0.18);
      border: 1px solid rgba(167, 139, 250, 0.35);
      padding: 6px 14px;
      border-radius: 10px;
      color: #fff;
      font-size: 13px;
      font-weight: 600;
      width: max-content;
      -webkit-backdrop-filter: blur(10px);
      backdrop-filter: blur(10px);
    }

    .port-stat-pill span {
      color: #c4b5fd;
      font-weight: 400;
    }

    .port-body {
      padding: 26px;
      display: flex;
      flex-direction: column;
      flex: 1;
    }

    .port-title {
      font-size: 20px;
      font-weight: 700;
      color: #fff;
      margin: 0 0 10px;
      letter-spacing: -0.01em;
    }

    .port-desc {
      font-size: 14px;
      line-height: 1.6;
      color: #a1a1aa;
      margin: 0 0 20px;
      flex: 1;
    }

    .port-link {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: 14px;
      font-weight: 600;
      color: #c4b5fd;
      text-decoration: none;
      transition: gap 0.2s ease, color 0.2s ease;
    }

    .port-link:hover {
      color: #fff;
      gap: 12px;
    }

    /* ============================================================
       3. LIST BERITA (MAX 3 ITEMS)
       ============================================================ */
    .news-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 28px;
    }

    .news-card {
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 20px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .news-card:hover {
      border-color: rgba(167, 139, 250, 0.35);
      transform: translateY(-5px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
    }

    .news-img-box {
      height: 180px;
      overflow: hidden;
      background: #111;
      position: relative;
    }

    .news-img-box img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.4s ease;
    }

    .news-card:hover .news-img-box img {
      transform: scale(1.06);
    }

    .news-meta-top {
      padding: 20px 24px 8px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
    }

    .news-badge {
      font-size: 12px;
      font-weight: 600;
      color: #c4b5fd;
      background: rgba(167, 139, 250, 0.12);
      border: 1px solid rgba(167, 139, 250, 0.25);
      padding: 4px 12px;
      border-radius: 999px;
    }

    .news-time {
      font-size: 12.5px;
      color: #71717a;
    }

    .news-body {
      padding: 0 24px 24px;
      display: flex;
      flex-direction: column;
      flex: 1;
    }

    .news-title {
      font-size: 18px;
      font-weight: 600;
      line-height: 1.4;
      color: #fff;
      margin: 8px 0 12px;
      letter-spacing: -0.01em;
    }

    .news-title a {
      color: inherit;
      text-decoration: none;
      transition: color 0.2s ease;
    }

    .news-title a:hover {
      color: #c4b5fd;
    }

    .news-excerpt {
      font-size: 14px;
      line-height: 1.6;
      color: #a1a1aa;
      margin: 0 0 20px;
      flex: 1;
    }

    .news-author-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-top: 1px solid rgba(255, 255, 255, 0.06);
      padding-top: 16px;
    }

    .author-info {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .author-avatar {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: #27272a;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
      font-weight: 700;
      color: #c4b5fd;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .author-name {
      font-size: 13px;
      font-weight: 500;
      color: #e4e4e7;
    }

    .news-date {
      font-size: 12.5px;
      color: #71717a;
    }

    /* ============================================================
       4. QNA SLIDER (INTERACTIVE CAROUSEL)
       ============================================================ */
    .qna-slider-wrap {
      position: relative;
      margin-top: 20px;
    }

    .qna-viewport {
      overflow: hidden;
      width: 100%;
      border-radius: 24px;
    }

    .qna-track {
      display: flex;
      gap: 24px;
      transition: transform 0.45s cubic-bezier(0.16, 1, 0.3, 1);
      will-change: transform;
    }

    .qna-card {
      flex: 0 0 calc(33.333% - 16px);
      min-width: 0;
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 20px;
      padding: 32px 28px;
      display: flex;
      flex-direction: column;
      position: relative;
      box-sizing: border-box;
      transition: border-color 0.3s ease, transform 0.3s ease;
    }

    .qna-card:hover {
      border-color: rgba(167, 139, 250, 0.35);
      transform: translateY(-4px);
    }

    .qna-card-num {
      font-size: 12.5px;
      font-weight: 700;
      color: #a78bfa;
      letter-spacing: 0.05em;
      margin-bottom: 14px;
      display: inline-block;
    }

    .qna-question {
      font-size: 18px;
      font-weight: 600;
      color: #fff;
      line-height: 1.35;
      margin: 0 0 16px;
      letter-spacing: -0.01em;
    }

    .qna-answer {
      font-size: 14.5px;
      line-height: 1.65;
      color: #a1a1aa;
      margin: 0;
      flex: 1;
    }

    .qna-controls {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 20px;
      margin-top: 40px;
    }

    .qna-btn {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.06);
      border: 1px solid rgba(255, 255, 255, 0.12);
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .qna-btn:hover:not(:disabled) {
      background: rgba(167, 139, 250, 0.2);
      border-color: rgba(167, 139, 250, 0.5);
      color: #fff;
      transform: scale(1.06);
    }

    .qna-btn:disabled {
      opacity: 0.35;
      cursor: not-allowed;
    }

    .qna-dots {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .qna-dot {
      width: 8px;
      height: 8px;
      border-radius: 999px;
      background: rgba(255, 255, 255, 0.2);
      border: 0;
      padding: 0;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .qna-dot.active {
      width: 24px;
      background: #a78bfa;
    }

    .qna-counter {
      font-size: 13.5px;
      font-weight: 600;
      color: #a1a1aa;
      min-width: 50px;
      text-align: center;
    }

    /* ============================================================
       CONSULTATION SECTION
       ============================================================ */
    .consultation-wrap {
      background: radial-gradient(circle at 80% 20%, rgba(167, 139, 250, 0.08) 0%, transparent 60%), #060609;
      position: relative;
    }

    .consultation-grid {
      display: grid;
      grid-template-columns: 1.4fr 1fr;
      gap: 48px;
      align-items: start;
    }

    .consultation-card {
      background: rgba(14, 14, 20, 0.75);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 24px;
      padding: 40px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5), 0 0 50px rgba(167, 139, 250, 0.05);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-bottom: 0px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-size: 13.5px;
      font-weight: 600;
      color: #e4e4e7;
      margin-bottom: 8px;
    }

    .form-group label span.req {
      color: #a78bfa;
    }

    .form-control-dark {
      width: 100%;
      background: rgba(24, 24, 30, 0.85);
      border: 1px solid rgba(255, 255, 255, 0.12);
      border-radius: 12px;
      padding: 13px 16px;
      color: #fff;
      font-family: inherit;
      font-size: 14.5px;
      outline: none;
      transition: all 0.2s ease;
      box-sizing: border-box;
    }

    .form-control-dark:focus {
      border-color: #a78bfa;
      background: rgba(28, 28, 38, 0.95);
      box-shadow: 0 0 0 3px rgba(167, 139, 250, 0.2);
    }

    .form-control-dark::placeholder {
      color: #71717a;
    }

    select.form-control-dark {
      cursor: pointer;
    }

    select.form-control-dark option {
      background: #18181f;
      color: #fff;
    }

    textarea.form-control-dark {
      resize: vertical;
      min-height: 120px;
    }

    .btn-submit-consult {
      width: 100%;
      padding: 16px 28px;
      background: #ffffff;
      color: #09090b;
      font-size: 15px;
      font-weight: 700;
      border: none;
      border-radius: 14px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      transition: all 0.25s ease;
      margin-top: 10px;
    }

    .btn-submit-consult:hover {
      background: #a78bfa;
      color: #ffffff;
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(167, 139, 250, 0.35);
    }

    .consult-alert-success {
      background: rgba(16, 185, 129, 0.12);
      border: 1px solid rgba(16, 185, 129, 0.3);
      border-radius: 16px;
      padding: 20px 24px;
      margin-bottom: 28px;
      display: flex;
      align-items: flex-start;
      gap: 16px;
      color: #10b981;
    }

    .consult-alert-success h4 {
      margin: 0 0 4px;
      font-size: 16px;
      font-weight: 700;
      color: #34d399;
    }

    .consult-alert-success p {
      margin: 0;
      font-size: 14px;
      color: #d1fae5;
      line-height: 1.5;
    }

    .consult-perks {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .perk-box {
      background: rgba(255, 255, 255, 0.02);
      border: 1px solid rgba(255, 255, 255, 0.06);
      border-radius: 18px;
      padding: 24px;
      transition: border-color 0.2s ease;
    }

    .perk-box:hover {
      border-color: rgba(167, 139, 250, 0.25);
    }

    .perk-box-title {
      font-size: 16px;
      font-weight: 700;
      color: #fff;
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 8px;
    }

    .perk-box-desc {
      font-size: 13.5px;
      color: #a1a1aa;
      line-height: 1.6;
      margin: 0;
    }

    @media (max-width: 900px) {
      .consultation-grid {
        grid-template-columns: 1fr;
      }
      .form-row {
        grid-template-columns: 1fr;
        gap: 0;
      }
      .consultation-card {
        padding: 24px;
      }
    }

    /* ============================================================
       5. FOOTER (COMPANY PROFILE & CONTACT DATA)
       ============================================================ */
    .site-footer {
      background: #030304;
      border-top: 1px solid rgba(255, 255, 255, 0.08);
      padding: 90px 0 40px;
      position: relative;
    }

    .footer-grid {
      display: grid;
      grid-template-columns: 2fr 1fr 1.3fr 1.5fr;
      gap: 48px;
      margin-bottom: 70px;
    }

    .footer-brand .f-logo {
      font-size: 24px;
      font-weight: 800;
      color: #fff;
      text-decoration: none;
      letter-spacing: -0.02em;
      margin-bottom: 18px;
      display: inline-block;
    }

    .footer-brand .f-logo span {
      background: linear-gradient(135deg, #ffffff 40%, #a78bfa 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .footer-brand p {
      font-size: 14.5px;
      line-height: 1.65;
      color: #888891;
      margin: 0 0 24px;
      max-width: 360px;
    }

    .cert-badges {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
    }

    .cert-pill {
      font-size: 11.5px;
      font-weight: 600;
      color: #c4b5fd;
      background: rgba(167, 139, 250, 0.1);
      border: 1px solid rgba(167, 139, 250, 0.22);
      padding: 4px 10px;
      border-radius: 6px;
    }

    .footer-title {
      font-size: 15px;
      font-weight: 700;
      color: #fff;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin: 0 0 22px;
    }

    .footer-links {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .footer-links li {
      margin-bottom: 12px;
    }

    .footer-links a {
      color: #9ca3af;
      text-decoration: none;
      font-size: 14px;
      transition: color 0.2s ease, transform 0.2s ease;
      display: inline-block;
    }

    .footer-links a:hover {
      color: #fff;
      transform: translateX(3px);
    }

    .contact-item {
      display: flex;
      align-items: flex-start;
      gap: 12px;
      margin-bottom: 18px;
      color: #9ca3af;
      font-size: 13.5px;
      line-height: 1.55;
    }

    .contact-item svg {
      flex: 0 0 auto;
      margin-top: 3px;
      color: #a78bfa;
    }

    .contact-item a {
      color: #9ca3af;
      text-decoration: none;
      transition: color 0.2s ease;
    }

    .contact-item a:hover {
      color: #fff;
    }

    .footer-bottom {
      border-top: 1px solid rgba(255, 255, 255, 0.06);
      padding-top: 32px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 20px;
    }

    .copyright {
      font-size: 13px;
      color: #71717a;
      margin: 0;
    }

    .footer-socials {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .social-btn {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.08);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #9ca3af;
      text-decoration: none;
      transition: all 0.2s ease;
    }

    .social-btn:hover {
      background: rgba(167, 139, 250, 0.2);
      border-color: rgba(167, 139, 250, 0.4);
      color: #fff;
      transform: translateY(-2px);
    }

    .legal-links {
      display: flex;
      align-items: center;
      gap: 18px;
    }

    .legal-links a {
      font-size: 12.5px;
      color: #71717a;
      text-decoration: none;
      transition: color 0.2s ease;
    }

    .legal-links a:hover {
      color: #d4d4d8;
    }

    /* ============================================================
       RESPONSIVE BREAKPOINTS
       ============================================================ */
    @media (max-width: 1024px) {
      :root {
        --u: min(
          max(0.9px, min(calc(100vw / 1280), calc(100dvh / 760))),
          calc((100vw - 72px) / 575),
          calc(100dvh / 620)
        );
      }

      .nav {
        height: max(58px, calc(67 * var(--u)));
        padding-left: max(24px, calc(28 * var(--u)));
        padding-right: max(24px, calc(28 * var(--u)));
      }

      .nav-links,
      .nav-actions {
        display: none;
      }

      .burger {
        display: flex;
        width: max(46px, calc(48 * var(--u)));
        height: max(38px, calc(34 * var(--u)));
        border-radius: 999px;
      }

      .hero-inner {
        max-width: calc(100vw - 48px);
      }

      .sub {
        font-size: max(16px, calc(17.4 * var(--u)));
        line-height: max(25px, calc(27 * var(--u)));
      }

      .ctas {
        margin-top: max(26px, calc(21.8 * var(--u)));
        gap: max(10px, calc(7 * var(--u)));
      }

      .btn-lg {
        height: max(44px, calc(39 * var(--u)));
        border-radius: max(22px, calc(19.5 * var(--u)));
        font-size: max(15px, calc(13.3 * var(--u)));
        gap: max(10px, calc(9 * var(--u)));
      }

      .btn-primary {
        padding-left: max(21px, calc(18.2 * var(--u)));
        padding-right: max(22px, calc(19.2 * var(--u)));
      }

      .btn-ghost {
        padding-left: max(20px, calc(17.4 * var(--u)));
        padding-right: max(21px, calc(18.4 * var(--u)));
      }

      .btn-lg .arw {
        width: max(14px, calc(13 * var(--u)));
        height: max(11.6px, calc(10.8 * var(--u)));
      }

      .menu {
        position: fixed;
        top: calc(max(58px, calc(67 * var(--u))) + 8px);
        right: max(24px, calc(28 * var(--u)));
        width: min(320px, calc(100vw - 48px));
        background: rgba(10, 10, 12, 0.94);
        -webkit-backdrop-filter: blur(24px);
        backdrop-filter: blur(24px);
        border: 1px solid rgba(255, 255, 255, 0.09);
        border-radius: 20px;
        padding: 12px 10px 14px;
        flex-direction: column;
        box-shadow: 0 24px 60px rgba(0, 0, 0, 0.65);
        transform-origin: top right;
        z-index: 105;
      }

      .menu.open {
        display: flex;
        animation: menuIn .18s ease both;
      }

      .menu a {
        color: var(--ink-muted);
        text-decoration: none;
        font-size: 15px;
        font-weight: 500;
        letter-spacing: calc(-0.15 * var(--u));
        padding: 12px 14px;
        border-radius: 12px;
        transition: background .18s ease, color .18s ease;
      }

      .menu a:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #fff;
      }

      .menu .divider {
        height: 1px;
        background: rgba(255, 255, 255, 0.08);
        margin: 8px 14px;
      }

      .menu .m-start {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        background: var(--white-btn);
        color: var(--btn-ink);
        margin: 6px 8px 0;
        padding: 13px 16px;
        border-radius: 14px;
        font-weight: 600;
      }

      .menu .m-start:hover {
        background: #fff;
        color: var(--btn-ink);
      }

      .menu .m-start .arw {
        width: 13px;
        height: 11px;
      }

      .adv-grid,
      .port-grid,
      .news-grid,
      .jasa-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .metrics-bar {
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
      }

      .qna-card {
        flex: 0 0 calc(50% - 12px);
      }

      .footer-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 40px;
      }
    }

    @media (max-width: 768px) {
      .adv-grid,
      .port-grid,
      .news-grid,
      .jasa-grid {
        grid-template-columns: 1fr;
      }

      .qna-card {
        flex: 0 0 100%;
      }

      .footer-grid {
        grid-template-columns: 1fr;
        gap: 36px;
      }

      .section-wrap {
        padding: 70px 0;
      }

      .sec-header {
        margin-bottom: 40px;
      }

      .metrics-bar {
        grid-template-columns: 1fr;
        padding: 24px 20px;
      }
    }

    @media (max-width: 552px) {
      :root {
        --u: 1px;
      }

      .nav {
        height: 56px;
        padding: 0 20px;
      }

      .logo {
        font-size: 22px;
        letter-spacing: -.4px;
      }

      .burger {
        width: 42px;
        height: 36px;
      }

      .hero-inner {
        position: absolute;
        left: 0;
        right: 0;
        top: 50%;
        width: auto;
        max-width: none;
        padding: 0 20px;
        transform: translateY(-47%);
      }

      h1 {
        font-size: min(68px, calc((100vw - 44px) / 6.8));
        line-height: 1.05;
        letter-spacing: -.02em;
      }

      .sub {
        margin-top: 16px;
        font-size: clamp(15px, 4vw, 16.5px);
        line-height: 1.6;
        letter-spacing: 0;
        max-width: 42ch;
        margin-left: auto;
        margin-right: auto;
      }

      .sub br {
        display: none;
      }

      .ctas {
        margin-top: 24px;
        gap: 10px;
        transform: none;
        flex-wrap: wrap;
      }

      .btn-lg {
        height: 46px;
        border-radius: 23px;
        font-size: 15px;
        gap: 9px;
      }

      .btn-primary {
        padding-left: 20px;
        padding-right: 21px;
      }

      .btn-ghost {
        padding-left: 19px;
        padding-right: 20px;
      }

      .btn-lg .arw {
        width: 13px;
        height: 11px;
      }

      .menu {
        top: 64px;
        left: 16px;
        right: 16px;
        width: auto;
      }

      .menu a {
        font-size: 15.5px;
        padding: 13px 14px;
      }

      .menu .m-start {
        padding: 14px 16px;
      }

      .footer-bottom {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
      }
    }

    @media (max-width: 353px) {
      .ctas {
        flex-direction: column;
        align-items: center;
      }

      .btn-lg {
        width: min(100%, 272px);
      }
    }

    /* ============================================================
       ENTRANCE SEQUENCE (HERO FOREGROUND)
       ============================================================ */
    html.anim .ln {
      overflow: hidden;
      padding-top: .26em;
      margin-top: -.26em;
    }

    html.anim .ln-i {
      transform: translateY(100%);
    }

    html.anim .logo,
    html.anim .nav-links a,
    html.anim .nav-actions .btn,
    html.anim .burger,
    html.anim .sub,
    html.anim .ctas .btn {
      opacity: 0;
    }

    html.anim .ln-i,
    html.anim .logo,
    html.anim .nav-links a,
    html.anim .nav-actions .btn,
    html.anim .burger,
    html.anim .sub,
    html.anim .ctas .btn {
      will-change: transform, opacity;
    }

    @keyframes lineRise {
      from { transform: translateY(100%); }
      to   { transform: translateY(0); }
    }

    @keyframes subIn {
      from {
        opacity: 0;
        transform: translateY(calc(14 * var(--u)));
        filter: blur(4px);
      }
      to {
        opacity: 1;
        transform: none;
        filter: blur(0);
      }
    }

    @keyframes subInFlat {
      from {
        opacity: 0;
        transform: translateY(calc(12 * var(--u)));
      }
      to {
        opacity: 1;
        transform: none;
      }
    }

    @keyframes pillIn {
      from {
        opacity: 0;
        transform: translateY(calc(8 * var(--u))) scale(.972);
      }
      to {
        opacity: 1;
        transform: none;
      }
    }

    @keyframes liftIn {
      from {
        opacity: 0;
        transform: translateY(calc(9 * var(--u)));
      }
      to {
        opacity: 1;
        transform: none;
      }
    }

    @keyframes logoIn {
      from {
        opacity: 0;
        transform: translateY(calc(-2.4 * var(--u))) translateY(calc(9 * var(--u)));
      }
      to {
        opacity: 1;
        transform: translateY(calc(-2.4 * var(--u)));
      }
    }

    html.anim.go .ln-i {
      animation: lineRise 1.05s var(--e-reveal) both;
    }

    html.anim.go .ln:nth-child(1) .ln-i {
      animation-delay: .12s;
    }

    html.anim.go .ln:nth-child(2) .ln-i {
      animation-delay: .22s;
    }

    html.anim.go .logo {
      animation: logoIn .62s var(--e-soft) .46s both;
    }

    html.anim.go .nav-links a {
      animation: liftIn .55s var(--e-soft) both;
    }

    html.anim.go .nav-links a:nth-child(1) { animation-delay: .540s; }
    html.anim.go .nav-links a:nth-child(2) { animation-delay: .585s; }
    html.anim.go .nav-links a:nth-child(3) { animation-delay: .630s; }
    html.anim.go .nav-links a:nth-child(4) { animation-delay: .675s; }
    html.anim.go .nav-links a:nth-child(5) { animation-delay: .720s; }

    html.anim.go .sub {
      animation: subIn .85s var(--e-reveal) .58s both;
    }

    html.anim.go .btn-login {
      animation: pillIn .55s var(--e-soft) .68s both;
    }

    html.anim.go .burger {
      animation: pillIn .55s var(--e-soft) .68s both;
    }

    html.anim.go .btn-nav-start {
      animation: pillIn .55s var(--e-soft) .73s both;
    }

    html.anim.go .ctas .btn-primary {
      animation: pillIn .70s var(--e-reveal) .90s both;
    }

    html.anim.go .ctas .btn-ghost {
      animation: pillIn .70s var(--e-reveal) .97s both;
    }

    @media (max-width: 552px) {
      html.anim.go .sub {
        animation-name: subInFlat;
      }
      html.anim.go .ln-i {
        animation-duration: .92s;
      }
      html.anim.go .ctas .btn-primary {
        animation-delay: .84s;
      }
      html.anim.go .ctas .btn-ghost {
        animation-delay: .90s;
      }
    }

    @media (prefers-reduced-motion: reduce) {
      html.anim .ln {
        overflow: visible;
        padding-top: 0;
        margin-top: 0;
      }
      html.anim .ln-i {
        transform: none;
      }
      html.anim .logo,
      html.anim .nav-links a,
      html.anim .nav-actions .btn,
      html.anim .burger,
      html.anim .sub,
      html.anim .ctas .btn {
        opacity: 1;
      }
      * {
        transition: none !important;
        animation: none !important;
      }
    }
  </style>

  <script>
    (function () {
      if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
      }
      document.documentElement.classList.add('anim');

      var started = false;
      var cleaned = false;
      var bootTimer = null;
      var safetyTimer = null;

      function clean() {
        if (cleaned) return;
        cleaned = true;
        if (safetyTimer) {
          clearTimeout(safetyTimer);
          safetyTimer = null;
        }
        document.removeEventListener('animationend', onEnd, true);
        document.documentElement.classList.remove('anim', 'go');
      }

      function onEnd(e) {
        if (e.animationName === 'pillIn' && e.target && e.target.classList && e.target.classList.contains('btn-ghost')) {
          clean();
        }
      }

      function start() {
        if (started) return;
        started = true;
        if (bootTimer) {
          clearTimeout(bootTimer);
          bootTimer = null;
        }
        document.addEventListener('animationend', onEnd, true);
        safetyTimer = setTimeout(clean, 2600);
        document.documentElement.classList.add('go');
      }

      function boot() {
        bootTimer = setTimeout(start, 900);
        if (document.fonts && document.fonts.ready) {
          document.fonts.ready.then(start, start);
        } else {
          start();
        }
      }

      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
      } else {
        boot();
      }
    })();
  </script>
</head>
<body>

  <!-- ============================================================
       TOP NAVIGATION BAR (FIXED VIEWPORT)
       ============================================================ -->
  <header class="nav" id="mainNav">
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
        <a href="#advantages">Keunggulan</a>
        <a href="#services">Layanan</a>
        <a href="{{ route('portofolio.public') }}">Portofolio</a>
        <a href="{{ route('berita.public') }}">Berita</a>
        <a href="#faq">FAQ</a>
        <a href="#consultation">Konsultasi</a>
        <a href="#contact">Kontak</a>
      </nav>
      <div class="nav-actions">
        <a href="#consultation" class="btn btn-nav-start">
          Konsultasi
          <svg class="arw" viewBox="0 0 12 10" fill="none" aria-hidden="true">
            <path d="M0.8 5h10M7.1 1.4 10.9 5l-3.8 3.6" stroke="currentColor" stroke-width="1.35" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>
      </div>
      <button class="burger" id="burger" aria-label="Open menu" aria-expanded="false" aria-controls="menu">
        <span></span>
      </button>
    </div>
  </header>

  <nav class="menu" id="menu" aria-label="Mobile">
    <a href="#advantages">Keunggulan</a>
    <a href="#services">Layanan & Jasa</a>
    <a href="{{ route('portofolio.public') }}">Portofolio Proyek</a>
    <a href="{{ route('berita.public') }}">Berita & Wawasan</a>
    <a href="#faq">FAQ</a>
    <a href="#consultation">Form Konsultasi</a>
    <a href="#contact">Profil & Kontak</a>
    <a href="#consultation" class="m-start">
      Mulai Proyek
      <svg class="arw" viewBox="0 0 12 10" fill="none" aria-hidden="true">
        <path d="M0.8 5h10M7.1 1.4 10.9 5l-3.8 3.6" stroke="currentColor" stroke-width="1.35" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </a>
  </nav>

  <!-- ============================================================
       HERO SECTION
       ============================================================ -->
  <main class="hero">
    <div class="bg" role="img" aria-label="Stylised globe of Earth rendered as a purple dot matrix against a starfield, slowly rotating">
      <video class="bg-video is-active" id="bgVideoA" autoplay muted loop playsinline preload="auto" disablepictureinpicture aria-hidden="true" poster="https://d2ol7oe51mr4n9.cloudfront.net/user_38xzZboKViGWJOttwIXH07lWA1P/82e7eb75-c65f-490a-99b5-f3d1cad54200.webp">
        <source src="https://d8j0ntlcm91z4.cloudfront.net/user_38xzZboKViGWJOttwIXH07lWA1P/hf_20260912_104036_bd6924f6-3c8e-417e-8465-6d03c8c2e9e6.mp4" type="video/mp4">
      </video>
      <video class="bg-video" id="bgVideoB" muted loop playsinline preload="auto" disablepictureinpicture aria-hidden="true" poster="https://d2ol7oe51mr4n9.cloudfront.net/user_38xzZboKViGWJOttwIXH07lWA1P/82e7eb75-c65f-490a-99b5-f3d1cad54200.webp">
        <source src="https://d8j0ntlcm91z4.cloudfront.net/user_38xzZboKViGWJOttwIXH07lWA1P/hf_20260912_104036_bd6924f6-3c8e-417e-8465-6d03c8c2e9e6.mp4" type="video/mp4">
      </video>
    </div>

    <div class="hero-inner">
      <h1>
        <span class="ln"><span class="ln-i">Enterprise IT Solution</span></span>
        <span class="ln"><span class="ln-i">& Software House</span></span>
      </h1>
      <p class="sub">
        Mitra strategis solusi teknologi informasi dan rekayasa perangkat lunak terintegrasi.<br>
        Kami merancang ekosistem digital cerdas, cloud & infrastruktur aman, AI automation,<br>
        hingga aplikasi skala enterprise untuk mengakselerasi pertumbuhan bisnis Anda.
      </p>
      <div class="ctas">
        <a href="#consultation" class="btn btn-lg btn-primary">
          Konsultasi Proyek
          <svg class="arw" viewBox="0 0 12 10" fill="none" aria-hidden="true">
            <path d="M0.8 5h10M7.1 1.4 10.9 5l-3.8 3.6" stroke="currentColor" stroke-width="1.35" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>
        <a href="#portfolio" class="btn btn-lg btn-ghost">
          Eksplor Portofolio
          <svg class="arw" viewBox="0 0 12 10" fill="none" aria-hidden="true">
            <path d="M0.8 5h10M7.1 1.4 10.9 5l-3.8 3.6" stroke="currentColor" stroke-width="1.35" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>
      </div>
    </div>
  </main>

  <!-- ============================================================
       SECTION 1: KELEBIHAN PERUSAHAAN (SOFTWARE HOUSE & IT SOLUTION ADVANTAGES)
       ============================================================ -->
  <section id="advantages" class="section-wrap">
    <div class="sec-container">
      <div class="sec-header">
        <div class="sec-badge">✨ Standar Rekayasa Global</div>
        <h2 class="sec-title">Keunggulan Solusi IT & <span class="highlight">Teknologi Terintegrasi</span></h2>
        <p class="sec-desc">
          Bukan sekadar menulis kode, kami adalah mitra strategis IT Solution yang membangun fondasi teknologi kokoh, infrastruktur cloud scalable, dan keamanan tingkat tinggi untuk masa depan bisnis Anda.
        </p>
      </div>

      <div class="adv-grid">
        <div class="adv-card">
          <div class="adv-icon-wrap">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/>
            </svg>
          </div>
          <h3 class="adv-card-title">Arsitektur Cloud & Skalabilitas Tinggi</h3>
          <p class="adv-card-desc">
            Sistem dirancang dengan arsitektur modular, microservices, dan cloud-native yang siap menangani lonjakan jutaan request per detik tanpa kompromi performa.
          </p>
        </div>

        <div class="adv-card">
          <div class="adv-icon-wrap">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
          </div>
          <h3 class="adv-card-title">Keamanan Standar Finansial (Zero-Trust)</h3>
          <p class="adv-card-desc">
            Perlindungan enkripsi AES-256 end-to-end, kepatuhan OWASP Top 10, audit keamanan berkala, dan kesesuaian standar privasi data ISO 27001 & GDPR.
          </p>
        </div>

        <div class="adv-card">
          <div class="adv-icon-wrap">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/>
              <polyline points="12 6 12 12 16 14"/>
            </svg>
          </div>
          <h3 class="adv-card-title">Metodologi Agile & Transparansi 100%</h3>
          <p class="adv-card-desc">
            Sprint terjadwal mingguan, live staging preview yang dapat Anda akses kapan saja, serta komunikasi intensif tanpa biaya tersembunyi.
          </p>
        </div>

        <div class="adv-card">
          <div class="adv-icon-wrap">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
            </svg>
          </div>
          <h3 class="adv-card-title">Full-Stack Modern & Integrasi AI</h3>
          <p class="adv-card-desc">
            Menguasai ekosistem teknologi mutakhir mulai dari Laravel, Next.js, Flutter, hingga implementasi Large Language Model (LLM) dan otomasi cerdas.
          </p>
        </div>

        <div class="adv-card">
          <div class="adv-icon-wrap">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
              <polyline points="14 2 14 8 20 8"/>
              <line x1="16" y1="13" x2="8" y2="13"/>
              <line x1="16" y1="17" x2="8" y2="17"/>
              <polyline points="10 9 9 9 8 9"/>
            </svg>
          </div>
          <h3 class="adv-card-title">100% Hak Kekayaan Intelektual (IP)</h3>
          <p class="adv-card-desc">
            Seluruh source code, dokumentasi API, dan hak paten perangkat lunak diserahkan sepenuhnya kepada Anda sebagai aset berharga perusahaan.
          </p>
        </div>

        <div class="adv-card">
          <div class="adv-icon-wrap">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
          </div>
          <h3 class="adv-card-title">Garansi Bebas Bug & SLA 24/7</h3>
          <p class="adv-card-desc">
            Komitmen dukungan purna jual berkelanjutan dengan Service Level Agreement ketat, monitoring infrastruktur real-time, dan respon cepat 24 jam.
          </p>
        </div>
      </div>

      <div class="metrics-bar">
        <div class="metric-item">
          <div class="m-value">150+</div>
          <div class="m-label">Proyek Enterprise Rilis</div>
        </div>
        <div class="metric-item">
          <div class="m-value">99.8%</div>
          <div class="m-label">Tingkat Kepuasan Klien</div>
        </div>
        <div class="metric-item">
          <div class="m-value">45+</div>
          <div class="m-label">Senior Software Engineer</div>
        </div>
        <div class="metric-item">
          <div class="m-value">99.99%</div>
          <div class="m-label">SLA Server Uptime</div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION: MASTER JASA / SERVICES
       ============================================================ -->
  @if(isset($masterJasas) && $masterJasas->count() > 0)
  <section id="services" class="section-wrap" style="padding-top: 40px; background: #050507;">
    <div class="sec-container">
      <div class="sec-header" style="margin-bottom: 30px;">
        <div class="sec-badge">💼 Katalog Layanan</div>
        <h2 class="sec-title">Layanan & Solusi <span class="highlight">Teknologi Kami</span></h2>
        <p class="sec-desc">Estimasi investasi transparan untuk solusi software bermutu tinggi.</p>
      </div>

      <div class="jasa-grid">
        @foreach($masterJasas as $jasa)
          <div class="jasa-card">
            <div class="jasa-name">{{ $jasa->jasa }}</div>
            <div class="jasa-price">Mulai Rp {{ number_format($jasa->harga, 0, ',', '.') }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  <!-- ============================================================
       SECTION 2: PORTOFOLIO (MAX 3 ITEMS + VIEW MORE BUTTON)
       ============================================================ -->
  <section id="portfolio" class="section-wrap">
    <div class="sec-container">
      <div class="sec-header">
        <div class="sec-badge">🚀 Rekam Jejak Unggulan</div>
        <h2 class="sec-title">Karya Portofolio <span class="highlight">Pilihan Kami</span></h2>
        <p class="sec-desc">
          Tiga mahakarya teknologi yang memecahkan tantangan operasional berskala besar dan menghasilkan dampak bisnis terukur.
        </p>
      </div>

      <div class="port-grid">
        @forelse($portofolios as $port)
          @php
            $photos = is_array($port->foto) ? $port->foto : (json_decode($port->foto, true) ?? []);
            $mainPhoto = !empty($photos) ? $photos[0] : null;
          @endphp
          <div class="port-card">
            <div class="port-preview">
              @if($mainPhoto)
                <div class="port-preview-bg" style="background-image: url('{{ $mainPhoto }}');"></div>
              @else
                <div class="port-preview-bg" style="background-image: radial-gradient(circle at 70% 30%, rgba(167, 139, 250, 0.35) 0%, rgba(10, 10, 18, 0.95) 75%);"></div>
              @endif
              <span class="port-tag">Proyek Enterprise</span>
              @if(!empty($photos) && count($photos) > 1)
                <div class="port-stat-pill">{{ count($photos) }} <span>Foto Dokumentasi</span></div>
              @endif
            </div>
            <div class="port-body">
              <h3 class="port-title">{{ $port->nama }}</h3>
              <p class="port-desc">{{ $port->keterangan }}</p>
              @if($port->link)
                <a href="{{ $port->link }}" target="_blank" class="port-link">
                  Kunjungi Proyek
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                  </svg>
                </a>
              @endif
            </div>
          </div>
        @empty
          <p style="color:#71717a; text-align:center; grid-column: 1/-1;">Belum ada portofolio yang ditampilkan.</p>
        @endforelse
      </div>

      <div class="sec-btn-wrap">
        <a href="{{ route('portofolio.public') }}" class="btn-view-more">
          Lihat Portofolio Lengkap
          <svg class="arw" width="14" height="12" viewBox="0 0 12 10" fill="none" aria-hidden="true">
            <path d="M0.8 5h10M7.1 1.4 10.9 5l-3.8 3.6" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 3: LIST BERITA (MAX 3 ITEMS + VIEW MORE BUTTON)
       ============================================================ -->
  <section id="news" class="section-wrap">
    <div class="sec-container">
      <div class="sec-header">
        <div class="sec-badge">📰 Wawasan & Berita</div>
        <h2 class="sec-title">Kabar & Analisis <span class="highlight">Teknologi Terbaru</span></h2>
        <p class="sec-desc">
          Dapatkan insight mendalam seputar tren arsitektur software, kecerdasan buatan, dan praktik engineering terbaik langsung dari praktisi kami.
        </p>
      </div>

      <div class="news-grid">
        @forelse($beritas as $berita)
          <article class="news-card">
            @if($berita->gambar)
              <div class="news-img-box">
                <a href="{{ route('berita.show', $berita->uuid) }}">
                  <img src="{{ $berita->gambar }}" alt="{{ $berita->judul }}">
                </a>
              </div>
            @endif
            <div class="news-meta-top">
              <span class="news-badge">Artikel Resmi</span>
              <span class="news-time">{{ $berita->created_at ? $berita->created_at->diffForHumans() : 'Baru' }}</span>
            </div>
            <div class="news-body">
              <h3 class="news-title">
                <a href="{{ route('berita.show', $berita->uuid) }}">{{ $berita->judul }}</a>
              </h3>
              <p class="news-excerpt">{{ \Illuminate\Support\Str::limit($berita->keterangan, 140) }}</p>
              <div class="news-author-row">
                <div class="author-info">
                  <div class="author-avatar">CT</div>
                  <div class="author-name">Editorial Coretech</div>
                </div>
                <a href="{{ route('berita.show', $berita->uuid) }}" style="color: var(--accent-purple); font-size: 0.85rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                  Baca &rarr;
                </a>
              </div>
            </div>
          </article>
        @empty
          <p style="color:#71717a; text-align:center; grid-column: 1/-1;">Belum ada berita yang dipublikasikan.</p>
        @endforelse
      </div>

      <div class="sec-btn-wrap">
        <a href="{{ route('berita.public') }}" class="btn-view-more ghost">
          Lihat Lebih Banyak Berita
          <svg class="arw" width="14" height="12" viewBox="0 0 12 10" fill="none" aria-hidden="true">
            <path d="M0.8 5h10M7.1 1.4 10.9 5l-3.8 3.6" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 4: QNA (SEMUA DITAMPILKAN DI SLIDER)
       ============================================================ -->
  <section id="faq" class="section-wrap">
    <div class="sec-container">
      <div class="sec-header">
        <div class="sec-badge">💬 Tanya & Jawab</div>
        <h2 class="sec-title">Pertanyaan yang <span class="highlight">Sering Diajukan</span></h2>
        <p class="sec-desc">
          Geser slider di bawah untuk menemukan jawaban transparan seputar proses pengerjaan, keamanan, garansi, dan hak cipta proyek Anda.
        </p>
      </div>

      <div class="qna-slider-wrap">
        <div class="qna-viewport" id="qnaViewport">
          <div class="qna-track" id="qnaTrack">
            @forelse($qas as $idx => $qa)
              <div class="qna-card">
                <span class="qna-card-num">0{{ $idx + 1 }} / {{ strtoupper($qa->perusahaan) }}</span>
                <h3 class="qna-question">{{ $qa->nama }} &mdash; {{ $qa->perusahaan }}</h3>
                <p class="qna-answer">{{ $qa->keterangan }}</p>
              </div>
            @empty
              <div class="qna-card">
                <h3 class="qna-question">Belum ada data QnA</h3>
                <p class="qna-answer">Data tanya jawab akan segera diperbarui.</p>
              </div>
            @endforelse
          </div>
        </div>

        <div class="qna-controls">
          <button class="qna-btn" id="qnaPrev" aria-label="Pertanyaan sebelumnya">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
          </button>

          <div class="qna-dots" id="qnaDots"></div>
          <span class="qna-counter" id="qnaCount">01 / 05</span>

          <button class="qna-btn" id="qnaNext" aria-label="Pertanyaan berikutnya">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION: FORMULIR KONSULTASI PROYEK
       ============================================================ -->
  <section id="consultation" class="section-wrap consultation-wrap">
    <div class="sec-container">
      <div class="sec-header">
        <div class="sec-badge">🤝 Mulai Kolaborasi</div>
        <h2 class="sec-title">Formulir <span class="highlight">Konsultasi Proyek</span></h2>
        <p class="sec-desc">
          Ceritakan ide, sistem yang ingin dibangun, atau tantangan teknologi bisnis Anda. Solution Architect kami siap memberikan estimasi, rekomendasi arsitektur, dan penawaran transparan.
        </p>
      </div>

      @if(session('consultation_success'))
        <div class="consult-alert-success">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
          </svg>
          <div>
            <h4>Permintaan Konsultasi Diterima!</h4>
            <p>{{ session('consultation_success') }}</p>
          </div>
        </div>
      @endif

      @if($errors->any())
        <div style="background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 16px; padding: 18px 24px; margin-bottom: 24px; color: #f87171;">
          <strong style="display:block; margin-bottom: 6px;">Harap periksa kembali isian formulir:</strong>
          <ul style="margin: 0; padding-left: 20px;">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="consultation-grid">
        <!-- FORM -->
        <div class="consultation-card">
          <form action="{{ route('konsultasi.store') }}" method="POST">
            @csrf
            
            <div class="form-row">
              <div class="form-group">
                <label>Nama Lengkap <span class="req">*</span></label>
                <input type="text" name="nama" class="form-control-dark" placeholder="Contoh: Budi Santoso" value="{{ old('nama') }}" required>
              </div>
              <div class="form-group">
                <label>Email Bisnis <span class="req">*</span></label>
                <input type="email" name="email" class="form-control-dark" placeholder="nama@perusahaan.com" value="{{ old('email') }}" required>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>Nomor WhatsApp / Telepon <span class="req">*</span></label>
                <input type="tel" name="nomor_telepon" class="form-control-dark" placeholder="Contoh: 081234567890" value="{{ old('nomor_telepon') }}" required>
              </div>
              <div class="form-group">
                <label>Nama Perusahaan / Organisasi</label>
                <input type="text" name="perusahaan" class="form-control-dark" placeholder="Contoh: PT Finansial Global" value="{{ old('perusahaan') }}">
              </div>
            </div>

            <div class="form-group">
              <label>Layanan yang Diminati</label>
              <select name="layanan" class="form-control-dark">
                <option value="">-- Pilih Layanan yang Anda Butuhkan --</option>
                @if(isset($masterJasas))
                  @foreach($masterJasas as $jasa)
                    <option value="{{ $jasa->jasa }}" {{ old('layanan') === $jasa->jasa ? 'selected' : '' }}>
                      {{ $jasa->jasa }} (Mulai Rp {{ number_format($jasa->harga, 0, ',', '.') }})
                    </option>
                  @endforeach
                @endif
                <option value="Konsultasi Arsitektur Kustom / Lainnya" {{ old('layanan') === 'Konsultasi Arsitektur Kustom / Lainnya' ? 'selected' : '' }}>Konsultasi Arsitektur Kustom / Lainnya</option>
              </select>
            </div>

            <div class="form-group">
              <label>Ceritakan Kebutuhan Proyek & Tantangan Bisnis Anda <span class="req">*</span></label>
              <textarea name="pesan" class="form-control-dark" rows="4" placeholder="Jelaskan gambaran sistem yang ingin dikembangkan, target waktu, atau integrasi spesifik yang diharapkan..." required>{{ old('pesan') }}</textarea>
            </div>

            <button type="submit" class="btn-submit-consult">
              <span>Kirim Permintaan Konsultasi</span>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"></line>
                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
              </svg>
            </button>
          </form>
        </div>

        <!-- PERKS / SIDE BENEFIT -->
        <div class="consult-perks">
          <div class="perk-box">
            <div class="perk-box-title">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#a78bfa" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
              </svg>
              Respons Cepat & Profesional
            </div>
            <p class="perk-box-desc">
              Tim engineering kami akan menelaah kebutuhan Anda dan memberikan feedback awal serta estimasi jadwal dalam kurun waktu kurang dari 24 jam kerja.
            </p>
          </div>

          <div class="perk-box">
            <div class="perk-box-title">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#a78bfa" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
              </svg>
              Perlindungan Kerahasiaan (NDA)
            </div>
            <p class="perk-box-desc">
              Ide dan data bisnis Anda aman sepenuhnya. Kami siap menandatangani Non-Disclosure Agreement (NDA) sebelum diskusi teknis mendalam dimulai.
            </p>
          </div>

          <div class="perk-box">
            <div class="perk-box-title">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#a78bfa" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                <line x1="8" y1="21" x2="16" y2="21"></line>
                <line x1="12" y1="17" x2="12" y2="21"></line>
              </svg>
              Konsultasi Bersama Tech Lead
            </div>
            <p class="perk-box-desc">
              Bukan sekadar perwakilan sales. Sesi konsultasi Anda akan didampingi oleh Principal Software Architect untuk merancang solusi teknis yang tepat sasaran.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
       SECTION 5: FOOTER (COMPANY PROFILE & CONTACT DATA)
       ============================================================ -->
  <footer id="contact" class="site-footer">
    <div class="sec-container">
      <div class="footer-grid">
        <div class="footer-brand">
          <a href="#" class="f-logo">
            <span>{{ $profil->namaPerusahaan ?? 'Coretech' }}</span>
          </a>
          <p>
            {{ $profil->namaPerusahaan ?? 'PT Coretech Rekayasa Digital' }} adalah penyedia solusi IT (Enterprise IT Solution) dan software engineering terkemuka di Indonesia. Kami berdedikasi membangun ekosistem teknologi kelas dunia yang andal, aman, dan berdaya saing global.
          </p>
          <div class="cert-badges">
            <span class="cert-pill">ISO 27001 Certified</span>
            <span class="cert-pill">PSE Terdaftar Kominfo</span>
            <span class="cert-pill">AWS Partner</span>
          </div>
        </div>

        <div>
          <h4 class="footer-title">Layanan Utama</h4>
          <ul class="footer-links">
            <li><a href="#services">Custom Web Application</a></li>
            <li><a href="#services">Mobile App (iOS & Android)</a></li>
            <li><a href="#services">Enterprise ERP & Core Banking</a></li>
            <li><a href="#services">Cloud Architecture & DevOps</a></li>
            <li><a href="#services">AI & Machine Learning Solutions</a></li>
            <li><a href="#services">Penetration Testing & Security</a></li>
          </ul>
        </div>

        <div>
          <h4 class="footer-title">Navigasi</h4>
          <ul class="footer-links">
            <li><a href="#advantages">Tentang & Keunggulan</a></li>
            <li><a href="#portfolio">Portofolio Studi Kasus</a></li>
            <li><a href="#news">Berita & Analisis Teknologi</a></li>
            <li><a href="#faq">Tanya Jawab (FAQ)</a></li>
            <li><a href="#contact">Konsultasi Project</a></li>
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
              <strong>Head Office:</strong><br>
              {{ $profil->alamat ?? 'Cyber 2 Tower Lantai 18, Jl. H.R. Rasuna Said, Jakarta Selatan' }}
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
        <p class="copyright">
          &copy; {{ date('Y') }} {{ $profil->namaPerusahaan ?? 'PT Coretech Rekayasa Digital' }}. Seluruh hak cipta dilindungi undang-undang.
        </p>

        <div class="footer-socials">
          @if(!empty($profil->instagram))
            <a href="https://instagram.com/{{ ltrim($profil->instagram, '@') }}" target="_blank" class="social-btn" aria-label="Instagram">
              <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
              </svg>
            </a>
          @endif
          @if(!empty($profil->linkedIN))
            <a href="{{ $profil->linkedIN }}" target="_blank" class="social-btn" aria-label="LinkedIn">
              <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                <rect x="2" y="9" width="4" height="12"></rect>
                <circle cx="4" cy="4" r="2"></circle>
              </svg>
            </a>
          @endif
          @if(!empty($profil->tiktok))
            <a href="https://tiktok.com/{{ $profil->tiktok }}" target="_blank" class="social-btn" aria-label="TikTok">
              <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path>
              </svg>
            </a>
          @endif
          @if(!empty($profil->treads))
            <a href="https://threads.net/{{ $profil->treads }}" target="_blank" class="social-btn" aria-label="Threads">
              <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M8 12a4 4 0 1 0 8 0 4 4 0 0 0-8 0"></path>
              </svg>
            </a>
          @endif
        </div>

        <div class="legal-links">
          <a href="#contact">Kebijakan Privasi</a>
          <span>•</span>
          <a href="#contact">Syarat & Ketentuan</a>
          <span>•</span>
          <a href="#contact">SLA Guarantee</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- ============================================================
       SCRIPTS: BURGER MENU
       ============================================================ -->
  <script>
    (function () {
      var burger = document.getElementById('burger');
      var menu = document.getElementById('menu');
      if (!burger || !menu) return;

      function set(open) {
        menu.classList.toggle('open', open);
        burger.setAttribute('aria-expanded', open ? 'true' : 'false');
        burger.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
      }

      burger.addEventListener('click', function (e) {
        e.stopPropagation();
        var isOpen = menu.classList.contains('open');
        set(!isOpen);
      });

      menu.addEventListener('click', function (e) {
        if (e.target.closest('a')) {
          set(false);
        }
      });

      document.addEventListener('click', function (e) {
        if (menu.classList.contains('open')) {
          if (!menu.contains(e.target) && !burger.contains(e.target)) {
            set(false);
          }
        }
      });

      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && menu.classList.contains('open')) {
          set(false);
          burger.focus();
        }
      });
    })();
  </script>

  <!-- ============================================================
       SCRIPTS: NAVBAR SCROLL EFFECT, SMOOTH ANCHOR, & SCROLLSPY
       ============================================================ -->
  <script>
    (function () {
      var nav = document.getElementById('mainNav');
      var navLinks = document.querySelectorAll('.nav-links a');
      var sections = document.querySelectorAll('section[id], footer[id]');

      // 1. Navbar blur background on scroll
      function updateNavBg() {
        if (!nav) return;
        if (window.scrollY > 30) {
          nav.classList.add('scrolled');
        } else {
          nav.classList.remove('scrolled');
        }
      }

      // 2. Scrollspy (Highlight active menu item based on scroll position)
      function updateScrollspy() {
        var scrollPosition = window.scrollY + 120;
        var currentSectionId = '';

        sections.forEach(function (sec) {
          var secTop = sec.offsetTop;
          var secHeight = sec.offsetHeight;
          if (scrollPosition >= secTop && scrollPosition < secTop + secHeight) {
            currentSectionId = sec.getAttribute('id');
          }
        });

        navLinks.forEach(function (link) {
          var href = link.getAttribute('href');
          if (href === '#' + currentSectionId) {
            link.classList.add('active');
          } else {
            link.classList.remove('active');
          }
        });
      }

      window.addEventListener('scroll', function () {
        updateNavBg();
        updateScrollspy();
      }, { passive: true });

      // 3. Smooth scrolling for all internal anchor links (#...)
      document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
          var targetId = this.getAttribute('href');
          if (!targetId || targetId === '#') return;

          var targetElement = document.querySelector(targetId);
          if (targetElement) {
            e.preventDefault();
            var navHeight = nav ? nav.offsetHeight : 70;
            var targetPos = targetElement.getBoundingClientRect().top + window.pageYOffset - navHeight + 5;

            window.scrollTo({
              top: Math.max(0, targetPos),
              behavior: 'smooth'
            });

            // Update URL hash without jumping
            if (history.pushState) {
              history.pushState(null, null, targetId);
            }
          }
        });
      });

      updateNavBg();
      updateScrollspy();
    })();
  </script>

  <!-- ============================================================
       SCRIPTS: QNA SLIDER (INTERACTIVE CAROUSEL)
       ============================================================ -->
  <script>
    (function initQnaSlider() {
      var track = document.getElementById('qnaTrack');
      var prevBtn = document.getElementById('qnaPrev');
      var nextBtn = document.getElementById('qnaNext');
      var dotsContainer = document.getElementById('qnaDots');
      var countEl = document.getElementById('qnaCount');
      if (!track || !prevBtn || !nextBtn) return;

      var slides = track.querySelectorAll('.qna-card');
      var total = slides.length;
      var currentIndex = 0;

      function getVisibleSlides() {
        if (window.innerWidth <= 768) return 1;
        if (window.innerWidth <= 1160) return 2;
        return 3;
      }

      function maxIndex() {
        return Math.max(0, total - getVisibleSlides());
      }

      function update() {
        var maxIdx = maxIndex();
        if (currentIndex > maxIdx) currentIndex = maxIdx;
        if (currentIndex < 0) currentIndex = 0;

        var slideWidth = slides[0] ? slides[0].offsetWidth : 0;
        var gap = 24;
        var offset = currentIndex * (slideWidth + gap);
        track.style.transform = 'translateX(-' + offset + 'px)';

        if (countEl) {
          var currentFormatted = (currentIndex + 1 < 10 ? '0' : '') + (currentIndex + 1);
          var totalFormatted = (total < 10 ? '0' : '') + total;
          countEl.textContent = currentFormatted + ' / ' + totalFormatted;
        }

        prevBtn.disabled = currentIndex === 0;
        nextBtn.disabled = currentIndex >= maxIdx;

        if (dotsContainer) {
          var dots = dotsContainer.querySelectorAll('.qna-dot');
          dots.forEach(function (dot, idx) {
            dot.classList.toggle('active', idx === currentIndex);
          });
        }
      }

      function renderDots() {
        if (!dotsContainer) return;
        dotsContainer.innerHTML = '';
        var maxIdx = maxIndex();
        for (var i = 0; i <= maxIdx; i++) {
          (function (idx) {
            var dot = document.createElement('button');
            dot.className = 'qna-dot' + (idx === currentIndex ? ' active' : '');
            dot.setAttribute('aria-label', 'Slide ' + (idx + 1));
            dot.addEventListener('click', function () {
              currentIndex = idx;
              update();
            });
            dotsContainer.appendChild(dot);
          })(i);
        }
      }

      prevBtn.addEventListener('click', function () {
        if (currentIndex > 0) {
          currentIndex--;
          update();
        }
      });

      nextBtn.addEventListener('click', function () {
        if (currentIndex < maxIndex()) {
          currentIndex++;
          update();
        }
      });

      // Touch swipe support
      var startX = 0;
      var currentX = 0;
      var isSwiping = false;

      track.addEventListener('touchstart', function (e) {
        startX = e.touches[0].clientX;
        isSwiping = true;
      }, { passive: true });

      track.addEventListener('touchmove', function (e) {
        if (!isSwiping) return;
        currentX = e.touches[0].clientX;
      }, { passive: true });

      track.addEventListener('touchend', function () {
        if (!isSwiping) return;
        isSwiping = false;
        var diff = startX - currentX;
        if (Math.abs(diff) > 40) {
          if (diff > 0 && currentIndex < maxIndex()) {
            currentIndex++;
          } else if (diff < 0 && currentIndex > 0) {
            currentIndex--;
          }
          update();
        }
      });

      var resizeTimer;
      window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
          renderDots();
          update();
        }, 100);
      });

      renderDots();
      update();
    })();
  </script>

  <!-- ============================================================
       SCRIPTS: DUAL VIDEO BACKGROUND CROSSFADE
       ============================================================ -->
  <script>
    (function () {
      var A = document.getElementById('bgVideoA');
      var B = document.getElementById('bgVideoB');
      if (!A || !B) return;

      if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        A.removeAttribute('autoplay');
        try {
          A.pause();
          B.pause();
          A.currentTime = 0;
        } catch (e) {}
        return;
      }

      var FADE = 0.9;
      var cur = A;
      var nxt = B;
      var swapping = false;

      function play(v) {
        var p = v.play();
        if (p && typeof p.catch === 'function') {
          p.catch(function () {});
        }
      }

      play(A);

      function tick() {
        if (swapping || !cur.duration) return;
        if (cur.duration - cur.currentTime > FADE) return;

        swapping = true;
        var out = cur;
        nxt.currentTime = 0;
        play(nxt);
        nxt.classList.add('is-active');
        out.classList.remove('is-active');

        var temp = cur;
        cur = nxt;
        nxt = temp;

        setTimeout(function () {
          try {
            out.pause();
            out.currentTime = 0;
          } catch (e) {}
          swapping = false;
        }, FADE * 1000 + 100);
      }

      A.addEventListener('timeupdate', tick);
      B.addEventListener('timeupdate', tick);
    })();
  </script>
</body>
</html>
