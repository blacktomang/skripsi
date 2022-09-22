@extends('layouts.main')
@section('title' , $news->title??null)
@section('desc' ,$news->description??null)
@php
    $photo = asset('/storage/uploads/news/'.$news->photo);
@endphp
@section('image' , $photo)
@section('css')
<style>
  .navbar-area {
    background-color: #fff !important;
  }

  .card {
    padding: 0
  }

  .card-img-top {
    height: 450px;
    object-fit: cover;
    object-position: center;
  }
</style>
@endsection
@section('content')
<section class="section pages bg-light mt-50">
  <div class="container">
    <div class="row">
      <div class="card">
        <img src="{{ asset('@getPath(news)'.$news->photo) }}" class="card-img-top" alt="Image">
        <div class="card-body">
          <h5>{{$news->title}}</h5>
          <span>{{ \Carbon\Carbon::parse($news->date)->isoFormat('dddd, D MMMM Y') }} - Admin</span>
          <p> {!!$news->description!!}</p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection