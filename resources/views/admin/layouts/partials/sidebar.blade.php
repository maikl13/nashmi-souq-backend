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
			<a class="side-menu__item" href="/admin">
				<i class="side-menu__icon fa fa-desktop"></i>
				<span class="side-menu__label">{{ __('Dashboard') }}</span>
			</a>
		</li>
		<li>
			<a class="side-menu__item" href="/admin/users">
				<i class="side-menu__icon fa fa-users"></i>
				<span class="side-menu__label">{{ __('Users') }}</span>
			</a>
		</li>
		<li>
			<a class="side-menu__item" href="/admin/listings">
				<i class="side-menu__icon fa fa-list"></i>
				<span class="side-menu__label">الإعلانات</span>
			</a>
		</li>
		<li>
			<a class="side-menu__item" href="/admin/categories">
				<i class="side-menu__icon fa fa-tags"></i>
				<span class="side-menu__label">{{ __('Categories') }}</span>
			</a>
		</li>
		<li>
			<a class="side-menu__item" href="/admin/countries">
				<i class="side-menu__icon fa fa-map-marker"></i>
				<span class="side-menu__label">البلاد</span>
			</a>
		</li>
		<li>
			<a class="side-menu__item" href="/admin/currencies">
				<i class="side-menu__icon fa fa-euro"></i>
				<span class="side-menu__label">العملات</span>
			</a>
		</li>
		<li>
			<a class="side-menu__item" href="/admin/transactions">
				<i class="side-menu__icon fa fa-dollar"></i>
				<span class="side-menu__label">العمليات المالية</span>
				@if (App\Models\Transaction::where('type', App\Models\Transaction::TYPE_WITHDRAWAL)->where('status', App\Models\Transaction::STATUS_PENDING)->count())
					<span class="badge badge-default">{{ App\Models\Transaction::where('type', App\Models\Transaction::TYPE_WITHDRAWAL)->where('status', App\Models\Transaction::STATUS_PENDING)->count() }}</span>
				@endif
			</a>
		</li>
		<li>
			<a class="side-menu__item" href="/admin/bs">
				<i class="side-menu__icon fa fa-rocket"></i>
				<span class="side-menu__label">البانرات الإعلانية</span>
			</a>
		</li>
		@if(Auth::user()->is_superadmin())
			<li class="slide d-lg-none">
				<a class="side-menu__item"  data-toggle="slide" href="#">
					<i class="side-menu__icon fa fa-gear"></i>
					<span class="side-menu__label">{{ __('Website Settings') }}</span>
					<i class="angle fa fa-angle-right"></i>
				</a>
				<ul class="slide-menu">
					<li> <a class="slide-item" href="/admin/site-settings">{{ __('Website Settings') }}</a> </li>
					<li> <a class="slide-item" href="/admin/site-sections">{{ __('Website Sections') }}</a> </li>
				</ul>
			</li>
		@endif
	</ul>
</aside>