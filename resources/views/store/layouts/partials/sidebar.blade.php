<aside class="app-sidebar">
	<div class="app-sidebar__user">
	    <div class="dropdown">
			<a class="nav-link pl-2 pr-2 leading-none d-flex" data-toggle="dropdown" href="#">
				<img alt="image" src="{{ Auth::user()->profile_picture() }}" class=" avatar-md rounded-circle">
				<span class="ml-2 d-lg-block">
					<span class="text-dark app-sidebar__user-name mt-5">{{ Auth::user()->name }}</span><br>
					<span class="text-muted app-sidebar__user-name text-sm">{{ Auth::user()->role() }}</span>
				</span>
			</a>
		</div>
	</div>
	<ul class="side-menu">
		<li>
			<a class="side-menu__item" href="/dashboard">
				<i class="side-menu__icon fa fa-desktop"></i>
				<span class="side-menu__label">{{ __('Dashboard') }}</span>
			</a>
		</li>
	</ul>
</aside>