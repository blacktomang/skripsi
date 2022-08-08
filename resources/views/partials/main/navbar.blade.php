<!-- Start Header Area -->
<header class="header navbar-area">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-12">
        <div class="nav-inner">
          <!-- Start Navbar -->
          <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="{{url('/')}}">
              <img src="{{asset('images/logo.svg')}}" alt="Logo">
            </a>
            <button class="navbar-toggler mobile-menu-btn collapsed" type="button" data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
              aria-label="Toggle navigation">
              <span class="toggler-icon"></span>
              <span class="toggler-icon"></span>
              <span class="toggler-icon"></span>
            </button>
            <div class="navbar-collapse sub-menu-bar collapse" id="navbarSupportedContent">
              <ul id="nav" class="navbar-nav align-items-center ms-auto" style="margin-right: 0!important;">
                @auth
                <div class="d-flex align-items-center">
                  <div style="margin-right:15px">
                    <a class="nav-link btn btn-circle btn-light p-0" data-bs-toggle="dropdown" id="reviewDropdown" style="border-radius:100%; height :40px; width:40px ">
                      <i class="lni lni-heart text-primary" style="font-size:20px;line-height:40px"></i>
                      <span id="notif-indicator" class="count" style="display:none;position: relative;bottom: 50px;right: -16px;width: 20px;height: 20px;border-radius: 100%;background: #F95F53;color: #ffffff;font-size: 11px;">2</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown main-nav-dropdown" aria-labelledby="reviewDropdown" style="width: 236px">
                      <a class="dropdown-item py-3">
                        <div class="row">
                          <div class="col">
                            <p class="mb-0 font-weight-medium float-left">Produk Favorit</p>

                          </div>
                          <div class="col">
                            <span onclick="markAllUserNotifAsRead()" style="color:white;" class="badge badge-pill badge-primary float-right">View all</span>

                          </div>
                        </div>
                        <div class="dropdown-divider"></div>

                      </a>

                      <div id="user-notif-container">
                      </div>

                    </div>
                  </div>
                    <div>
                      <a class="nav-link btn btn-circle btn-light p-0" href="{{url('/cart')}}"
                          style="border-radius:100%; height :40px; width:40px ">
                          <i class="lni lni-cart text-primary" style="font-size:20px;line-height:40px"></i>
                          <span id="cart-indicator" class="count" style=" 
                          display:none;
                          position: relative;
                          bottom: 50px;
                          right: -16px;
                          width: 20px;
                          height: 20px;
                          border-radius: 100%;
                          background: #F95F53;
                          color: #ffffff;
                          font-size: 11px;
                          ">2</span>
                      </a>
                  </div>
                  <div class="">
                    <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                      <img class="img-avatar rounded-circle" src="{{ asset('images/auth/avatar.svg') }}" alt=" Profile image">
                      <div class="dropdown-menu dropdown-menu-right navbar-dropdown main-nav-dropdown" aria-labelledby="UserDropdown">

                        @if (auth()->user()->role == 1 )
                        <!-- ADMIN ONLY -->
                        <a href="{{url('/dashboard')}}" class="dropdown-item"><i class="dropdown-item-icon lni lni-laptop text-secondary me-2"></i>Dashboard</a>
                        <!-- END ADMIN ONLY -->
                        @endif
                        <!-- USER ONLY -->
                        <a href="/profile" class="dropdown-item"><i class="dropdown-item-icon lni lni-user text-secondary me-2"></i>Profil
                          Saya</a>
                            <a href="/orders" class="dropdown-item"><i class="dropdown-item-icon lni lni-cart-full text-secondary me-2"></i>Pemesanan</a>
                        <!-- END USER ONLY -->
                        <a href="#" onclick="logout()" class="dropdown-item text-danger"><i class="dropdown-item-icon lni lni-power-switch text-danger me-2"></i>
                          <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                            @csrf
                          </form>
                          Logout
                        </a>
                      </div>
                    </a>
                  </div>
                </div>
                @else
                <li class="nav-item ">
                  <!-- <div class="login-button">
                    <ul> -->
                      {{-- <li> --}}
                        <a href="{{url('login')}}" style="padding:0;"><i class="lni lni-enter"></i> Login</a>
                      {{-- </li> --}}
                    <!-- </ul>
                  </div> -->
                 </li> 
                <li class="nav-item button header-button">
                  {{-- <div class="button header-button"> --}}
                    <a href="{{url('register')}}" class="btn">Register</a>
                  {{-- </div> --}}
                </li>
                @endauth
              </ul>
            </div>

          </nav>
          <!-- End Navbar -->
        </div>
      </div>
    </div> <!-- row -->
  </div> <!-- container -->
</header>
<!-- End Header Area -->