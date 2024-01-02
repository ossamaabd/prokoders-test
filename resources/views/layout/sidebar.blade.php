<nav class="sidebar sidebar-offcanvas dynamic-active-class-disabled" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile not-navigation-link">
      <div class="nav-link">
        <div class="user-wrapper">
          <div class="profile-image">
            <img src="{{ url('assets/images/faces/face8.jpg') }}" alt="profile image">
          </div>
          <div class="text-wrapper">
            <p class="profile-name">Ossama Abd Rabouh</p>
            <div class="dropdown" data-display="static">
              <a href="#" class="nav-link d-flex user-switch-dropdown-toggler" id="UsersettingsDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <small class="designation text-muted">prokoders test</small>
                <span class="status-indicator online"></span>
              </a>
              <div class="dropdown-menu" aria-labelledby="UsersettingsDropdown">
                <a class="dropdown-item p-0">
                  <div class="d-flex border-bottom">
                    <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                      <i class="mdi mdi-bookmark-plus-outline mr-0 text-gray"></i>
                    </div>
                    <div class="py-3 px-4 d-flex align-items-center justify-content-center border-left border-right">
                      <i class="mdi mdi-account-outline mr-0 text-gray"></i>
                    </div>
                    <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                      <i class="mdi mdi-alarm-check mr-0 text-gray"></i>
                    </div>
                  </div>
                </a>
               
                <form method="POST" action="{{route('logout')}}"  id="logout-form" style="margin: 0px">@csrf
                    <a class="dropdown-item"  onclick="document.getElementById('logout-form').submit();"> Sign Out </a>
                </form>              </div>
            </div>
          </div>
        </div>
        <button class="btn btn-success btn-block">New Project <i class="mdi mdi-plus"></i>
        </button>
      </div>
    </li>
    <li class="nav-item {{ active_class(['/']) }}">
      <a class="nav-link" href="{{ url('/') }}">
        <i class="menu-icon mdi mdi-television"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>


    {{-- users --}}


    @if (auth('user')->user())

    <li class="nav-item {{ active_class(['popups/index']) }}">
        <a class="nav-link" href="{{ url('/popups/index') }}">
            <i class="menu-icon mdi mdi-table-large"></i>
            <span class="menu-title">popups</span>
        </a>
    </li>
    @endif



    <li class="nav-item {{ active_class(['reports/index']) }}">
        <a class="nav-link" href="{{ url('/reports/index') }}">
            <i class="menu-icon mdi mdi-table-large"></i>
            <span class="menu-title">Reports</span>
        </a>
    </li>


    <li class="nav-item">
      {{-- <a class="nav-link" href="https://www.bootstrapdash.com/demo/star-laravel-free/documentation/documentation.html" target="_blank">
        <i class="menu-icon mdi mdi-file-outline"></i>
        <span class="menu-title">Documentation</span>
      </a> --}}
    </li>
  </ul>
</nav>
