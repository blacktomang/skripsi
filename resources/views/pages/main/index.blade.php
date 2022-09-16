@extends('layouts.main')
@section('title', 'Beranda')
@section('content')
<section class="hero-area">
  <div class="row">
        <div class="col-md-8 hero-media p-0">
            <!-- IF IMAGE -->
            <!-- <img src="{{asset('panel/images/promo/default-promo.svg')}}"> -->
            <!-- IF VIDEO -->
                @if (isset($websettings->hero_file))
                  <a class="single-hero" style="background-image: url('{{ asset('@getPath(websettings)'.$websettings->hero_file) }}');"></a>
                @else
                  <a class="single-hero" style="background-image: url('{{ asset('images/promo/default-promo.svg')}}');"></a>
                @endif
        </div>
        <div class="col-md-4 bg-dark hero-right">
            <div class="hero-desc">
                @if (isset($websettings->hero_title))
                <h2 class="h2">{{ $websettings->hero_title }}</h2>
                @else
                <h2 class="h2">Hello</h2>
                @endif
                @if (isset($websettings->hero_desc))
                <p>{{ $websettings->hero_desc }}</p>
                @else
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Recusandae nihil libero deleniti laudantium
                    saepe dolor vero doloremque natus, eaque consequatur.</p>
                @endif
                <a href="{{url('/product')}}">Shop Now</a>
            </div>
        </div>
    </div>
</section>
<section class="section about-section" id="about">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="section-title">
                <h2 class="wow fadeInUp" data-wow-delay=".4s"
                    style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">About Us</h2>
            </div>
            <div class="col-lg-8 text-center">
                @if (isset($websettings->about))
                    <p>{{ $websettings->about }}</p>
                @else
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque sunt ipsum perspiciatis voluptatum.
                    Doloribus enim, molestiae illum quos inventore voluptatem.</p>
                @endif
            </div>
        </div>
    </div>
</section>
<section class="section">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="section-title">
          <h2 class="wow fadeInUp" data-wow-delay=".4s"
            style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">Produk Kami</h2>
        </div>
      </div>
      @foreach ($products as $item)
      <div class="col-lg-4" onclick="window.location.href = '{{ route('product-detail', $item->slug) }}'">
        <div style="cursor: pointer;" onclick="" class="single-item-grid">
          <div class="image">
            @if (!$item->photos->isEmpty())
            <img src="{{ asset('@getPath(products)'.$item->photos[0]->value) }}" alt="#">
            @else
            <img src="{{ asset('images/product/default-product.svg') }}" alt="#">
            @endif
            <i class="cross-badge lni lni-star-filled"></i>
            @if ($item->diskon > 0)
            <span class="flat-badge discount">-{{ $item->diskon }}%</span>
            @endif
            <div class="button">
              <a class="btn"><i class="lni lni-eye"></i> Detail</a>
            </div>
          </div>
          <div class="content">
            <h3 class="title">
              <a 
              href="{{ route('product-detail', $item->slug) }}"
              >{{ $item->name }}</a>
            </h3>
            <ul class="info">
              @php
              $originalPrice = $item->price;
              $diskon = $originalPrice * $item->diskon/100;
              $newPrice = $originalPrice - $diskon;
              @endphp
              <li class="price">Rp {{number_format($newPrice)}}
                @if ($item->diskon > 0)
                <br><span class="old-price"> Rp {{number_format($originalPrice)}}</span>
                @endif
              </li>
            </ul>
          </div>
        </div>
      </div>
      @endforeach
      <div class="col-12 text-center">
        @if(count($products)>3)
        <a href="/product" class="mt-5 btn btn-outline-primary">Lihat Semua Produk</a>
        @endif
        @if(count($products)==0)
          <p class="badge badge-warning">Produk belum tersedia</p>
        @endif
      </div>
    </div>
  </div>
</section>
<section class="testimonials section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title align-center gray-bg">
                    <h2 class="wow fadeInUp" data-wow-delay=".4s"
                        style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">What People Say
                    </h2>
                </div>
            </div>
        </div>
        <div class="row testimonial-slider ">
            @foreach ($testimonials as $item)
            <div class="col-lg-4 col-md-6 col-12 tns-item tns-slide-cloned" aria-hidden="true" tabindex="-1">
                <div class="single-testimonial">
                    <div class="quote-icon">
                        <i class="lni lni-quotation"></i>
                    </div>
                    <div class="author">
                        @if (!$item->foto)
                        <img src="{{asset('panel/images/auth/avatar.svg')}}" alt="Foto">
                        @else
                        <img src="{{ asset('@getPath(testimonials)'.$item->foto) }}" alt="Foto">
                        @endif
                        <h4 class="name">
                            {{$item->name}}
                            <span class="deg">{{$item->jabatan}}</span>
                        </h4>
                    </div>
                    <div class="text">
                        <p>"{{$item->deskripsi}}"</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@include('partials.flash-message-ajax')
@endsection

@section('js')
<script>
  // Set up csrf token
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  })
  const redirectPage = (stock, link) => {
    if (stock > 0) {
      window.location.href = link;
    } else {
      swal({
        title: 'Stok habis!',
        text: 'Silahkan pilih item lain.',
        icon: 'error'
      });
    }
  }

  tns({
    container: '.hero-slider',
    items: 1,
    slideBy: 'page',
    autoplay: false,
    mouseDrag: true,
    gutter: 0,
    nav: false,
    controls: true,
    controlsText: ['<i class="lni lni-chevron-left"></i>', '<i class="lni lni-chevron-right"></i>'],
  });

  tns({
    container: '.testimonial-slider',
    items: 3,
    slideBy: 'page',
    autoplay: false,
    mouseDrag: true,
    gutter: 0,
    nav: true,
    controls: false,
    controlsText: ['<i class="lni lni-arrow-left"></i>', '<i class="lni lni-arrow-right"></i>'],
    responsive: {
      0: {
        items: 1,
      },
      540: {
        items: 1,
      },
      768: {
        items: 2,
      },
      992: {
        items: 3,
      },
      1170: {
        items: 3,
      }
    }
  });
</script>
@endsection