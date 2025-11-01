@extends('staff.templates.app')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-warning w-100 d-flex justify-content-end">{{ Session::get('success') }}</b>
        </div>
    @endif

@endsection
