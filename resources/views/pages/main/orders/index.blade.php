@extends('layouts.main')
@section('title', 'Pemesanan')
@section('content')
<div class="breadcrumbs">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-12">
        <div class="breadcrumbs-content">
          <h1 class="page-title">Pemesanan Kamu</h1>
        </div>
      </div>
    </div>
  </div>
</div>
<section class="section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-2">
                <div class="cart-list-head">
                    <div class="cart-list-title overflow-auto">                        
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>Kode</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>Total</p>
                            </div>
                            <div class="col-lg-3 col-md-3 col-12">
                                <p>Status</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>Tanggal</p>
                            </div>
                            <div class="col-lg-1 col-md-2 col-12">
                                <p>Aksi </p>
                            </div>
                        </div>
                    </div>
                    @include('partials.flash-message-ajax')
                    @foreach ($orders as $item)
                    <div class="cart-single-list" id="div{{ $item->id }}">
                        <div class="row align-items-center">
                            <div class="col-lg-2 col-md-2 col-12">
                                <h5 class="product-name"><a href="{{url('orders/'.\Base64::encode($item->id))}}">{{$item->code}}</a>
                                </h5>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p id="subtotal{{$item->id}}" class="subtotal">Rp {{number_format($item->total)}}
                                </p>
                            </div>
                            <div class="col-lg-3 col-md-3 col-12">
                              <small
                                class="badge @if($item->status==0)badge-warning @elseif($item->status==1 || $item->status==2)badge-success  @else badge-danger @endif">
                                @if($item->status==0)Menunggu Pembayaran @elseif($item->status==1)Diproses @elseif($item->status==2)Selesai @else Ditolak @endif
                              </small>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                              <p>@dateFormat($item->created_at)</p>
                            </div>
                            <div class="col-lg-1 col-md-2 col-12">
                              <a href="{{url('orders/'.\Base64::encode($item->id))}}" class="btn btn-primary">Detail</a>
                                {{-- <a class="remove-item" onclick="deleteCart('{{ $item->id }}')"><i
                                        class="lni lni-close"></i></a> --}}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection