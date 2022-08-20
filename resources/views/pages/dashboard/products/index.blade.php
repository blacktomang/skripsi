@extends('layouts.dashboard')

@section('content')
<div class="section-body">
  <div class="card overflow-hidden">
    @include('partials.flash-message-ajax')
    <div class="card-header d-flex align-items-center justify-content-between">
      <button class="btn btn-success col-lg-3 col-md-6 col-12" id="btnTambah"><i class="fas fa-plus"></i> Tambah Product</button>
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
      @include('pages.dashboard.products.pagination')
    </div>
  </div>
</div>
@endsection
@section('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="modal_tambah">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post" id="formTambah" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="inputID">
        <div class="modal-body">
          <div class="form-group">
            <label for="inputName">Nama</label>
            <input type="text" name="name" id="inputName" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="inputPrice">Harga</label>
            <input type="text" name="price" id="inputPrice" class="form-control inputPrice" data-a-sign="Rp. " data-a-dec="," data-a-sep="." required>
          </div>
          <div class="form-group">
            <label for="inputDescription">Deskripsi</label>
            <textarea name="description" id="inputDescription" cols="30" rows="5" class="form-control"></textarea>
          </div>
          {{-- <p class="text-danger text-center" id="teksImage" style="display: none">Jangan upload gambar jika
            tidak ingin mengubahnya</p> --}}
          <div class="input-group control-group lst increment">
            <input type="file" name="image[]" id="inputImage" class="myfrm form-control inputImage">
            <div class="input-group-btn">
              <button class="btn btn-success btn-success-images" type="button"><i class="fldemo glyphicon glyphicon-plus"></i>Add</button>
            </div>
          </div>
          <div class="clone hide" hidden>
            <div class="hdtuto control-group lst input-group" style="margin-top:10px">
              <input type="file" name="image[]" class="myfrm form-control inputImage">
              <div class="input-group-btn">
                <button class="btn btn-danger btn-danger-images" type="button"><i class="fldemo glyphicon glyphicon-remove"></i> Remove</button>
              </div>
            </div>
          </div>
          <div id="fieldFoto" style="display: none" class="d-flex flex-wrap justify-content-around flex-grow-1"></div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
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

  const setStatusProduct = async (id, status) => {

    let url = "{{route('product-status.update', ':id')}}";
    url = url.replace(':id', id);

    await axios.patch(url, {
      status: status
    }).then((d) => {
      console.info(d);
      showSuccessMessage(`Produk berhasil ${status?'diaktifkan':'dinonaktifkan'}`);
      refresh_table(URL_NOW);
    }).catch((e) => {
      console.error(e);
      throwErr(e);
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
                        <img src="${BASE_URL}@getPath(products)${item.value}" alt="gambar ${product.name}-${i}" class="img-fluid" width="300"><button class="btn btn-sm btn-danger hapus position-absolute" style="top:0;right:0" onclick="deleteImage(${item.id})" type="button"><i class="fas fa-trash-alt"></i></button></div>`
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
  }

  function deleteImage(id) {
    swal({
        title: 'Yakin?',
        text: "Anda akan menghapus foto ini?",
        buttons: true,
        dangerMode: true,
      })
      .then((result) => {
        if (result) {
          new Promise((resolve, reject) => {
            let url = `{{ route('product-image.delete',['id' => ':id']) }}`;
            url = url.replace(':id', id);
            axios.delete(url)
              .then(({
                data
              }) => {
                $(`#image-${id}`).remove();
                toastr.success(data.message.head, data.message.body)
                refresh_table(URL_NOW);
              }).catch((err) => {
                throwErr(err);
              })
          });
        } else {
          return;
        }
      })
  }

  $("#formTambah").on('submit', async (e) => {
    e.preventDefault();
    let FormDataVar = new FormData($("#formTambah")[0]);
    let image = $(".inputImage");
    let tempName = "";
    $("#modal_tambah").LoadingOverlay('show');
    if (type == "STORE") {
      for (var pair of FormDataVar.entries()) {
        console.log(pair[0] + ', ' + pair[1]);
      }
      await new Promise((resolve, reject) => {
        axios.post(`{{ route('products.store') }}`, FormDataVar, {
            headers: {
              'Content-type': 'multipart/form-data'
            }
          })
          .then(({
            data
          }) => {
            $("#modal_tambah").LoadingOverlay('hide');
            $('#modal_tambah').modal('hide')
            refresh_table(URL_NOW)
            console.info(data);
            showSuccessMessage(data.message.body);
            // swal({
            //   icon: 'success',
            //   title: data.message.head,
            //   text: data.message.body
            // });
          })
          .catch(err => {
            console.error(err);
            $("#modal_tambah").LoadingOverlay('hide');
            throwErr(err)
          })
      })
    } else if (type == "UPDATE") {
      let id_product = $("#inputID").val()
      FormDataVar.append('_method', 'PUT')
      await new Promise((resolve, reject) => {
        axios.post(`${URL_NOW}/${id_product}`, FormDataVar, {
            headers: {
              'Content-type': 'multipart/form-data'
            }
          })
          .then(({
            data
          }) => {
            $("#modal_tambah").LoadingOverlay('hide');
            $('#modal_tambah').modal('hide')
            showSuccessMessage(data.message.body);
            refresh_table(URL_NOW)
            // data.message.body
          })
          .catch(err => {
            $("#modal_tambah").LoadingOverlay('hide');
            throwErr(err)
          })
      })
    }
    $("#modal_tambah").LoadingOverlay('hide');
  });
</script>
@endsection