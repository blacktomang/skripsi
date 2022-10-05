@extends('layouts.dashboard')

@section('content')
<div class="section-body">
  <div class="card overflow-hidden">
    @include('partials.flash-message-ajax')
    <div class="card-header row align-items-center justify-content-between">
      <div class="dropdown col-lg-3 col-md-6 col-12">
        <button class="btn btn-info btn-sm " type="button" id="filter"
          data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Filter
          <i class="fas fa-angle-down ms-1" style="font-size: 10px"></i>
        </button>
          <div class="dropdown-menu" aria-labelledby="" id="dropdownOrderStatus">
            <button class="dropdown-item"
                onclick="filter('1')">Diproses</button>
            <button class="dropdown-item"
                onclick="filter('2')">Selesai</button>
            {{-- <div class="dropdown-divider"></div> --}}
            <button class="dropdown-item text-danger"
                onclick="filter('3')">Dibatalkan</button>
            <button class="dropdown-item "
            onclick="filter('all')">All</button>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-12">
        <form action="" method="get" class="row">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="keyword" placeholder="Kata Kunci" value="{{ request()->keyword ?? '' }}">
            <div class="input-group-append">
              <button class="btn btn-primary ml-2"><i class="fas fa-search"></i>Cari</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="card-body table-responsive" id="table_data">
      @include('pages.dashboard.orders.pagination')
    </div>
  </div>
</div>
@endsection
@section('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="modalSale">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
              <div>
                <h5 class="modal-title">Detail Order</h5>
                <h6>kode: <span class="text-info" id="code"></span></h6>
              </div>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="mb-2">
                        <h5 id="username"></h5>
                        <p id="phone"></p>
                    </div>
                    <div id="detail">

                    </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary mr-3" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="" class="btn btn-primary">Cetak Resi</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
  $(".btn-success-images").click(function() {
    if (countimageinput >= 4) {
      swal({
        icon: 'warning',
        title: "Foto",
        text: "Hanya bisa upload maksimal 5 foto"
      });
      return;
    }
    var lsthmtl = $(".clone").children().clone().addClass('cloned');
    $(".increment").after(lsthmtl);
    countimageinput += 1;
    console.log(countimageinput);
  });

  $("body").on("click", ".btn-danger-images", function() {
    $(this).parents(".hdtuto").remove();
    countimageinput -= 1;
    console.log(countimageinput)
  });

  $("#btnTambah").on('click', (e) => {
    e.preventDefault();
    type = 'STORE';
    countimageinput = 0;
    $("#modalTitle").html('Tambah Produk')
    $("#formTambah")[0].reset()
    $("#inputDescription").text('')
    $("#fieldFoto").hide()
    $("#fieldFoto").removeClass('d-flex');
    $("#teksImage").hide()
    $('#modal_tambah').modal('show')
  });

  const updateOrderStatus = async (id, status) => {

    let url = "{{route('order-status.update', ':id')}}";
    url = url.replace(':id', id);

    await axios.patch(url, {
      status: status
    }).then((d) => {
      showSuccessMessage(`Produk berhasil ${status?'diaktifkan':'dinonaktifkan'}`);
      refresh_table(URL_NOW);
    }).catch((e) => {
      throwErr(e);
    })
  }

  const filter = async (status) => {
    status === 'all' ? 
      refresh_table(URL_NOW)
      :
      await new Promise(async ()=>{
        $("#table_data").LoadingOverlay('show');
        await axios.get(`${URL_NOW}?status=${status}`)
          .then((r)=>$("#table_data").html(r.data))
          .catch(err=>showErrorMessage('Opps'))
          .finally(()=>$("#table_data").LoadingOverlay('hide'))
      })
  }

  const editData = async id => {
    let a = $(".btn-danger-images");
    if (a) {
      for (let index = 0; index < a.length; index++) {
        const element =
          a[index];
        if (element.parentElement.closest('.cloned')) {
          element.parentElement.closest('.cloned').remove();
        }
      }
    }
    await new Promise(async (resolve, reject) => {
      axios.get(`${URL_NOW}/${id}/edit`)
        .then(async ({
          data
        }) => {
          let product = data.data
          type = 'UPDATE'
          $("#formTambah")[0].reset();
          $("#inputDescription").text(product.description);
          $("#inputID").val(product.id);
          $("#modalTitle").html('Update Produk');
          let images = "";
          countimageinput = product.photos.length;
          product.photos.map((item, i) => {
            images += `<div class="position-relative mt-2" id="image-${item.id}">
                        <img src="${BASE_URL}/uploads/images/${item.value}" alt="gambar ${product.name}-${i}" class="img-fluid" width="300"><button class="btn btn-sm btn-danger hapus position-absolute" style="top:0;right:0" onclick="deleteImage(${item.id})" type="button"><i class="fas fa-trash-alt"></i></button></div>`
          });
          $('#fieldFoto').html(`${images}`)
          $("#fieldFoto").addClass('d-flex');
          $('#fieldFoto').show()
          $("#teksImage").show()
          $("input[name='name']").val(product.name)
          $("input[name='price']").val(`Rp. ${jsPriceFormat(product.price)}`)
          $("#inputWight").val(product.weight)
          $("#inputDescription").text(product.description)
          $(".inputImage").prop('required', false)
          $('#modal_tambah').modal('show');
        })
        .catch(err => {
          console.log('edit data', err)
          swal({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
          })
        })
    })
  };

  const deleteData = id => {
    swal({
        title: 'Yakin?',
        text: "Ingin menghapus data ini!",
        buttons: true,
        dangerMode: true,
      })
      .then((result) => {
        if (result) {
          new Promise((resolve, reject) => {
            axios.delete(`${URL_NOW}/${id}`)
              .then(({
                data
              }) => {
                swal({
                  icon: 'success',
                  title: data.message.head,
                  text: data.message.body
                })
                refresh_table(URL_NOW)
              })
              .catch(err => {
                let data = err.response.data
                console.error(err);
                swal({
                  icon: 'error',
                  title: data.message.head,
                  text: data.message.body
                })
              })
          })
        }
      })
  };

  const productModalTemplate = (product_name, foto, price, amount) => {
    let template = `
    <div class="col-md-12 single-product">
        <div class="row">
            <div class="col-auto">
                    <img src="${BASE_URL}@getPath(products)${foto}" alt="">
            </div>
            <div class="col-auto pt-2">
                <h5>${product_name}</h5>
                <h6>Harga : Rp ${jsPriceFormat(price)}</h6>
                <h6>Jumlah : ${amount}</h6>
                <h6>Total : Rp ${jsPriceFormat(amount * price)}</h6>
            </div>
        </div>
    </div>`;
    template = template.replace(':foto', foto);
    return template;
  }
  const viewData =async (id) =>{
    await new Promise(async (resolve, reject) => {
      axios.get(`${URL_NOW}/${id}`)
        .then(async ({
          data
        }) => {
          const {code, user_name, phone, details} = data.data; 
          $("#username").text(user_name)
          $("#phone").text(phone)
          $("#code").text(code)
          let htmlDetail = '';
          details.forEach((detail)=>{
            const {product_name, foto, price, amount} = detail;
            htmlDetail+=productModalTemplate(product_name, foto, price, amount)
          });
          $("#detail").html(htmlDetail);
          $('#modalSale').modal('show');
        })
        .catch(err => {
          console.log('edit data', err)
          swal({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
          })
        })
    })
  };

  const updateStatus = (status)=>{

  };
</script>
@endsection