<nav class="navbar navbar-expand-lg main-navbar">
	<a class="header-brand" href="/">
		<img src="{{ request()->store->store_logo() }}" width="80" alt="Store logo">
	</a>
	<form class="form-inline ml-auto">
		<ul class="navbar-nav">
			<li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fa fa-navicon"></i></a></li>
		</ul>
        <div class=" form-inline mr-auto horizontal" id="headerMenuCollapse">
			<div class="d-none d-lg-block">
				<ul class="nav">
					@if(Auth::user()->is_superadmin())
						<li class="nav-item">
							<a class="nav-link mr-0" href="{{ request()->store->store_url() }}" target="_blank">
								<i class="fa fa-eye"></i>
								<span>معاينة المتجر</span>
							</a>
						</li>
					@endif
				</ul>
		    </div>
		</div>
	</form>
	<ul class="navbar-nav">
		<li class="dropdown dropdown-list-toggle">
			<a href="#" class="nav-link nav-link-lg full-screen-link">
				<i class="fa fa-expand"  id="fullscreen-button"></i>
			</a>
		</li>
		<li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg" dir="ltr">
			<img src="{{ Auth::user()->profile_picture() }}" alt="profile-user" class="rounded-circle w-32">
			<div class="d-sm-none d-lg-inline-block mx-1">{{ Auth::user()->name }}</div></a>
			<div class="dropdown-menu">
				<a href="/dashboard/store-settings" class="dropdown-item has-icon">
					<i class="ion ion-gear-a"></i> اعدادات المتجر
				</a>
				<a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item has-icon">
	                <i class="ion ion-log-out"></i> {{ __('Logout') }}
	            </a>
	            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	                @csrf
	            </form>
			</div>
		</li>
	</ul>
</nav>