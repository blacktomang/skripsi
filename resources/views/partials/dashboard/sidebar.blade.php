<nav class="sidebar sidebar-fixed sidebar-offcanvas" id="sidebar">
  @if (Auth::user()->role == 1)
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="{{url('dashboard')}}">
        <i class="menu-icon mdi mdi-laptop"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{route('products.index')}}">
        <i class="menu-icon mdi mdi mdi-star"></i>
        <span class="menu-title">Produk</span>
      </a>
    </li>
    {{-- <li class="nav-item">
      <a class="nav-link collapsed" data-bs-toggle="collapse" href="#sale" aria-expanded="false" aria-controls="sale">
        <i class="menu-icon mdi mdi-cart"></i>
        <span class="menu-title">Penjualan</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="sale">
        <ul class="nav flex-column sub-menu">
          <!-- badge berfungsi seperti notifikasi -->
          <li class="nav-item"> <a class="nav-link" href=""></a></li>
          <li class="nav-item"> <a class="nav-link" href="" EMAS">Dikemas <span id="DIKEMAS" class="badge badge-danger"
                style="color: white">10</span></a></li>
          <li class="nav-item"> <a class="nav-link" href="">Dikirim <span id="DIKIRIM" class="badge badge-primary"
                style="color: white">2</span></a></li>
          <li class="nav-item"> <a class="nav-link" href="">Selesai <span id="SELESAI" class="badge badge-success"
                style="color: white">10</span></a></li>
          <li class="nav-item"> <a class="nav-link" href="">Belum Dibayar</a></li>
          <li class="nav-item"> <a class="nav-link" href="" ATALKAN">Dibatalkan</a></li>
        </ul>
      </div>
    </li> --}}
    <li class="nav-item nav-category">Pengaturan</li>
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-toggle="collapse" href="#user" aria-expanded="false" aria-controls="user">
        <i class="menu-icon mdi mdi-account"></i>
        <span class="menu-title">User</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="user">
        <ul class="nav flex-column sub-menu">
          <!-- Role Superadmin -->
          <li class="nav-item"> <a class="nav-link" href="{{route('admin.index')}}">Admin</a></li>
          <!-- End Role -->
          <li class="nav-item"> <a class="nav-link" href="{{route('client.index')}}">Pengunjung / Klien</a></li>
        </ul>
      </div>
    </li>
    <!-- Role Superadmin -->
    {{-- <li class="nav-item">
      <a class="nav-link" href="{{url('dashboard/testimonial')}}">
        <i class="menu-icon mdi mdi mdi-star"></i>
        <span class="menu-title">Testimonial</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('dashboard/promo')}}">
        <i class="menu-icon mdi mdi-tag"></i>
        <span class="menu-title">Promo</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('dashboard/courier')}}">
        <i class="menu-icon mdi mdi-truck"></i>
        <span class="menu-title">Kurir</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="">
        <i class="menu-icon mdi mdi-account"></i>
        <span class="menu-title">Profil</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="">
        <i class="menu-icon mdi mdi-card-bulleted"></i>
        <span class="menu-title">Company Profil</span>
      </a>
    </li> --}}
    <!-- End Role -->
  </ul>
  @else
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="">
        <i class="menu-icon mdi mdi-account"></i>
        <span class="menu-title">Profil</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="">
        <i class="menu-icon mdi mdi-cart"></i>
        <span class="menu-title">Keranjang</span>
      </a>
    </li>
  </ul>
  @endif
</nav>