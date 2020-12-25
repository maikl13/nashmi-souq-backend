<nav class="navbar navbar-expand-lg main-navbar">
	<a class="header-brand" href="/">
		<img src="{{ setting('logo') }}" width="80" alt="Admin logo">
	</a>
	<form class="form-inline mr-auto">
		<ul class="navbar-nav">
			<li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fa fa-navicon"></i></a></li>
		</ul>
	</form>
	<ul class="navbar-nav navbar-right">
		<li class="dropdown dropdown-list-toggle">
			<a href="#" class="nav-link nav-link-lg full-screen-link">
				<i class="fa fa-expand"  id="fullscreen-button"></i>
			</a>
		</li>
		<li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg">
			<img src="{{ Auth::user()->profile_picture() }}" alt="profile-user" class="rounded-circle w-32">
			<div class="d-sm-none d-lg-inline-block">{{ Auth::user()->name }}</div></a>
			<div class="dropdown-menu dropdown-menu-right">
				<a href="/stores/edit" class="dropdown-item has-icon">
					<i class="ion ion-gear-a"></i> بيانات المتجر
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