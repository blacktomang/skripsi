@extends('layouts.main')
@section('title','Berita')
@section('content')
<style>
  @media only screen and (min-width: 768px) and (max-width: 991px) {
    .breadcrumbs {
      padding-top: 140px;
      padding-bottom: 30px;
    }

    .single-module .btn {
      width: 100%;
    }
  }

  @media (max-width: 767px) {
    .breadcrumbs {
      padding-top: 140px;
      padding-bottom: 30px;
    }

    .single-module .btn {
      width: 100%;
    }
  }

  .breadcrumbs .breadcrumbs-content {
    position: relative;
    text-align: left;
  }

  .breadcrumbs .breadcrumbs-content .page-title {
    font-size: 32px;
    color: #fff;
    font-weight: 600;
    position: relative;
    line-height: 1.5;
    text-transform: capitalize;
  }

  .breadcrumbs .breadcrumbs-content p {
    margin-top: 16px;
    color: #fff;
    line-height: 1.8 !important;
  }

  .breadcrumbs .breadcrumbs-content form .input-group {
    margin-top: 32px;
    height: 48px;
    border-radius: 50px !important;
    text-indent: 12px;
    background-color: #fff;
  }


  .breadcrumbs .breadcrumbs-content form input {
    height: 48px;
    border-radius: 50px !important;
    text-indent: 12px;
    border: none;
  }

  .breadcrumbs .breadcrumbs-content form button {
    height: 40px;
    width: 40px;
    margin: 4px;
    border-radius: 50px;
    background-color: #FF0035;
    border: none;
    color: #fff;
    font-weight: 600px;
    font-size: 16px;
  }

  @media only screen and (min-width: 768px) and (max-width: 991px) {
    .breadcrumbs .breadcrumbs-content .page-title {
      font-size: 32px;
      line-height: 28px;
    }
  }

  @media (max-width: 767px) {
    .breadcrumbs .breadcrumbs-content .page-title {
      font-size: 32px;
      line-height: 26px;
    }
  }

  .breadcrumbs .breadcrumbs-content .breadcrumb-nav {
    background: transparent;
    border-radius: 0;
    margin-bottom: 0;
    padding: 0;
    display: inline-block;
  }

  .breadcrumbs .breadcrumb-nav {
    text-align: right;
  }

  @media (max-width: 767px) {
    .breadcrumbs .breadcrumb-nav {
      text-align: center;
      margin-top: 15px;
    }
  }

  .breadcrumbs .breadcrumb-nav li {
    display: inline-block;
    position: relative;
    padding-right: 14px;
    margin-right: 14px;
    text-transform: capitalize;
    color: #fff;
  }

  .breadcrumbs .breadcrumb-nav li:after {
    content: "\ea62";
    font-family: lineIcons;
    font-size: 11px;
    position: absolute;
    top: 3px;
    right: -7px;
  }

  .breadcrumbs .breadcrumb-nav li:last-child {
    margin: 0;
    padding: 0;
  }

  .breadcrumbs .breadcrumb-nav li:last-child::after {
    display: none;
  }

  .breadcrumbs .breadcrumb-nav li,
  .breadcrumbs .breadcrumb-nav li a {
    color: #fff;
    font-size: 14px;
    font-weight: 500;
  }

  .breadcrumbs .breadcrumb-nav li i,
  .breadcrumbs .breadcrumb-nav li a i {
    font-size: 13px;
    display: inline-block;
    margin-right: 3px;
    position: relative;
    top: -1px;
  }

  .breadcrumbs .breadcrumb-nav li a {
    position: relative;
  }

  .breadcrumbs .breadcrumb-nav li a:hover {
    color: #e4e4e4;
  }

  .single-article {
    margin-bottom: 24px;
  }

  .single-article p {
    font-size: 16px;
    line-height: 32px;
    color: #727272 !important;
  }

  .single-article p span {
    font-size: 16px;
    line-height: 32px;
    color: #727272 !important;
  }

  .section {
    padding-top: 110px;
    padding-bottom: 110px;
    position: relative;
  }
</style>
<div class="breadcrumbs">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 col-md-6 col-12">
        <div class="breadcrumbs-content">
          <h1 class="page-title">Berita Terkini</h1>
          <p>Berita tentang D'Lima</p>
          <form action="">
            <div class="input-group mb-3">
              <input type="text" name="keyword" value="{{request()->keyword}}" class="form-control" placeholder="Temukan artikel terbaru"
                aria-label="Temukan berita terbaru">
              <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit"><i class="lni lni-search"></i></button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<section class="section bg-light">
  <div class="container">
    <div class="row justify-content-center" id="content-wrapper">
      @include('pages.main.news.pagination')
    </div>
    <div class="row justify-content-center">
        @if($news->hasMorePages())
        <button class="btn btn-primary col-4" type="button" id="loadMore" data-next="{{$news->nextPageUrl()}}">Tampilkan
          Lebih banyak</button>
        @endif
    </div>
  </div>
</section>
@endsection

@section('js')
<script>
  $("#loadMore").on("click", function(){
      axios.get($(this).data('next'))
      .then(({data})=>{
        $("#content-wrapper").append(data.render)
        if(data.next){
          $(this).data('next', data.next)
        }else{
          $(this).remove();
        }
      })
      .catch((err)=>{
        console.log(err);
      })
    })
</script>
@endsection