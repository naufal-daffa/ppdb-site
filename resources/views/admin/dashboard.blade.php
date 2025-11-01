@extends('admin.templates.app')
@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success w-100 d-flex justify-content-end">{{ Session::get('success') }} <b> Selamat Datang,
                {{ Auth::user()->nama }}</b>
        </div>
    @endif
    @if (Session::get('failed'))
        <div class="alert alert-warning w-100 d-flex justify-content-end">{{ Session::get('failed') }}</b>
        </div>
    @endif
    <h5>
        tes
    </h5>
@endsection
