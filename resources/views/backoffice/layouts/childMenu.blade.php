<a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="{{ $menu->icon }}"></i>
	<span data-i18n="nav.dash.main">{{ $menu->name }}</span>
</a>

<ul class="dropdown-menu">
	@foreach($childs as $child)
		@if($menu->id == $child->parent_id)
			@if($child->shown == 'without-authorize')
				@if(count($child->childs) > 0)
					<li class="dropdown dropdown-submenu" data-menu="dropdown-submenu" class="{{ Route::currentRouteName() == $child->route ? 'active' :  '' }}">
						<a class="dropdown-item dropdown-toggle" href="{{ Route::has($child->route) == true ? route($child->route) : '#' }}" data-toggle="dropdown">
							{{ $child->name }}
						</a>

						<ul class="dropdown-menu">
							@foreach($child->childs as $item)
								@if($child->id == $item->parent_id)
									@if($item->shown == 'without-authorize')
										<li data-menu="" class="{{ Route::currentRouteName() == $item->route ? 'active' :  '' }}">
											<a class="dropdown-item" href="{{ Route::has($item->route) == true ? route($item->route) : '#' }}" data-toggle="dropdown">
												{{ $item->name }}
											</a>
										</li>
									@else
										@can($item->shown)
										<li data-menu="" class="{{ Route::currentRouteName() == $item->route ? 'active' :  '' }}">
											<a class="dropdown-item" href="{{ Route::has($item->route) == true ? route($item->route) : '#' }}" data-toggle="dropdown">
												{{ $item->name }}
											</a>
										</li>
										@endcan
									@endif
								@endif
							@endforeach
						</ul>

					</li>
				@else
					<li data-menu="" class="{{ Route::currentRouteName() == $child->route ? 'active' :  '' }}">
						<a class="dropdown-item" href="{{ Route::has($child->route) == true ? route($child->route) : '#' }}" data-toggle="dropdown">
							{{ $child->name }}
						</a>
					</li>
				@endif
			@else

				@can($child->shown)
				@if(count($child->childs) > 0)
					<li class="dropdown dropdown-submenu" data-menu="dropdown-submenu" class="{{ Route::currentRouteName() == $child->route ? 'active' :  '' }}">
						<a class="dropdown-item dropdown-toggle" href="{{ Route::has($child->route) == true ? route($child->route) : '#' }}" data-toggle="dropdown">
							{{ $child->name }}
						</a>

						<ul class="dropdown-menu">
							@foreach($child->childs as $item)
								@if($child->id == $item->parent_id)
									@if($item->shown == 'without-authorize')
										<li data-menu="" class="{{ Route::currentRouteName() == $item->route ? 'active' :  '' }}">
											<a class="dropdown-item" href="{{ Route::has($item->route) == true ? route($item->route) : '#' }}" data-toggle="dropdown">
												{{ $item->name }}
											</a>
										</li>
									@else
										@can($item->shown)
										<li data-menu="" class="{{ Route::currentRouteName() == $item->route ? 'active' :  '' }}">
											<a class="dropdown-item" href="{{ Route::has($item->route) == true ? route($item->route) : '#' }}" data-toggle="dropdown">
												{{ $item->name }}
											</a>
										</li>
										@endcan
									@endif
								@endif
							@endforeach
						</ul>

					</li>
				@else
					<li data-menu="" class="{{ Route::currentRouteName() == $child->route ? 'active' :  '' }}">
						<a class="dropdown-item" href="{{ Route::has($child->route) == true ? route($child->route) : '#' }}" data-toggle="dropdown">
							{{ $child->name }}
						</a>
					</li>
				@endif
				@endcan
			@endif
		@endif
	@endforeach
</ul>