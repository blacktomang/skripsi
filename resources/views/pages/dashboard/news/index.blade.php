@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="{{asset('date-picker/date-picker.css')}}">
<style>
    .datepicker {
        position: relative;
        z-index: 10000 !important;
    }
</style>
<div class="row">
    <div class="col-lg-12 mb-3 d-flex justify-content-end">
        <button class="btn btn-primary" id="btnTambah">Tambah Berita</button>
    </div>
    <div class="col-lg-12 grid-margin stretch-card">
        @include('partials.flash-message-ajax')
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h4 class="card-title">Berita</h4>
                    <div class="col-md-4">
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
                <div class="table-responsive" id="table_data">
                    @include('pages.dashboard.news.pagination')
                </div>
            </div>
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
            <form action="{{route('news.store')}}" method="post" id="formTambah" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="POST" id="methodEdit">
                <input type="hidden" name="id" id="inputID">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Judul</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Tanggal</label>
                                <input type="text" name="date" class="form-control" id="datePick" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">Deskripsi</label>
                                <textarea name="description" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <span class="text-warning text-small mb-1 fw-bold" id="warningPhoto">Kosongkan foto jika tidak ingin mengubah foto</span>
                            <div class="form-group">
                                <input type="file" class="form-control" name="photo">
                            </div>
                        </div>

                        <div id="fieldFoto" style="display: none" class=" flex-wrap justify-content-around flex-grow-1"></div>
                    </div>
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
<script src="{{ asset('date-picker/datepicker.js') }}"></script>
<script src="{{ asset('date-picker/datepicker.en.js') }}"></script>
<script src="{{ asset('date-picker/datepicker.custom.js') }}"></script>

<script>
    // start_date
    $('#datePick').datepicker({
        language: 'en',
        dateFormat: 'yyyy-mm-dd',
        autoClose: true,
    })
    $("#btnTambah").on('click', () => {
        type = 'STORE'
        $("#modalTitle").html('Tambah Berita')
        $('#modal_tambah').modal('show')
        $("#formTambah")[0].reset()
        $("#fieldFoto").addClass('d-none');
        $("#fieldFoto").removeClass('d-flex');
        $("#warningPhoto").addClass('d-none');
        $("#warningPhoto").removeClass('d-block');
    })

    const editData = async (id) => {
        $("#formTambah")[0].reset()
        $("#inputID").val(id)
        $("#modalTitle").html('Update Berita')
        $("#description").val('')
        $("#warningPhoto").removeClass('d-none');
        $("#warningPhoto").addClass('d-block');
        type = 'UPDATE'

        await new Promise(async (resolve, reject) => {
            axios.get(`${URL_NOW}/${id}/edit`)
                .then(async ({
                    data
                }) => {
                    let {
                        photo,
                        title,
                        date,
                        description
                    } = data.data
                    $('#preview').attr('src', photo)
                    $('input[name="title"]').attr('value', title)
                    $('input[name="date"]').attr('value', date)
                    $('textarea[name="description"]').val(description)
                    $('#modal_tambah').modal('show')
                    let images = "";
                    if (photo) {
                        images = `<div class="position-relative mt-2" id="image-${photo}">
                                    <img src="${BASE_URL}@getPath(news)${photo}" alt="gambar ${title}" class="img-fluid" width="300">`
                    }
                    $('#fieldFoto').html(`${images}`)
                    $("#fieldFoto").addClass('d-flex');
                    $("#fieldFoto").removeClass('d-none')
                    $('#fieldFoto').show()
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
                axios.post(`{{ route('news.store') }}`, FormDataVar, {
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
                        showSuccessMessage(data.message.body);
                        // swal({
                        //   icon: 'success',
                        //   title: data.message.head,
                        //   text: data.message.body
                        // });
                    })
                    .catch(err => {
                        console.log(err.response);
                        $("#modal_tambah").LoadingOverlay('hide');
                        throwErr(err.response)
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