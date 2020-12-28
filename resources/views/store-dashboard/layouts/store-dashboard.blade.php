<!DOCTYPE html>
<html lang="en">
	<head>
		<title>{{ setting('website_name') }} | {{ __('Admin Panel') }} | @yield('title')</title>
		@include('store-dashboard.layouts.partials.head')
		@yield('head')
	</head>

	<body class="app">
		<div id="spinner"></div>

		<div id="app" class="page">
			<div class="main-wrapper page-main" >

				@include('store-dashboard.layouts.partials.navbar')

				@include('store-dashboard.layouts.partials.sidebar')

				<div class="app-content">
					<div class="section">
                    	<ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            @yield('breadcrumb')
							<li class="ml-auto d-lg-flex d-none">
								<span class="sparkline_bar mr-2 float-left"></span>
								<span class="float-left border-">
									<span class="mb-0 mt-1 mr-2">{{ App\Models\User::count() }}</span><small class="mb-0 mr-3">[ مستخدمين ]</small>
								</span>
							</li>
                        </ol>
						@yield('content')
					</div>
				</div>

				@include('store-dashboard.layouts.partials.footer')

				@yield('modals')

				@include('store-dashboard.layouts.partials.scripts')

				@yield('scripts')

			</div>
		</div>
	</body>
</html>