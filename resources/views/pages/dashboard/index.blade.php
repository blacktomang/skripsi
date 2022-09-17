@extends('layouts.dashboard')
@section('content')
<link rel="stylesheet" href="{{asset('date-picker/date-picker.css')}}">
<style>
  .link-wrapper {
    text-decoration: none;
    color: black;

  }

  .link-wrapper:hover {
    text-decoration: none;
    color: white;
  }

  .costume-card {
    color: black !important;
    opacity: 0.8;
    transition: 0.3s;
  }

  .costume-card:hover {
    opacity: 1;
    color: white !important;
    background-color: #0b6351 !important;
  }

  .card-title-costume {
    /* color: #010101; */
    margin-bottom: 1.2rem;
    text-transform: capitalize;
    font-size: 1.125rem;
    font-weight: 600;
  }
</style>

<h3>Selamat Datang, {{auth()->user()->name}}</h3>
<div class="row mt-4">
  <div class="col-12 mb-4">
    <div class="card">
      <div class="card-body">
        <form method="get">
          <div class="row mb-4">
            <div class="col-md-5 mb-8">
              <input id="start_date" name="start_date" value="{{request()->get('start_date')??''}}"
                class="date2 form-control" placeholder="Tanggal mulai">
            </div>
            <div class="col-md-5 mb-8">
              <input id="end_date" name="end_date" value="{{request()->get('end_date')??''}}" class="date2 form-control"
                placeholder="Tanggal akhir">
            </div>
            <div class="col-md-2">
              <button class="btn btn-primary" type="submit">Filter</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-12 mb-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="d-flex align-items-end mb-3">
          <h4 class="me-8">Ringkasan order
            {{
            request()->start_date && request()->end_date ?
            'dari '. request()->start_date .' sampai '.
            request()->end_date:'hari ini'
            }}
          </h4>
        </div>
        <div class="row">
          <div class="col-lg-3 grid-margin stretch-card">
            <div class="card bg-secondary costume-card">
              <a href="/dashboard/order" class="link-wrapper">
                <div class="card-body">
                  <h4 class="card-title-costume">Belum Bayar</h4>
                  <h6 id='DASH_BELUM_DIBAYAR' class="">{{$order_unpayed}}</h6>
                </div>
              </a>
            </div>
          </div>
          <div class="col-lg-3 grid-margin stretch-card">
            <div class="card bg-warning costume-card">
              <a href="/dashboard/order" class="link-wrapper">
                <div class="card-body">
                  <h4 class="card-title-costume ">Diproses</h4>
                  <h6 id='DASH_DIKEMAS' class="">{{$order_process}}</h6>
                </div>

              </a>
            </div>
          </div>
          <div class="col-lg-3 grid-margin stretch-card">
            <div class="card bg-info costume-card">
              <a href="/dashboard/order" class="link-wrapper">
                <div class="card-body">
                  <h4 class="card-title-costume">Selesai</h4>
                  <h6 id='DASH_DIKIRIM' class="">{{$order_finish}}</h6>
                </div>

              </a>
            </div>
          </div>
          <div class="col-lg-3 grid-margin stretch-card">
            <div class="card bg-success costume-card">
              <a href="/dashboard/order" class="link-wrapper">
                <div class="card-body">
                  <h4 class="card-title-costume">Dibatalkan</h4>
                  <h6 id='DASH_SELESAI' class="">{{$order_canceled}}</h6>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-sm-12 mb-4">
    <div class="row">
      <div class="col-12 mb-24">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex align-items-end mb-24">
              <h4 class="me-8">Order Perbulan</h4>
            </div>
            <div id="grafik-perbulan"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-sm-12 mb-4">
    <div class="row">
      <div class="col-12 mb-24">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex align-items-end mb-24">
              <h4 class="me-8">Order Berdasarkan Status</h4>
            </div>
            <div id="order-by-status"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('js')
<script src="{{ asset('date-picker/datepicker.js') }}"></script>
<script src="{{ asset('date-picker/datepicker.en.js') }}"></script>
<script src="{{ asset('date-picker/datepicker.custom.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
  // start_date
