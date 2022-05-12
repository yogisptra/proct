<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-static-top navbar-light navbar-border navbar-brand-center" data-nav="brand-center">
  <div class="navbar-wrapper">
    <div class="navbar-header">
      <ul class="nav navbar-nav flex-row">
        <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
        <li class="nav-item"><div class="navbar-brand"><img width="200px" alt="robust admin logo" src="{{ asset('frontoffice/assets/img/logo.svg') }}"></div></li>
        <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
      </ul>
    </div>
    <div class="navbar-container content">
      <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="nav navbar-nav mr-auto float-left">
          <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu">         </i></a></li>
        </ul>
        <ul class="nav navbar-nav float-right">
          <li class="dropdown dropdown-user nav-item">
            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                <span class="avatar avatar-online">
                  <img src="{{ (Auth::user()->image) ? asset('assets/images/admin/'.Auth::user()->image) : asset('backoffice/app-assets/images/portrait/small/avatar-s-1.png') }}" alt="avatar"/><i></i>
                </span>
              <span class="user-name">{{ Auth::user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="{{ route('sysprofile.user', Auth::user()->encodeHash(Auth::user()->id)) }}"><i class="ft-user"></i> Profile</a>
              <a class="dropdown-item" href="{{ route('sysprofile.edit', Auth::user()->encodeHash(Auth::user()->id)) }}"><i class="ft-edit-2"></i> Edit Profile</a>
              <a class="dropdown-item" href="{{ route('sysprofile.change-password', Auth::user()->encodeHash(Auth::user()->id)) }}"><i class="ft-check-square"></i> Ubah Password</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('sysadmin.logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="ft-power"></i> Logout
              </a>
              <form id="logout-form" action="{{ route('sysadmin.logout') }}" method="GET" style="display: none;">
                @csrf
              </form>
			  	
            </div>
		      </li>
        </ul>
      </div>
    </div>
  </div>
</nav>