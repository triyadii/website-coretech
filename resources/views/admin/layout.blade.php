<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Admin Dashboard') — Coretech Studio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!-- Metronic Global Stylesheets -->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .app-sidebar-logo {
            padding: 0 24px;
            height: 70px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .brand-text {
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #ffffff 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
        }
        .table-responsive {
            border-radius: 0.625rem;
        }
    </style>
    @stack('styles')
</head>

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" class="app-default">
    <!-- Theme Mode Setup -->
    <script>
        var defaultThemeMode = "light";
        var themeMode = localStorage.getItem("data-bs-theme") || defaultThemeMode;
        document.documentElement.setAttribute("data-bs-theme", themeMode);
    </script>

    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            
            <!-- HEADER -->
            <div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize" data-kt-sticky-offset="{default: '200px', lg: '0'}">
                <div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
                    
                    <!-- Mobile Hamburger -->
                    <div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show sidebar menu">
                        <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                            <i class="ki-duotone ki-abstract-14 fs-2"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>

                    <!-- Header Title / Breadcrumb -->
                    <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                                @yield('page_title', 'Dashboard')
                            </h1>
                            <span class="text-muted fs-7 fw-semibold mt-1">@yield('page_subtitle', 'Sistem Manajemen Konten Coretech Studio')</span>
                        </div>
                    </div>

                    <!-- Topbar Right Navbar -->
                    <div class="d-flex align-items-stretch justify-content-end flex-lg-grow-1 gap-2 gap-md-3">
                        <!-- Dark / Light Mode Switcher -->
                        <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-sm btn-icon btn-light" id="kt_theme_toggle_btn" title="Ganti Mode Terang / Gelap">
                                <i class="ki-duotone ki-moon fs-2" id="kt_theme_icon"><span class="path1"></span><span class="path2"></span></i>
                            </button>
                        </div>

                        <!-- View Landing Page Link -->
                        <div class="d-flex align-items-center">
                            <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-light-primary fw-bold">
                                <i class="ki-duotone ki-exit-right-corner fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>
                                <span class="d-none d-sm-inline">Lihat Landing Page</span>
                            </a>
                        </div>

                        <!-- User Profile Info & Logout -->
                        <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center bg-light-primary rounded px-3 py-2 me-2">
                                <div class="symbol symbol-30px me-2">
                                    <div class="symbol-label fs-5 fw-bold bg-primary text-white">
                                        {{ strtoupper(substr(Auth::user()->nama ?? Auth::user()->username ?? 'A', 0, 1)) }}
                                    </div>
                                </div>
                                <div class="d-flex flex-column text-start">
                                    <span class="text-gray-900 fw-bold fs-7 lh-1">{{ Auth::user()->nama ?? Auth::user()->username }}</span>
                                    <span class="text-muted fs-8 fw-semibold lh-1 mt-1">{{ '@' . (Auth::user()->username ?? 'admin') }}</span>
                                </div>
                            </div>

                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-icon btn-light-danger" title="Keluar / Logout" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
                                    <i class="ki-duotone ki-entrance-left fs-3"><span class="path1"></span><span class="path2"></span></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- WRAPPER (SIDEBAR + MAIN CONTENT) -->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                
                <!-- SIDEBAR -->
                <div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="240px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
                    <!-- Brand Logo -->
                    <div class="app-sidebar-logo" id="kt_app_sidebar_logo">
                        <a href="{{ route('admin.dashboard') }}" class="brand-text d-flex align-items-center gap-2">
                            <i class="ki-duotone ki-code fs-1 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                            CORETECH
                        </a>
                    </div>

                    <!-- Sidebar Menu -->
                    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
                        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px">
                            <div class="menu menu-column menu-rounded menu-sub-indented fw-semibold px-3" id="#kt_app_sidebar_menu" data-kt-menu="true">
                                
                                <div class="menu-item pt-2 pb-1">
                                    <div class="menu-content"><span class="menu-section text-muted text-uppercase fs-8 ls-1">Ringkasan</span></div>
                                </div>

                                <!-- Dashboard -->
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                        <span class="menu-icon"><i class="ki-duotone ki-element-11 fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i></span>
                                        <span class="menu-title">Dashboard</span>
                                    </a>
                                </div>

                                <!-- Pesan Konsultasi -->
                                @php
                                    $pendingInquiries = \App\Models\Konsultasi::where('status', 'baru')->count();
                                @endphp
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('admin.konsultasi.*') ? 'active' : '' }}" href="{{ route('admin.konsultasi.index') }}">
                                        <span class="menu-icon"><i class="ki-duotone ki-messages fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i></span>
                                        <span class="menu-title">Pesan Konsultasi</span>
                                        @if($pendingInquiries > 0)
                                            <span class="badge badge-danger badge-circle fw-bold fs-8 ms-auto">{{ $pendingInquiries }}</span>
                                        @endif
                                    </a>
                                </div>

                                <div class="menu-item pt-4 pb-1">
                                    <div class="menu-content"><span class="menu-section text-muted text-uppercase fs-8 ls-1">Konten Landing Page</span></div>
                                </div>

                                <!-- 1. Portofolio -->
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('admin.portofolio.*') ? 'active' : '' }}" href="{{ route('admin.portofolio.index') }}">
                                        <span class="menu-icon"><i class="ki-duotone ki-briefcase fs-2"><span class="path1"></span><span class="path2"></span></i></span>
                                        <span class="menu-title">Portofolio</span>
                                    </a>
                                </div>

                                <!-- 2. QA -->
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('admin.qa.*') ? 'active' : '' }}" href="{{ route('admin.qa.index') }}">
                                        <span class="menu-icon"><i class="ki-duotone ki-message-question fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                                        <span class="menu-title">Tanya Jawab (QA)</span>
                                    </a>
                                </div>

                                <!-- 3. Berita -->
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}" href="{{ route('admin.berita.index') }}">
                                        <span class="menu-icon"><i class="ki-duotone ki-newspaper fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                                        <span class="menu-title">Berita & Artikel</span>
                                    </a>
                                </div>

                                <div class="menu-item pt-4 pb-1">
                                    <div class="menu-content"><span class="menu-section text-muted text-uppercase fs-8 ls-1">Pengaturan & Master</span></div>
                                </div>

                                <!-- 4. Master Jasa -->
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('admin.master-jasa.*') ? 'active' : '' }}" href="{{ route('admin.master-jasa.index') }}">
                                        <span class="menu-icon"><i class="ki-duotone ki-price-tag fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                                        <span class="menu-title">Master Jasa & Harga</span>
                                    </a>
                                </div>

                                <!-- 5. Profil Perusahaan -->
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('admin.profil.*') ? 'active' : '' }}" href="{{ route('admin.profil.index') }}">
                                        <span class="menu-icon"><i class="ki-duotone ki-geolocation fs-2"><span class="path1"></span><span class="path2"></span></i></span>
                                        <span class="menu-title">Profil Perusahaan</span>
                                    </a>
                                </div>

                                <!-- 6. User Management -->
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}" href="{{ route('admin.user.index') }}">
                                        <span class="menu-icon"><i class="ki-duotone ki-profile-user fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i></span>
                                        <span class="menu-title">Manajemen User</span>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Footer -->
                    <div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
                        <div class="d-flex align-items-center justify-content-between text-muted fs-8">
                            <span>Coretech v1.0</span>
                            <span class="badge badge-light-success">Online</span>
                        </div>
                    </div>
                </div>

                <!-- MAIN CONTENT AREA -->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <div class="d-flex flex-column flex-column-fluid">
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container container-fluid py-6">

                                <!-- Alert Messages -->
                                @if(session('success'))
                                    <div class="alert alert-success d-flex align-items-center p-4 mb-5">
                                        <i class="ki-duotone ki-check-circle fs-2hx text-success me-4"><span class="path1"></span><span class="path2"></span></i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-success fw-bold">Berhasil!</h4>
                                            <span>{{ session('success') }}</span>
                                        </div>
                                        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                            <i class="ki-duotone ki-cross fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
                                        </button>
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger d-flex align-items-center p-4 mb-5">
                                        <i class="ki-duotone ki-cross-circle fs-2hx text-danger me-4"><span class="path1"></span><span class="path2"></span></i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-danger fw-bold">Terjadi Kesalahan!</h4>
                                            <span>{{ session('error') }}</span>
                                        </div>
                                        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                            <i class="ki-duotone ki-cross fs-1 text-danger"><span class="path1"></span><span class="path2"></span></i>
                                        </button>
                                    </div>
                                @endif

                                @if($errors->any())
                                    <div class="alert alert-danger p-4 mb-5">
                                        <div class="fw-bold mb-2">Periksa kembali formulir input Anda:</div>
                                        <ul class="mb-0 ps-4">
                                            @foreach($errors->all() as $err)
                                                <li>{{ $err }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <!-- Page Yield Content -->
                                @yield('content')

                            </div>
                        </div>
                    </div>

                    <!-- FOOTER -->
                    <div id="kt_app_footer" class="app-footer">
                        <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
                            <div class="text-gray-900 order-2 order-md-1">
                                <span class="text-muted fw-semibold me-1">&copy; {{ date('Y') }}</span>
                                <a href="{{ route('home') }}" class="text-gray-800 text-hover-primary fw-bold">Coretech Studio</a>
                                <span class="text-muted ms-2">— Professional Software House</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Metronic Global Scripts -->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>

    <!-- Theme Mode Toggle Script -->
    <script>
        (function() {
            var toggleBtn = document.getElementById('kt_theme_toggle_btn');
            var icon = document.getElementById('kt_theme_icon');

            function applyTheme(mode) {
                document.documentElement.setAttribute('data-bs-theme', mode);
                localStorage.setItem('data-bs-theme', mode);

                if (!toggleBtn || !icon) return;
                if (mode === 'dark') {
                    toggleBtn.className = 'btn btn-sm btn-icon btn-light-warning';
                    toggleBtn.setAttribute('title', 'Beralih ke Mode Terang (Light Mode)');
                    icon.className = 'ki-duotone ki-sun fs-2 text-warning';
                } else {
                    toggleBtn.className = 'btn btn-sm btn-icon btn-light-dark';
                    toggleBtn.setAttribute('title', 'Beralih ke Mode Gelap (Dark Mode)');
                    icon.className = 'ki-duotone ki-moon fs-2 text-gray-800';
                }
            }

            var currentTheme = localStorage.getItem('data-bs-theme') || 'light';
            applyTheme(currentTheme);

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    var current = document.documentElement.getAttribute('data-bs-theme') || 'light';
                    var next = (current === 'dark') ? 'light' : 'dark';
                    applyTheme(next);
                });
            }
        })();
    </script>

    @stack('scripts')
</body>
</html>
