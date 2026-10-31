<!DOCTYPE html>
<html lang="id">
	<!--begin::Head-->
	<head>
		<title>Login Administrator — Coretech Studio</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center" style="background-color: #0b0c10;">
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				<!--begin::Body-->
				<div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
					<!--begin::Form-->
					<div class="d-flex flex-center flex-column flex-lg-row-fluid">
						<!--begin::Wrapper-->
						<div class="w-lg-500px p-10 card shadow-sm border border-gray-800" style="background: rgba(18, 18, 24, 0.9); backdrop-filter: blur(20px);">
							<!--begin::Form-->
							<form class="form w-100" method="POST" action="{{ route('login.post') }}">
								@csrf
								<!--begin::Heading-->
								<div class="text-center mb-11">
									<!--begin::Title-->
									<h1 class="text-white fw-bolder mb-3 fs-2qx">Admin Portal</h1>
									<!--end::Title-->
									<!--begin::Subtitle-->
									<div class="text-gray-400 fw-semibold fs-6">Coretech Management System</div>
									<!--end::Subtitle=-->
								</div>
								<!--end::Heading-->

								@if ($errors->any())
									<div class="alert alert-danger d-flex align-items-center p-4 mb-8">
										<div class="d-flex flex-column">
											<h5 class="mb-1 text-danger">Gagal Masuk</h5>
											<span>{{ $errors->first() }}</span>
										</div>
									</div>
								@endif

								@if (session('success'))
									<div class="alert alert-success d-flex align-items-center p-4 mb-8">
										<span>{{ session('success') }}</span>
									</div>
								@endif

								<!--begin::Input group=-->
								<div class="fv-row mb-8">
									<label class="form-label text-gray-300 fs-7 fw-bold mb-2">Username atau Email</label>
									<input type="text" placeholder="Masukkan username atau email terdaftar" name="login" value="{{ old('login') }}" autocomplete="off" class="form-control bg-dark border-gray-700 text-white" required />
								</div>
								<!--end::Input group=-->

								<!--begin::Input group=-->
								<div class="fv-row mb-6">
									<label class="form-label text-gray-300 fs-7 fw-bold mb-2">Password</label>
									<input type="password" placeholder="Masukkan password Anda" name="password" autocomplete="off" class="form-control bg-dark border-gray-700 text-white" required />
								</div>
								<!--end::Input group=-->

								<div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
									<label class="form-check form-check-custom form-check-solid">
										<input class="form-check-input" type="checkbox" name="remember" />
										<span class="form-check-label text-gray-400 fs-7">Ingat saya</span>
									</label>
								</div>

								<!--begin::Submit button-->
								<div class="d-grid mb-8">
									<button type="submit" class="btn btn-primary py-3">
										<span class="indicator-label fw-bold">Masuk ke Dashboard</span>
									</button>
								</div>
								<!--end::Submit button-->

								<div class="text-center">
									<a href="{{ url('/') }}" class="text-gray-400 text-hover-primary fs-7">
										&larr; Kembali ke Landing Page
									</a>
								</div>
							</form>
							<!--end::Form-->
						</div>
						<!--end::Wrapper-->
					</div>
					<!--end::Form-->
				</div>
				<!--end::Body-->

				<!--begin::Aside-->
				<div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background: radial-gradient(circle at 50% 50%, rgba(167, 139, 250, 0.15) 0%, #060608 100%); border-left: 1px solid rgba(255,255,255,0.08);">
					<div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
						<div class="text-center mb-10">
							<h2 class="text-white fs-2tx fw-bold mb-4">Coretech Studio</h2>
							<p class="text-gray-400 fs-6 max-w-400px mx-auto">
								Panel administrasi terpadu untuk mengelola Portofolio, Tanya Jawab (QA), Berita & Wawasan, Profil Perusahaan, Manajemen User, dan Master Jasa.
							</p>
						</div>
					</div>
				</div>
				<!--end::Aside-->
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
		<!--end::Root-->

		<!--begin::Javascript-->
		<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>