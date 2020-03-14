<!DOCTYPE html>
<html lang="en">
	<head>
		<title>{{ setting('website_name') }} | Admin | @yield('title')</title>
		@include('admin.layouts.partials.head')
		@yield('head')
	</head>

	<body class="app">
		<div id="spinner"></div>

		<div id="app" class="page">
			<div class="main-wrapper page-main" >

				@include('admin.layouts.partials.navbar')

				@include('admin.layouts.partials.sidebar')

				<div class="app-content">
					<div class="section">
                    	<ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                            @yield('breadcrumb')
							<li class="ml-auto d-lg-flex d-none">
								<span class="sparkline_bar mr-2 float-left"></span>
								<span class="float-left border-">
									<span class="mb-0 mt-1 mr-2">{{ App\Models\User::count() }}</span><small class="mb-0 mr-3">[ Users ]</small>
								</span>
							</li>
                        </ol>

						@yield('content')
					</div>
				</div>

				@include('admin.layouts.partials.footer')

				@yield('modals')

				@include('admin.layouts.partials.scripts')

				@yield('scripts')

			</div>
		</div>
	</body>
</html>