@extends('layouts.main')
@section('title' , 'Detail Pemesanan')
@section('content')
<div class="breadcrumbs">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-12">
        <div class="breadcrumbs-content d-flex justify-content-between align-items-center">
          <h1 class="page-title">Detail Pemesanan</h1>
          <a href="{{url('/orders')}}" style="color: white;">
            <span class="lni lni-arrow-left fw-bold fs-3">
            </span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<section class="section bg-light">
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="col-md-10">
        <div class="card">
          <div class="card-body">
            <div class="text-center">
              <div class="alert alert-success">
                Pemesanan telah kami terima<br> Klik di <a target="_blank" href="https://wa.me/62895352530708?text=Saya%20ingin%20menkonfirmasi%20order%20dengan%20kode%20{{$detail->code}}" class="">sini</a>
                untuk konfirmasi pemesanan</span>
              </div>
              <div class="mt-2">Kode Transaksi</div>
              <h4 class="text-primary mt-2">{{$detail->code}}</h4>
              <hr>
              <div>
                <small 
                class="badge @if($detail->status==0)badge-warning @elseif($detail->status==1)badge-success @else badge-danger @endif"
                >
                @if($detail->status==0)Menunggu Pembayaran @elseif($detail->status==1)Diproses @else Ditolak @endif
              </small>
              </div>
            </div>
            <hr>
            <div class="accordion" id="accordionExample">
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Detail
                  </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                  data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <table class="table table-responsive">
                      <thead>
                        <tr>
                          <th>
                            Nama Produk
                          </th>
                          <th>
                            Jumlah
                          </th>
                          <th>
                            Total
                          </th>
                        </tr>
                        @php
                            $totalAmount =0;
                        @endphp
                        @forelse ($detail->details as $item)
                        @php
                            $totalAmount += $item->amount;
                        @endphp
                            <tr>
                              <td>{{$item->product->name}}</td>
                              <td>{{$item->amount}}</td>
                              <td>Rp. {{number_format($item->price)}}</td>
                            </tr>
                        @empty
                            <tr>
                              <td colspan="3">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                        <tr>
                          <th>Total</th>
                          <th>{{$totalAmount}}</th>
                          <th>Rp. {{number_format($detail->total)}}</th>
                        </tr>
                      </thead>
                    </table>
                  
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection