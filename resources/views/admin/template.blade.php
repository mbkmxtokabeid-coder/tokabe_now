<!DOCTYPE html>
<html lang="en">

<head>

	<title>Tokabe - Admin</title>
	<!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 11]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description"
		content="Dasho Bootstrap admin template made using Bootstrap 5 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
	<meta name="keywords"
		content="admin templates, bootstrap admin templates, bootstrap 5, dashboard, dashboard templets, sass admin templets, html admin templates, responsive, bootstrap admin templates free download,premium bootstrap admin templates, Dasho, Dasho bootstrap admin template">
	<meta name="author" content="Phoenixcoded" />

	<!-- Favicon icon -->
	<link rel="icon" href="{{asset('dashboard_assets/images/favicon.svg')}}" type="image/x-icon">
	<!-- fontawesome icon -->
	<link rel="stylesheet" href="{{asset('dashboard_assets/fonts/fontawesome/css/fontawesome-all.min.css')}}">
	<!-- animation css -->
	<link rel="stylesheet" href="{{asset('dashboard_assets/plugins/animation/css/animate.min.css')}}">

	<!-- notification css -->
	<link rel="stylesheet" href="{{asset('dashboard_assets/plugins/notification/css/notification.min.css')}}">

	<!-- vendor css -->
	<link rel="stylesheet" href="{{asset('dashboard_assets/css/style.css')}}">

	<link rel="stylesheet" href="{{asset('dashboard_assets/plugins/data-tables/css/datatables.min.css')}}">

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<!-- Custom Minimalist Sidebar CSS -->
	<style>
		.pcoded-navbar {
			background: #ffffff !important;
			box-shadow: none !important;
			border-right: 1px solid #f1f5f9;
		}
		.pcoded-navbar .pcoded-inner-navbar li.pcoded-menu-caption {
			background: transparent !important;
			padding: 25px 20px 10px 20px !important;
		}
		.pcoded-navbar .pcoded-inner-navbar li.pcoded-menu-caption label {
			color: #000000 !important;
			font-weight: 700 !important;
			font-size: 14px !important;
			text-transform: capitalize !important;
		}
		.pcoded-navbar .pcoded-inner-navbar > li > a {
			color: #111827 !important;
			padding: 12px 20px !important;
			margin: 4px 16px !important;
			border-radius: 8px !important;
			transition: all 0.2s ease;
		}
		.pcoded-navbar .pcoded-inner-navbar > li > a .pcoded-micon i {
			color: #111827 !important;
			font-size: 18px !important;
			margin-right: 12px !important;
		}
		.pcoded-navbar .pcoded-inner-navbar > li > a .pcoded-mtext {
			font-size: 15px !important;
			font-weight: 500 !important;
		}
		.pcoded-navbar .pcoded-inner-navbar > li.active > a, 
		.pcoded-navbar .pcoded-inner-navbar > li:hover > a {
			background: #e2e8f0 !important;
			color: #000000 !important;
			font-weight: 600 !important;
		}
		.pcoded-navbar .pcoded-inner-navbar > li.active > a .pcoded-micon i, 
		.pcoded-navbar .pcoded-inner-navbar > li:hover > a .pcoded-micon i {
			color: #000000 !important;
		}
		.navbar-brand {
			background: #ffffff !important;
			border-bottom: none !important;
		}
		.pcoded-navbar .navbar-content {
			height: calc(100vh - 140px) !important; 
		}
		.pcoded-navbar .pcoded-inner-navbar {
			padding-bottom: 100px !important;
		}
		
		/* Minimalist Submenu */
		.pcoded-navbar .pcoded-inner-navbar li.pcoded-hasmenu .pcoded-submenu {
			background: transparent !important;
			padding-left: 20px !important;
		}
		.pcoded-navbar .pcoded-inner-navbar li.pcoded-hasmenu .pcoded-submenu li > a {
			color: #374151 !important;
			padding: 10px 20px 10px 30px !important;
			font-weight: 500 !important;
		}
		.pcoded-navbar .pcoded-inner-navbar li.pcoded-hasmenu .pcoded-submenu li > a:hover {
			color: #000000 !important;
			background: transparent !important;
			font-weight: 600 !important;
		}
		.pcoded-navbar .pcoded-inner-navbar li.pcoded-hasmenu > a:after {
			color: #111827 !important;
		}

		/* User Profile Widget at Bottom */
		.sidebar-user-profile {
			position: absolute;
			bottom: 0;
			left: 0;
			width: 100%;
			padding: 20px;
			background: #ffffff;
			border-top: 1px solid #e2e8f0;
			display: flex;
			align-items: center;
			justify-content: space-between;
			cursor: pointer;
			transition: background 0.2s;
		}
		.sidebar-user-profile:hover {
			background: #e2e8f0;
		}
		.sidebar-user-profile .user-info {
			display: flex;
			align-items: center;
			gap: 12px;
		}
		.sidebar-user-profile .user-avatar {
			width: 36px;
			height: 36px;
			background: transparent;
			display: flex;
			align-items: center;
			justify-content: center;
			color: #000000;
			font-size: 22px;
		}
		.sidebar-user-profile .user-details {
			display: flex;
			flex-direction: column;
		}
		.sidebar-user-profile .user-name {
			font-weight: 700;
			font-size: 14px;
			color: #000000;
			line-height: 1.2;
		}
		.sidebar-user-profile .user-email {
			font-size: 13px;
			color: #374151;
		}

		/* Top Header Minimalist & Logo Contrast */
		.b-brand .logo, .b-brand .logo-thumb {
			filter: brightness(0) opacity(0.8);
		}
		.pcoded-header {
			background: #ffffff !important;
			box-shadow: none !important;
			border-bottom: 1px solid #e2e8f0;
		}
		.pcoded-header .m-header {
			background: #ffffff !important;
			box-shadow: none !important;
		}
		.pcoded-header .m-header .mobile-menu span,
		.pcoded-header .m-header .mobile-menu span:after,
		.pcoded-header .m-header .mobile-menu span:before {
			background-color: #111827 !important;
		}
		.pcoded-header .mobile-menu[id="mobile-header"] i {
			color: #111827 !important;
		}
		
		/* Search Bar Minimalist */
		.pcoded-header .main-search .input-group .form-control {
			border-radius: 6px 0 0 6px !important;
			border: 1px solid #e2e8f0 !important;
			background: #f8fafc !important;
			color: #111827 !important;
		}
		.pcoded-header .main-search .search-btn {
			border-radius: 0 6px 6px 0 !important;
			background: #111827 !important;
			border: 1px solid #111827 !important;
			color: #ffffff !important;
			box-shadow: none !important;
		}
		.pcoded-header .main-search .search-btn i {
			color: #ffffff !important;
		}
		.pcoded-header .main-search .search-close i {
			color: #64748b !important;
		}
	</style>

