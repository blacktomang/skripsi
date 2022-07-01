<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="{{url('dashboard')}}">
        <i class="menu-icon mdi mdi-laptop"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-toggle="collapse" href="#product" aria-expanded="false" aria-controls="product">
        <i class="menu-icon mdi mdi-briefcase"></i>
        <span class="menu-title">Produk</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="product">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{url('dashboard/product')}}">Produk</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{url('dashboard/stock')}}">Stock</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{url('dashboard/category')}}">Kategori</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{route('variant.index')}}">Variant</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{route('size.index')}}">Size</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-toggle="collapse" href="#sale" aria-expanded="false" aria-controls="sale">
        <i class="menu-icon mdi mdi-cart"></i>
        <span class="menu-title">Penjualan</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="sale">
        <ul class="nav flex-column sub-menu">
          <!-- badge berfungsi seperti notifikasi -->
          <li class="nav-item"> <a class="nav-link" href="{{route('order.index')}}">Tampilkan Semua</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{route('order.index')}}?status_order=DIKEMAS">Dikemas <span id="DIKEMAS" class="badge badge-danger" style="color: white">10</span></a></li>
          <li class="nav-item"> <a class="nav-link" href="{{route('order.index')}}?status_order=DIKIRIM">Dikirim <span id="DIKIRIM" class="badge badge-primary" style="color: white">2</span></a></li>
          <li class="nav-item"> <a class="nav-link" href="{{route('order.index')}}?status_order=SELESAI">Selesai <span id="SELESAI" class="badge badge-success" style="color: white">10</span></a></li>
          <li class="nav-item"> <a class="nav-link" href="{{route('order.index')}}?status_order=BELUM_DIBAYAR">Belum Dibayar</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{route('order.index')}}?status_order=DIBATALKAN">Dibatalkan</a></li>
        </ul>
      </div>
    </li>
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
          <li class="nav-item"> <a class="nav-link" href="{{ route('user') }}">Tampilkan Semua</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{ route('user') }}?role=superAdmin">Superadmin</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{ route('user') }}?role=admin">Admin</a></li>
          <!-- End Role -->
          <li class="nav-item"> <a class="nav-link" href="{{ route('user') }}?role=customer">Pelanggan</a></li>
        </ul>
      </div>
    </li>
    <!-- Role Superadmin -->
    <li class="nav-item">
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
      <a class="nav-link" href="{{route('admin-profile',auth()->user()->id)}}">
        <i class="menu-icon mdi mdi-account"></i>
        <span class="menu-title">Profil</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('company-profile') }}">
        <i class="menu-icon mdi mdi-card-bulleted"></i>
        <span class="menu-title">Company Profil</span>
      </a>
    </li>
    <!-- End Role -->
  </ul>
</nav>