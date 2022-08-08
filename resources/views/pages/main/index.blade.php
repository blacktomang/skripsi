@extends('layouts.main')
@section('title', 'Beranda')
@section('content')
<section class="hero-area">
  <div class="hero-slider">
    @php
    $promo = [];
    $testimonial = [];
    @endphp
    @forelse ($promo as $item)
    <a class="single-hero"
      style="background-image: url('{{ asset('uploads/images/' . $item->foto) ?? asset('images/promo/default-promo.svg')}}');"></a>
    @empty
    <a class="single-hero" style="background-image: url('{{ asset('images/promo/default-promo.svg')}}');"></a>
    @endforelse
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
            <img src="{{ asset('uploads/images/' . ($item->photos[0]->value)) }}" alt="#">
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
        <a href="" class="mt-5 btn btn-outline-primary">Lihat Semua Produk</a>
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
    <div class="tns-outer" id="tns2-ow">
      <div class="tns-nav" aria-label="Carousel Pagination"><button type="button" data-nav="0" aria-controls="tns2"
          style="" aria-label="Carousel Page 1 (Current Slide)" class="tns-nav-active"></button><button type="button"
          data-nav="1" tabindex="-1" aria-controls="tns2" style="" aria-label="Carousel Page 2"></button><button
          type="button" data-nav="2" tabindex="-1" aria-controls="tns2" style="display:none"
          aria-label="Carousel Page 3"></button></div>
      <div class="tns-liveregion tns-visually-hidden" aria-live="polite" aria-atomic="true">slide <span
          class="current">5 to 6</span> of 3</div>
      <div id="tns2-mw" class="tns-ovh">
        <div class="tns-inner" id="tns2-iw">
          <div class="row testimonial-slider  tns-slider tns-carousel tns-subpixel tns-calc tns-horizontal" id="tns2"
            style="transition-duration: 0s; transform: translate3d(-36.3636%, 0px, 0px);">
            @forelse ($testimonial as $item)
            <div class="col-lg-4 col-md-6 col-12 tns-item tns-slide-cloned" aria-hidden="true" tabindex="-1">
              <div class="single-testimonial">
                <div class="quote-icon">
                  <i class="lni lni-quotation"></i>
                </div>
                <div class="author">
                  <img src="{{asset('images/auth/avatar.svg')}}" alt="Foto">
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
            @empty
            <div class="col-lg-4 col-md-6 col-12 tns-item tns-slide-cloned" aria-hidden="true" tabindex="-1">
              <div class="single-testimonial">
                <div class="quote-icon">
                  <i class="lni lni-quotation"></i>
                </div>
                <div class="author">
                  <img src="{{asset('images/auth/avatar.svg')}}" alt="Foto">
                  <h4 class="name">
                    Contoh Kata Mereka
                    {{-- <span class="deg">{{$item->jabatan}}</span> --}}
                  </h4>
                </div>
                <div class="text">
                  <p>"Pendapat mereka Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque, porro!"</p>
                </div>
              </div>
            </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
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