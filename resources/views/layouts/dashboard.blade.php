<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta name="csrf-token" id="head-csrf" content="{{ csrf_token() }}" />
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>@yield('title', 'Jamu')</title>
  <!-- plugins:css -->
  <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('fontawesome-5.7.2/css/all.min.css') }}">
  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{asset('css/animate.css')}}" />
  <link rel="stylesheet" href="{{asset('css/mdi/css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/feather/feather.css')}}" />
  <!-- inject:css -->
  <link type="text/css" rel="stylesheet" href="{{asset('select2/css/select2.min.css') }}">
  </link>
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('images/logo.svg')}}" />
  <style>
    .select2 {
      width: 100% !important;
    }

    /* .mdi::before {
      font-size: 24px;
      line-height: 14px;
    } */

    .btn .mdi::before {
      position: relative;
      top: 4px;
    }

    .btn-xs .mdi::before {
      font-size: 18px;
      top: 3px;
    }

    .btn-sm .mdi::before {
      font-size: 18px;
      top: 3px;
    }

    .dropdown-menu .mdi {
      width: 18px;
    }

    .dropdown-menu .mdi::before {
      position: relative;
      top: 4px;
      left: -8px;
    }

    /* .nav .mdi::before {
      position: relative;
      top: 4px;
    } */

    .navbar .navbar-toggle .mdi::before {
      position: relative;
      top: 4px;
      color: #FFF;
    }

    .breadcrumb .mdi::before {
      position: relative;
      top: 4px;
    }

    .breadcrumb a:hover {
      text-decoration: none;
    }

    .breadcrumb a:hover span {
      text-decoration: underline;
    }

    .alert .mdi::before {
      position: relative;
      top: 4px;
      margin-right: 2px;
    }

    .input-group-addon .mdi::before {
      position: relative;
      top: 3px;
    }

    .navbar-brand .mdi::before {
      position: relative;
      top: 2px;
      margin-right: 2px;
    }

    .list-group-item .mdi::before {
      position: relative;
      top: 3px;
      left: -3px
    }
  </style>
  @yield('css')
</head>

<body>
  <div class="container-scroller">
    @include('partials.dashboard.head')

    <div class="container-fluid page-body-wrapper">
      @include('partials.dashboard.sidebar')

      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>
      </div>
    </div>
  </div>

  @yield('modal')
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="{{asset('js/bootstrap.min.js')}}"></script>
  <script src="{{asset('js/app.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="{{asset('js/wow.min.js')}}"></script>
  <script src="{{asset('js/tiny-slider.js')}}"></script>
  <script src="{{asset('js/glightbox.min.js')}}"></script>
  <script src="{{asset('js/main.js')}}"></script>

  <script src="{{asset('js/off-canvas.js')}}"></script>
  <script src="{{asset('js/hoverable-collapse.js')}}"></script>
  <script src="{{asset('js/template.js')}}"></script>

  <script src="{{asset('js/dashboard.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js" integrity="sha256-jLFv9iIrIbqKULHpqp/jmePDqi989pKXOcOht3zgRcw=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- <script src="{{asset('js/Chart.roundedBarCharts.js')}}"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    const BASE_URL = `{{ url('/') }}`
    const URL_NOW = `{{ request()->url() }}`
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content")

    // Set up csrf token
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': CSRF_TOKEN
      }
    });

    $(window).ready(() => {
      axios(URL_NOW);
    })

    const refresh_table = url => {
      new Promise((resolve, reject) => {
        $("#table_data").LoadingOverlay('show')
        axios.get(url)
          .then(({
            data
          }) => {
            $("#table_data").LoadingOverlay('hide')
            $('#table_data').html(data)
          })
          .catch(err => {
            console.log(err)
            $("#table_data").LoadingOverlay('hide')
            swal({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!',
            })
          })
      })
    }

    const loading = (type, selector = null, options = null) => {
      if (selector) {
        $(selector).LoadingOverlay(type, options)
      } else {
        $.LoadingOverlay(type, options)
      }
    }

    const throwErr = err => {
      if (err.response.status == 422) {
        let message = err.response.data.errors
        let teks_error = ''
        $.each(message, (i, e) => {
          if (e.length > 1) {
            $.each(e, (id, el) => {
              teks_error += `<p>${el}</p>`
            })
          } else {
            teks_error += `<p>${e}</>`
          }
        })
        swal({
          icon: 'error',
          title: 'Oops...',
          html: teks_error,
        })
      } else {
        let message = err.response.data.message
        swal({
          icon: 'error',
          title: message.head,
          text: message.body,
        })
      }
    };
  </script>

  <script>
    const jsPriceFormat = (param) => {
      n = 3;
      string = String(param);
      var ret = [];
      let hiah = 1;
      for (let i = string.length - 1; i >= 0; i--) {
        if (i != 0 && hiah % 3 == 0) {
          ret.push(`.${string[i]}`)
        } else {
          ret.push(`${string[i]}`)
        }
        hiah++;
      }
      return ret.reverse().join("");
    };

    $(".inputPrice").on('input', function() {
      let numberPrice = Number($(this).val().replace(/[^0-9]/g, ''));
      $(this).val(`Rp ${jsPriceFormat(numberPrice)}`);
    });
    /**
     * Refresh Table Client Side. 
     * * @param {   string } url 
     * * @param {   string } table 
     * */
    async function refreshTable(url, table) {
      $.ajax({
        url: url,
        dataType: 'html',
        success: (data) => {
          $(table).html(data);
        },
        error: (err) => {
          throwErr(err, err)
        }
      })
    };
  </script>

  @yield('js')
</body>

</html>