</head>

<body class="">
	<!-- [ Pre-loader ] start -->
	<div class="loader-bg">
		<div class="loader-track">
			<div class="loader-fill"></div>
		</div>
	</div>
	<!-- [ Pre-loader ] End -->
	<!-- [ navigation menu ] start -->
	<nav class="pcoded-navbar menupos-fixed menu-light">
		<div class="navbar-wrapper">
			<div class="navbar-brand header-logo">
				<a href="/admin" class="b-brand">
					<img src="{{asset('dashboard_assets/images/logo.svg')}}" alt="logo" class="logo images">
					<img src="{{asset('dashboard_assets/images/logo-icon.svg')}}" alt="logo" class="logo-thumb images">
				</a>
				<a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
			</div>
			<div class="navbar-content scroll-div" id="layout-sidenav">
				<ul class="nav pcoded-inner-navbar sidenav-inner">
					<li class="nav-item pcoded-menu-caption">
						<label>Application</label>
					</li>
					<li class="nav-item">
						<a href="/admin" class="nav-link"><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Home</span></a>
					</li>
					
					<li class="nav-item"><a href="{{route('hero')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-grid"></i></span><span class="pcoded-mtext">Heroes</span></a></li>

					<li class="nav-item"><a href="{{ route('admin.about.index') }}" class="nav-link"><span class="pcoded-micon"><i
									class="feather icon-info"></i></span><span class="pcoded-mtext">About Us</span></a>
					</li>

					<li data-username="dashboard default ecommerce sales Helpdesk ticket CRM analytics project"
						class="nav-item">
						<a href="{{ route('service-list') }}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-server"></i></span><span
								class="pcoded-mtext">Service</span></a>
					</li>
					<li data-username="detail service categories" class="nav-item pcoded-hasmenu">
						<a href="#!" class="nav-link"><span class="pcoded-micon"><i class="feather icon-layers"></i></span><span
								class="pcoded-mtext">Detail Service</span></a>
						<ul class="pcoded-submenu">
							@php $sidebarServices = \App\Models\Service::all(); @endphp
							@foreach($sidebarServices as $s)
								@php
									$sj = is_array($s->judul) ? ($s->judul['id'] ?? $s->judul['en'] ?? 'Unknown') : ($s->judul ?: 'Unknown');
								@endphp
								<li class=""><a href="{{ route('service-details.index', ['service_id' => $s->id]) }}" class="">{{ $sj }}</a></li>
							@endforeach
						</ul>
					</li>
					<li data-username="basic components button alert badges breadcrumb pagination progress tooltip popovers carousel cards collapse tabs pills modal spinner grid system toasts typography extra shadows embeds"
						class="nav-item pcoded-hasmenu">
						<a href="#!" class="nav-link"><span class="pcoded-micon"><i class="feather icon-box"></i></span><span
								class="pcoded-mtext">Lokasi Periklanan</span></a>
						<ul class="pcoded-submenu">
							<li class=""><a href="{{ route('lokasi-list') }}" class="">DOOH Videotron</a></li>
							<li class=""><a href="{{route('wilayah-list-ooh')}}" class="">OOH Bilboard</a></li>
						</ul>
					</li>
					
					

					<li data-username="animations" class="nav-item"><a href="{{ route('partner-list') }}" class="nav-link"><span class="pcoded-micon"><i
									class="feather icon-aperture"></i></span><span class="pcoded-mtext">Partnership</span></a>
					</li>


					<li data-username="animations" class="nav-item"><a href="{{ route('contact-admin') }}" class="nav-link"><span
								class="pcoded-micon"><i class="feather icon-phone"></i></span><span
								class="pcoded-mtext">Kontak</span></a></li>
					<li data-username="portofolio dropdown menu" class="nav-item pcoded-hasmenu">
						<a href="#!" class="nav-link"><span class="pcoded-micon"><i class="feather icon-briefcase"></i></span><span
								class="pcoded-mtext">Portofolio</span></a>
						<ul class="pcoded-submenu">
							<li class=""><a href="{{ route('portofolio.index') }}" class="">Daftar Portofolio</a></li>
							<li class=""><a href="{{ route('portofolio_categories.index') }}" class="">Kategori Portofolio</a></li>
						</ul>
					</li>

					<li class="nav-item">
						<a href="{{ route('admin.faq.index') }}" class="nav-link"><span
								class="pcoded-micon"><i class="feather icon-help-circle"></i></span><span
								class="pcoded-mtext">FAQ</span></a>
					</li>
					<li class="nav-item">
						<a href="{{ route('admin.legality.index') }}" class="nav-link"><span
								class="pcoded-micon"><i class="feather icon-file-text"></i></span><span
								class="pcoded-mtext">Legalitas</span></a>
					</li>
    </li>
    <!-- Selesai -->
				</ul>
			</div>
			
			<!-- Bottom User Profile Widget -->
			<div class="sidebar-user-profile">
				<div class="user-info">
					<div class="user-avatar">
						<i class="feather icon-user"></i>
					</div>
					<div class="user-details">
						<span class="user-name">{{ Auth::user()->name ?? 'Admin' }}</span>
						<span class="user-email">{{ Auth::user()->email ?? 'admin@example.com' }}</span>
					</div>
				</div>
				<i class="feather icon-code"></i>
			</div>
			
		</div>
	</nav>
	<!-- [ navigation menu ] end -->

	

	<!-- [ Header ] start -->
	<header class="navbar pcoded-header navbar-expand-lg navbar-light headerpos-fixed">
		
			<div class="m-header">
				<a class="mobile-menu" id="mobile-collapse1" href="#!"><span></span></a>
				<a href="/admin" class="b-brand">

					<img src="{{asset('dashboard_assets/images/logo.svg')}}" alt="" class="logo images">
					<img src="{{asset('dashboard_assets/images/logo-icon.svg')}}" alt="" class="logo-thumb images">
				</a>
			</div>
			<a class="mobile-menu" id="mobile-header" href="#!">
				<i class="feather icon-more-horizontal"></i>
			</a>
			<div class="collapse navbar-collapse">
				<a href="#!" class="mob-toggler"></a>
				
			</div>
			
	</header>
	<!-- [ Header ] end -->

    @yield('content')


@stack('scripts')
<!-- Required Js -->
<script src="{{asset('dashboard_assets/js/vendor-all.min.js')}}"></script>
<script src="{{asset('dashboard_assets/plugins/bootstrap/js/popper.min.js')}}"></script>
<script src="{{asset('dashboard_assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('dashboard_assets/js/pcoded.min.js')}}"></script>

<!-- datatable js -->
<script src="{{asset('dashboard_assets/plugins/data-tables/js/datatables.min.js')}}"></script>
<script src="{{asset('dashboard_assets/js/pages/data-basic-custom.js')}}"></script>

<!-- sweet alert Js -->
<script src="{{asset('dashboard_assets/plugins/sweetalert/js/sweetalert.min.js')}}"></script>
<script src="{{asset('dashboard_assets/js/pages/ac-alert.js')}}"></script>
</body>

</html>