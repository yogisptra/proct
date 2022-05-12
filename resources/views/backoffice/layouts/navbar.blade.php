    <!-- Horizontal navigation-->
    <div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-light navbar-without-dd-arrow navbar-bordered navbar-shadow" role="navigation" data-menu="menu-wrapper">
      <!-- Horizontal menu content-->
      <div class="navbar-container main-menu-content" data-menu="menu-container">
        <!-- include ../../../includes/mixins-->
        <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
              <!-- Authentication Links -->
			@foreach($activeMenu as $menu)
				@if(count($menu->childs) == 0)
					@if($menu->shown == 'without-authorize')
						<li class="dropdown nav-item {{ Route::currentRouteName() == $menu->route ? 'active' :  '' }}">
							<a class="nav-link" 
								href="{{ Route::has($menu->route) == true ? route($menu->route) : '#' }}">
								<i class="{{ $menu->icon }}" title="{{ $menu->name }}"></i>
								<span data-i18n="nav.dash.main">{{ $menu->name }}</span>
							</a>
						</li>
					@else
						@can($menu->shown)
						<li class="dropdown nav-item {{ Route::currentRouteName() == $menu->route ? 'active' :  '' }}">
							<a class="nav-link" 
								href="{{ Route::has($menu->route) == true ? route($menu->route) : '#' }}">
								<i class="{{ $menu->icon }}" title="{{ $menu->name }}"></i>
								<span data-i18n="nav.dash.main">{{ $menu->name }}</span>
							</a>
						</li>
						@endcan
					@endif
				@elseif(count($menu->childs) > 0)
					<li class="dropdown nav-item" data-menu="dropdown">
						@if($menu->shown == 'without-authorize')
							@include('backoffice.layouts.childMenu',['childs' => $menu->childs])
						@else
							@can($menu->shown)
								@include('backoffice.layouts.childMenu',['childs' => $menu->childs])
							@endcan
						@endif
					</li>
				@endif
			@endforeach

        </ul>
      </div>
      <!-- /horizontal menu content-->
    </div>
    <!-- Horizontal navigation-->