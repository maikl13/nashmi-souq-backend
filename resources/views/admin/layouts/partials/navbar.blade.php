<nav class="navbar navbar-expand-lg main-navbar">
	<a class="header-brand" href="/">
		<img src="{{ setting('logo') }}" width="80" alt="Admin logo">
	</a>
	<form class="form-inline mr-auto">
		<ul class="navbar-nav">
			<li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fa fa-navicon"></i></a></li>
			<li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none navsearch"><i class="ion ion-search"></i></a></li>
		</ul>
        <div class=" form-inline mr-auto horizontal" id="headerMenuCollapse">
			<div class="d-none d-lg-block">
				<ul class="nav">
					@if(Auth::user()->is_superadmin())
						<li class="nav-item with-sub">
							<a class="nav-link mr-0" href="/admin/site-settings">
								<i class="fa fa-cog"></i>
								<span>{{ __('Website Settings') }}</span>
							</a>
							<div class="sub-item dropdown-menu-right">
								<ul>
									<li> <a href="/admin/site-settings" class="text-right">{{ __('Website Settings') }}</a> </li>
									<li> <a href="/admin/site-sections" class="text-right">{{ __('Website Sections') }}</a> </li>
								</ul>
							</div><!-- sub-item -->
						</li>
					@endif
				</ul>
		    </div>
		</div>
	</form>
	<ul class="navbar-nav navbar-right">
		
		@if(false)
		    <li class=""><a href="#" class=" "></a>
				<form class="form-inline mr-auto">
					<div class="search-element">
						<input type="search" class="form-control header-search" placeholder="Search…" aria-label="Search"tabindex="1">
						<button class="btn btn-primary" type="submit"><i class="ion ion-search"></i></button>
					</div>
			    </form>
			</li>
			<li class="dropdown dropdown-list-toggle d-none d-lg-block"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg "><i class="fa fa-envelope-o"></i></a><span class="pulse bg-danger"></span>
				<div class="dropdown-menu dropdown-list dropdown-menu-right">
					<div class="dropdown-header">Messages
						<div class="float-right">
							<a href="#">View All</a>
						</div>
					</div>
					<div class="dropdown-list-content">
						<a href="#" class="dropdown-item dropdown-item-unread">
							<img alt="image" src="/admin-assets/img/avatar/avatar-1.jpeg" class="rounded-circle dropdown-item-img">
							<div class="dropdown-item-desc">
								<div class="dropdownmsg d-flex">
									<div class="">
										<b>Stewart Ball</b>
										<p>Your template awesome</p>
									</div>
									<div class="time">6 hours ago</div>
								</div>

							</div>
						</a>
						<a href="#" class="dropdown-item">
							<img alt="image" src="/admin-assets/img/avatar/avatar-4.jpeg" class="rounded-circle dropdown-item-img">
							<div class="dropdown-item-desc">
								<div class="dropdownmsg d-flex">
									<div class="">
										<b>Victor Taylor</b>
										<p>Hi!, I' am web developer</p>
									</div>
									<div class="time"> 8 hours ago</div>
								</div>
							</div>
						</a>
					</div>
				</div>
			</li>
			<li class="dropdown dropdown-list-toggle d-none d-lg-block"><a href="#" data-toggle="dropdown" class="nav-link  nav-link-lg"><i class="fa fa-bell-o"></i></a><span class="pulse bg-danger"></span>
				<div class="dropdown-menu dropdown-list dropdown-menu-right">
					<div class="dropdown-header">Notifications
						<div class="float-right">
							<a href="#">View All</a>
						</div>
					</div>
					<div class="dropdown-list-content">
						<a href="#" class="dropdown-item">
							<i class="fa fa-users  text-primary"></i>
							<div class="dropdown-item-desc">
								<b>So many Users Visit your template</b>
							</div>
						</a>
					</div>
				</div>
			</li>
		@endif

		<li class="dropdown dropdown-list-toggle">
			<a href="#" class="nav-link nav-link-lg full-screen-link">
				<i class="fa fa-expand"  id="fullscreen-button"></i>
			</a>
		</li>
		<li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg">
			<img src="{{ Auth::user()->profile_picture() }}" alt="profile-user" class="rounded-circle w-32">
			<div class="d-sm-none d-lg-inline-block">{{ Auth::user()->name }}</div></a>
			<div class="dropdown-menu dropdown-menu-right">
				<a href="/admin/profile" class="dropdown-item has-icon">
					<i class="ion ion-android-person"></i> {{ __('Profile') }}
				</a> 
				<a href="/admin/profile/edit" class="dropdown-item has-icon">
					<i class="ion ion-gear-a"></i> {{ __('Account Settings') }}
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