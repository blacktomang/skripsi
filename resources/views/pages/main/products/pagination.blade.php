<div class="row">
  <div class="col-12">
    <div class="section-title">
      <h2 class="wow fadeInUp" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">Produk Kami</h2>
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
          <a href="{{ route('product-detail', $item->slug) }}">{{ $item->name }}</a>
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
    @if(count($products)==0)
    <p class="badge badge-warning">Produk belum tersedia</p>
    @endif
  </div>
</div>