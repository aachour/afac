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

			@canany(['role-list', 'permission-list', 'user-list', 'country-list', 'color-list', 'logo-list' , 'file-list'])
			<li class="menu-item {{ request()->is('roles') || request()->is('permissions') || request()->is('users*') || request()->is('countries*') || request()->is('types*') || request()->is('colors*') || request()->is('files*') || request()->is('logo*') || request()->is('logoAnimation*') ? "active open" : "" }}">

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

					@can('logoAnimation-list')
					<li class="menu-item {{ request()->is('logoAnimation*') ? "active" : "" }}">
						<a href="{{ route('logo.animation') }}" class="menu-link">
							<div data-i18n="Logo Animation">Logo Animation</div>
						</a>
					</li>
					@endcan

					@can('logo-list')
					<li class="menu-item {{ request()->is('logoElements*') ? "active" : "" }}">
						<a href="{{ route('logo.elements') }}" class="menu-link">
							<div data-i18n="Logo Elements">Logo Elements</div>
						</a>
					</li>
					@endcan

					@can('country-list')
					<li class="menu-item {{ request()->is('countries*') ? "active" : "" }}">
						<a href="{{ route('countries') }}" class="menu-link">
							<div data-i18n="Countries">Countries</div>
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

					@can('file-list')
					<li class="menu-item {{ request()->is('files*') ? "active" : "" }}">
						<a href="{{ route('files') }}" class="menu-link">
							<div data-i18n="Files">Files</div>
						</a>
					</li>
					@endcan

				</ul>

			</li>
			@endcanany

			@canany(['formstack-forms', 'formstack-submissions'])
			<li class="menu-item {{ request()->is('formstackForms') || request()->is('formstackSubmissions') ? "active open" : "" }}">

				<a href="javascript:void(0);" class="menu-link menu-toggle">
					<i class="menu-icon tf-icons ti ti-api"></i>
					<div data-i18n="Formstack">Formstack</div>
				</a>

				<ul class="menu-sub">

					@can('formstack-forms')
					<li class="menu-item {{ request()->is('formstackForms') ? "active" : "" }}">
						<a href="{{ route('formstack.forms') }}" class="menu-link">
							<div data-i18n="Forms">Forms</div>
						</a>
					</li>
					@endcan

					@can('formstack-submissions')
					<li class="menu-item {{ request()->is('formstackSubmissions') ? "active" : "" }}">
						<a href="{{ route('formstack.submissions') }}" class="menu-link">
							<div data-i18n="Submissions">Submissions</div>
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
			<li class="menu-item {{ (request()->is('eventCategories*') || ( request()->is('entries/1*') && (!request()->is('entries/*/years*') && !request()->is('entries/*/grantees*')) )) ? 'active open' : '' }}">

				<a href="javascript:void(0);" class="menu-link menu-toggle">
					<i class="menu-icon tf-icons ti ti-calendar-event"></i>
					<div data-i18n="Events">Events</div>
				</a>

				<ul class="menu-sub">

					@can('eventCategory-list')
					<li class="menu-item {{ request()->is('eventCategories*') ? "active" : "" }}">
						<a href="{{ route('event.categories') }}" class="menu-link">
						<div data-i18n="Types">Types</div>
						</a>
					</li>
					@endcan

					@can('event-list')
					<li class="menu-item {{ ( request()->is('entries/1*') && !request()->is('entries/1/years*') ) ? "active" : "" }}">
						<a href="{{ route('entries',['typeId'=>'1']) }}" class="menu-link">
							<div data-i18n="Events">Events</div>
						</a>
					</li>
					@endcan

				</ul>
			</li>
			@endcanany


			@can('program-list')
			<li class="menu-item {{ (request()->is('entries/2*') || request()->is('entries/*/years*')) && !request()->is('entries/*/grantees*') ? "active" : "" }}">
				<a href="{{ route('entries',['typeId'=>'2']) }}" class="menu-link">
					<i class="menu-icon tf-icons ti ti-presentation"></i>
					<div data-i18n="Programs">Programs</div>
				</a>
			</li>
			@endcanany


			@canany(['projectCategory-list' , 'project-list'])
			<li class="menu-item {{ ( request()->is('projectCategories*') || request()->is('entries/3*') || request()->is('entries/*/grantees')) && !request()->is('entries/*/years*')    ? "active open" : "" }}">

				<a href="javascript:void(0);" class="menu-link menu-toggle">
					<i class="menu-icon tf-icons ti ti-rocket"></i>
					<div data-i18n="Projects">Projects</div>
				</a>

				<ul class="menu-sub">

					@can('projectCategory-list')
					<li class="menu-item {{ request()->is('projectCategories*') ? "active" : "" }}">
						<a href="{{ route('project.categories') }}" class="menu-link">
						<div data-i18n="Themes">Themes</div>
						</a>
					</li>
					@endcan

					@can('project-list')
					<li class="menu-item {{ request()->is('entries/3*') || request()->is('entries/*/grantees') ? "active" : "" }}">
						<a href="{{ route('entries',['typeId'=>'3']) }}" class="menu-link">
							<div data-i18n="Projects">Projects</div>
						</a>
					</li>
					@endcan

				</ul>
			</li>
			@endcanany

			@canany(['granteeCategory-list','grantee-list'])
			<li class="menu-item {{ (request()->is('granteeCategories*') || ( request()->is('entries/4*') && (!request()->is('entries/*/years*') && !request()->is('entries/*/grantees*')) )) ? 'active open' : '' }}">

				<a href="javascript:void(0);" class="menu-link menu-toggle">
					<i class="menu-icon tf-icons ti ti-users"></i>
					<div data-i18n="Grantees">Grantees</div>
				</a>

				<ul class="menu-sub">

					@can('granteeCategory-list')
					<li class="menu-item {{ request()->is('granteeCategories*') ? "active" : "" }}">
						<a href="{{ route('grantee.categories') }}" class="menu-link">
						<div data-i18n="Categories">Categories</div>
						</a>
					</li>
					@endcan

					@can('grantee-list')
					<li class="menu-item {{ request()->is('entries/4*') || request()->is('entries/*/grantees') ? "active" : "" }}">
						<a href="{{ route('entries',['typeId'=>'4']) }}" class="menu-link">
							<div data-i18n="Grantees">Grantees</div>
						</a>
					</li>
					@endcan

				</ul>

			</li>
			@endcanany

			@can('jury-list')
			<li class="menu-item {{ request()->is('entries/5*') && !request()->is('entries/*/years*') && !request()->is('entries/*/grantees*') ? "active" : "" }}">
				<a href="{{ route('entries',['typeId'=>'5']) }}" class="menu-link">
					<i class="menu-icon tf-icons ti ti-scale"></i>
					<div data-i18n="Juries">Juries</div>
				</a>
			</li>
			@endcan
			
			@canany(['resourceCategory-list','resource-list'])
			<li class="menu-item {{ (request()->is('resourceCategories*') || ( request()->is('entries/6*') && (!request()->is('entries/*/years*') && !request()->is('entries/*/resources*')) )) ? 'active open' : '' }}">

				<a href="javascript:void(0);" class="menu-link menu-toggle">
					<i class="menu-icon tf-icons ti ti-database"></i>
					<div data-i18n="Resources">Resources</div>
				</a>

				<ul class="menu-sub">

					@can('resourceCategory-list')
					<li class="menu-item {{ request()->is('resourceCategories*') ? "active" : "" }}">
						<a href="{{ route('resource.categories') }}" class="menu-link">
						<div data-i18n="Categories">Categories</div>
						</a>
					</li>
					@endcan

					@can('resource-list')
					<li class="menu-item {{ request()->is('entries/6*') || request()->is('entries/*/resources') ? "active" : "" }}">
						<a href="{{ route('entries',['typeId'=>'6']) }}" class="menu-link">
							<div data-i18n="Resources">Resources</div>
						</a>
					</li>
					@endcan

				</ul>

			</li>
			@endcanany

			@canany(['newsCategory-list','news-list'])
			<li class="menu-item {{ (request()->is('newsCategories*') || ( request()->is('entries/7*') && (!request()->is('entries/*/years*') && !request()->is('entries/*/news*')) )) ? 'active open' : '' }}">

				<a href="javascript:void(0);" class="menu-link menu-toggle">
					<i class="menu-icon tf-icons ti ti-news"></i>
					<div data-i18n="News">News</div>
				</a>

				<ul class="menu-sub">

					@can('newsCategory-list')
					<li class="menu-item {{ request()->is('newsCategories*') ? "active" : "" }}">
						<a href="{{ route('news.categories') }}" class="menu-link">
						<div data-i18n="Categories">Categories</div>
						</a>
					</li>
					@endcan

					@can('news-list')
					<li class="menu-item {{ request()->is('entries/7*') || request()->is('entries/*/news') ? "active" : "" }}">
						<a href="{{ route('entries',['typeId'=>'7']) }}" class="menu-link">
							<div data-i18n="News">News</div>
						</a>
					</li>
					@endcan

				</ul>

			</li>
			@endcanany
			
			
			@canany(['externalCategory-list','external-list'])
			<li class="menu-item {{ (request()->is('externalCategories*') || ( request()->is('entries/4*') && (!request()->is('entries/*/years*') && !request()->is('entries/*/externals*')) )) ? 'active open' : '' }}">

				<a href="javascript:void(0);" class="menu-link menu-toggle">
					<i class="menu-icon tf-icons ti ti-external-link"></i>
					<div data-i18n="Externals">Externals</div>
				</a>

				<ul class="menu-sub">

					@can('externalCategory-list')
					<li class="menu-item {{ request()->is('externalCategories*') ? "active" : "" }}">
						<a href="{{ route('external.categories') }}" class="menu-link">
						<div data-i18n="Categories">Categories</div>
						</a>
					</li>
					@endcan

					@can('external-list')
					<li class="menu-item {{ request()->is('entries/8*') || request()->is('entries/*/externals') ? "active" : "" }}">
						<a href="{{ route('entries',['typeId'=>'8']) }}" class="menu-link">
							<div data-i18n="Externals">Externals</div>
						</a>
					</li>
					@endcan

				</ul>

			</li>
			@endcanany

			@can('team-list')
			<li class="menu-item {{ request()->is('entries/9*') && !request()->is('entries/*/years*') && !request()->is('entries/*/grantees*') ? "active" : "" }}">
				<a href="{{ route('entries',['typeId'=>'9']) }}" class="menu-link">
					<i class="menu-icon tf-icons ti ti-users-group"></i>
					<div data-i18n="Team Members">Team Members</div>
				</a>
			</li>
			@endcan

			@can('board-list')
			<li class="menu-item {{ request()->is('entries/10*') && !request()->is('entries/*/years*') && !request()->is('entries/*/grantees*') ? "active" : "" }}">
				<a href="{{ route('entries',['typeId'=>'10']) }}" class="menu-link">
					<i class="menu-icon tf-icons ti ti-user-circle"></i>
					<div data-i18n="Board Members">Board Members</div>
				</a>
			</li>
			@endcan

		
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

