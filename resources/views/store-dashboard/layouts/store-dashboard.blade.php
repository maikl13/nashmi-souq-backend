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
                            <li class="breadcrumb-item"><a href="/dashboard">لوحة الإدارة</a></li>
                            @yield('breadcrumb')
						</ol>
						<div class="main-content m-0 p-0">
							@yield('content')
						</div>
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