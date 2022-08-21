@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h4 class="card-title">Web Settings</h4>
                </div>
                <form action="{{ route('web-settings.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @include('partials.flash-message')
                    <div class="form-row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="hero-file">Hero File</label>
                                <input type="file" name="hero_file" value="{{$data->hero_file??''}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="hero-desc">Hero Title</label>
                                <input type="text" name="hero_title" class="form-control" value="{{ $data->hero_title??''}}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="hero-desc">Hero Description</label>
                                <textarea required class="form-control" name="hero_desc"
                                    rows="3">{{ $data->hero_desc??''}}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="about">About</label>
                                <textarea required class="form-control" name="about"
                                    rows="3">{{ $data->about??''}}</textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Ubah Settings</button>
                </form>
            </div>
        </div>
    </div>
    @endsection