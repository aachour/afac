	<!-- Menu -->
	<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme pt-3">

		<div class="app-brand demo">
			<a href="{{url('dashboard')}}" class="app-brand-link">
				<img src="{{asset('frontend/images/logo.svg')}}" style="max-width: 60%;" >
			</a>

			<a id="toggleButton" href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
				<i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
				<i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
			</a>
		</div>


		<div class="menu-inner-shadow"></div>

		<ul class="menu-inner py-1 mt-3">

			<li class="menu-item {{ request()->is('dashboard') ? "active" : "" }}">
				<a href="{{ route('dashboard') }}" class="menu-link">
					<i class="menu-icon tf-icons ti ti-home"></i>
					<div data-i18n="Dashboard">Dashboard</div>
				</a>
			</li>

			@canany(['role-list', 'permission-list', 'user-list'])
			<li class="menu-item {{ request()->is('roles') || request()->is('permissions') || request()->is('users*') || request()->is('types*') || request()->is('colors*') ? "active open" : "" }}">

				<a href="javascript:void(0);" class="menu-link menu-toggle">
					<i class="menu-icon tf-icons ti ti-settings"></i>
					<div data-i18n="Settings">Settings</div>
				</a>

				<ul class="menu-sub">

					@can('role-list')
					<li class="menu-item {{ request()->is('roles') ? "active" : "" }}">
						<a href="{{ route('roles') }}" class="menu-link">
						<div data-i18n="Roles">Roles</div>
						</a>
					</li>
					@endcan

					@can('user-list')
					<li class="menu-item {{ request()->is('users*') ? "active" : "" }}">
						<a href="{{ route('users') }}" class="menu-link">
							<div data-i18n="Users">Users</div>
						</a>
					</li>
					@endcan

					{{-- @can('type-list')
					<li class="menu-item {{ request()->is('types*') ? "active" : "" }}">
						<a href="{{ route('types') }}" class="menu-link">
							<div data-i18n="Entry Types">Entry Types</div>
						</a>
					</li>
					@endcan --}}

					@can('color-list')
					<li class="menu-item {{ request()->is('colors*') ? "active" : "" }}">
						<a href="{{ route('colors') }}" class="menu-link">
							<div data-i18n="Colors">Colors</div>
						</a>
					</li>
					@endcan

				</ul>
			</li>
			@endcanany


			@can('page-list')
			<li class="menu-item {{ request()->is('pages*') ? "active" : "" }}">
				<a href="{{ route('pages') }}" class="menu-link">
					<i class="menu-icon tf-icons ti ti-file-description"></i>
					<div data-i18n="Pages">Pages</div>
				</a>
			</li>
			@endcanany


			@can('collection-list')
			<li class="menu-item {{ request()->is('collections*') ? "active" : "" }}">
				<a href="{{ route('collections') }}" class="menu-link">
					<i class="menu-icon tf-icons ti ti-books"></i>
					<div data-i18n="Collections">Collections</div>
				</a>
			</li>
			@endcanany


			@canany(['eventCategory-list', 'event-list'])
			<li class="menu-item {{ request()->is('eventCategories*') || request()->is('entries/1*') ? "active open" : "" }}">

				<a href="javascript:void(0);" class="menu-link menu-toggle">
					<i class="menu-icon tf-icons ti ti-calendar-event"></i>
					<div data-i18n="Events">Events</div>
				</a>

				<ul class="menu-sub">

					@can('eventCategory-list')
					<li class="menu-item {{ request()->is('eventCategories*') ? "active" : "" }}">
						<a href="{{ route('event.categories') }}" class="menu-link">
						<div data-i18n="Categories">Categories</div>
						</a>
					</li>
					@endcan

					@can('event-list')
					<li class="menu-item {{ request()->is('entries/1*') ? "active" : "" }}">
						<a href="{{ route('entries',['typeId'=>'1']) }}" class="menu-link">
							<div data-i18n="Events">Events</div>
						</a>
					</li>
					@endcan

				</ul>
			</li>
			@endcanany


			@can('program-list')
			<li class="menu-item {{ request()->is('entries/2*') ? "active" : "" }}">
				<a href="{{ route('entries',['typeId'=>'2']) }}" class="menu-link">
					<i class="menu-icon tf-icons ti ti-presentation"></i>
					<div data-i18n="Programs">Programs</div>
				</a>
			</li>
			@endcanany


			@canany(['programs-list', 'projectCategory-list' , 'project-list'])
			<li class="menu-item {{ request()->is('entries*') || request()->is('projectCategories*') ? "active open" : "" }}">

				<a href="javascript:void(0);" class="menu-link menu-toggle">
					<i class="menu-icon tf-icons ti ti-rocket"></i>
					<div data-i18n="Projects">Projects</div>
				</a>

				<ul class="menu-sub">

					@can('projectCategory-list')
					<li class="menu-item {{ request()->is('projectCategories*') ? "active" : "" }}">
						<a href="{{ route('project.categories') }}" class="menu-link">
						<div data-i18n="Categories">Categories</div>
						</a>
					</li>
					@endcan

					@can('project-list')
					<li class="menu-item {{ request()->is('entries/3*') ? "active" : "" }}">
						<a href="{{ route('entries',['typeId'=>'3']) }}" class="menu-link">
							<div data-i18n="Projects">Projects</div>
						</a>
					</li>
					@endcan

				</ul>
			</li>
			@endcanany

			@can('grantee-list')
			<li class="menu-item {{ request()->is('entries/4*') ? "active" : "" }}">
				<a href="{{ route('entries',['typeId'=>'4']) }}" class="menu-link">
					<i class="menu-icon tf-icons ti ti-users"></i>
					<div data-i18n="Grantees">Grantees</div>
				</a>
			</li>
			@endcanany

			@can('jury-list')
			<li class="menu-item {{ request()->is('entries/5*') ? "active" : "" }}">
				<a href="{{ route('entries',['typeId'=>'5']) }}" class="menu-link">
					<i class="menu-icon tf-icons ti ti-scale"></i>
					<div data-i18n="Juries">Juries</div>
				</a>
			</li>
			@endcanany

			@can('resource-list')
			<li class="menu-item {{ request()->is('entries/6*') ? "active" : "" }}">
				<a href="{{ route('entries',['typeId'=>'6']) }}" class="menu-link">
					<i class="menu-icon tf-icons ti ti-database"></i>
					<div data-i18n="Resources">Resources</div>
				</a>
			</li>
			@endcanany

			@can('news-list')
			<li class="menu-item {{ request()->is('entries/7*') ? "active" : "" }}">
				<a href="{{ route('entries',['typeId'=>'7']) }}" class="menu-link">
					<i class="menu-icon tf-icons ti ti-news"></i>
					<div data-i18n="News">News</div>
				</a>
			</li>
			@endcanany

		
		</ul>

		<script>
			const toggleButton = document.getElementById("toggleButton");
			const logoImage = document.getElementById("logoImage");
			let isImageVisible = true;

			toggleButton.addEventListener("click", function() {
				if (isImageVisible) {
				logoImage.style.display = "none";
				} else {
				logoImage.style.display = "block";
				}
				isImageVisible = !isImageVisible;
			});
		</script>

	</aside>
	<!-- / Menu -->

