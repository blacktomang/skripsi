<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
    <div class="me-3">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
        <span class="icon-menu"></span>
      </button>
    </div>
    <div>
      <a class="navbar-brand brand-logo" href="{{url('/')}}">
        <img src="{{asset('images/logo.svg')}}" alt="logo" />
      </a>
      <a class="navbar-brand brand-logo-mini" href="{{url('/')}}">
        <img src="{{asset('images/logo.svg')}}" alt="logo" />
      </a>
    </div>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-top">
    <ul class="navbar-nav ms-auto">
      <li class="nav-item dropdown">
        <a class="nav-link count-indicator" id="countDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="icon-bell"></i>
          <span id="notif-indicator" style="display: none;" class="count"></span>
        </a>
        {{-- disini notification nya --}}
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="countDropdown">
          <a class="dropdown-item py-3">
            <p class="mb-0 font-weight-medium float-left">Notifications</p>
            <span onclick="markAllAsRead()" style="color:white;" class="badge badge-pill badge-primary float-right">View all</span>
          </a>
          <div class="dropdown-divider"></div>


          <div id="notifikasi-container">
            {{-- <a href="javascript:void(0)" class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <img src="{{asset('images/icon/cart')}}" alt="icon" class="img-sm profile-pic">
          </div>
          <div class="preview-item-content flex-grow py-2">
            <p class="preview-subject ellipsis font-weight-medium text-dark">Produk XXXXXXX </p>
            <p class="fw-light small-text mb-0">Sisa 10 stok</p>
          </div>
          </a> --}}

          {{-- <a href="" class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <img src="{{asset('images/icon/cart')}}" alt="icon" class="img-sm profile-pic">
        </div>
        <div class="preview-item-content flex-grow py-2">
          <p class="preview-subject ellipsis font-weight-medium text-dark">John Doe Upgrade Akun Dari User Ke Admin</p>
        </div>
        </a> --}}
  </div>

  </div>
  </li>
  <li class="nav-item dropdown user-dropdown">
    <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
      <img class="img-xs rounded-circle" src="{{ asset('images/auth/avatar.svg') }}" alt="Profile image"> </a>
    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
      <div class="dropdown-header text-center">
        <img class="img-md rounded-circle img-profile" src="{{ asset('images/auth/avatar.svg') }}" alt="Profile image">
        <p class="mb-1 mt-3 font-weight-semibold">{{ auth()->user()->name }}</p>
      </div>
      <a href="{{url('/')}}" class="dropdown-item"><i class="dropdown-item-icon mdi mdi-home text-primary me-2"></i>Beranda</a>
      <a href="{{route('admin-profile',auth()->user()->id)}}" class="dropdown-item"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i>Profil Saya</a>
      <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>
        <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
          @csrf
        </form>
        Logout
      </a>
    </div>
  </li>
  </ul>
  <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
    <span class="mdi mdi-menu"></span>
  </button>
  </div>
</nav>