$('#start_date').datepicker({
    language: 'en',
    dateFormat: 'dd-mm-yyyy',
    autoClose: true,
})
// end_date
$('#end_date').datepicker({
    language: 'en',
    dateFormat: 'dd-mm-yyyy',
    autoClose: true,
    maxDate:new Date()
})

  function bulanIndo(bulan) {
    let bulanData = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des' ]
    return bulanData[bulan - 1]
  }

  const dataGrafikPerbulan = {!! json_encode($grafikOrder)??[] !!}
  let optionGrafikPerbulan = {
    series: [{
      name: "Jumlah penjualan",
      data: dataGrafikPerbulan.map(({value})=> value),
    }, ],
    chart: {
      fontFamily: "Manrope, sans-serif",
      type: "area",
      height: 350,
      toolbar: {
        show: false,
      },
      zoom: {
        enabled: false,
      },
    },
    labels: {
      style: {
        fontSize: "14px",
      },
    },

    dataLabels: {
      enabled: false,
    },

    grid: {
      borderColor: "#DFE6E9",
      row: {
        opacity: 0.5,
      },
    },
    fill: {
      opacity: 1,
      type: "solid",
    },
    stroke: {
      show: true,
      width: 4,
      curve: "straight",
      colors: ["transparent"],
    },
    xaxis: {
      axisTicks: {
        show: false,
        borderType: "solid",
        color: "#78909C",
        height: 6,
        offsetX: 0,
        offsetY: 0,
      },

      labels: {
        style: {
          colors: ["636E72"],
          fontSize: "14px",
        },
      },
      categories: dataGrafikPerbulan.map(({label})=> bulanIndo(label)),
    },
    legend: {
      horizontalAlign: "right",
      offsetX: 40,
      position: "top",
      markers: {
        radius: 12,
      },
    },
    colors: ["#02a5a1"],

    yaxis: {
      labels: {
        style: {
          colors: ["636E72"],
          fontSize: "14px",
        },
      },

      min: 0,
      tickAmount: 4,
    },
  };

  if (document.querySelector("#grafik-perbulan")) {
    let chart = new ApexCharts(
      document.querySelector("#grafik-perbulan"),
      optionGrafikPerbulan
    );
    chart.render();
  }

  grafikOrderByStatus = {!! json_encode($grafikOrderByStatus) ?? [] !!}
  function renderLabel(status) {
    switch (status) {
      case 0:
        return 'Belum di bayar'    
      case 1:
        return 'Dalam proses'
      case 2:
        return 'Selesai'     
      default:
        return 'dibatalkan'
    }
  }
  settingGrafikOrderByStatus = {
      series: grafikOrderByStatus.map((v)=>v.value),
      chart: {
          fontFamily: "Manrope, sans-serif",
          type: "donut",
          height: 398,
          toolbar: {
              show: false,
          },
          zoom: {
              enabled: false,
          },
      },
      colors: ["#02a5a1", "#009490", "#1cb8b3"],

      labels: grafikOrderByStatus.map(({status})=> renderLabel(status)),

      dataLabels: {
          enabled: false,
      },
      plotOptions: {
          pie: {
              donut: {
                  size: "85%",
                  labels: {
                      show: true,
                      name: {
                          fontSize: "2rem",
                      },
                      value: {
                          fontSize: "16px",
                          formatter(val) {
                              return `${val}`;
                          },
                      },
                      total: {
                          show: true,
                          fontSize: "16px",
                          label: "Total",
                          formatter: function (w) {
                              return `${w.globals.seriesTotals.reduce(
                                  (a, b) => {
                                      return a + b;
                                  },
                                  0
                              )}`;
                          },
                      },
                  },
              },
          },
      },

      legend: {
          itemMargin: {
              horizontal: 24,
              vertical: 0,
          },
          horizontalAlign: "center",
          position: "bottom",
          fontSize: "14px",

          markers: {
              radius: 12,
          },
      },
  };

  if (document.querySelector("#order-by-status")) {
    let chart = new ApexCharts(
        document.querySelector("#order-by-status"),
        settingGrafikOrderByStatus 
    );
    chart.render();
}

</script>
@endsection