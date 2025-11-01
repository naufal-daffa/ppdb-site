@extends('admin.templates.app')

@section('content')
    <div class="w-75 d-block mx-auto mt-3 p-4">
        @if (Session::get('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <h5 class="text-center mb-3">Tambah Data Pengguna</h5>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama Pengguna</label>
                <input type="text" name="nama" id="" class="form-control @error('nama')
                    is-invalid
                @enderror" value="{{ old('nama') }}">
                @error('nama')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Email</label>
                <input name="email" id="email" rows="5" class="form-control @error('email')
                    is-invalid
                @enderror" value="{{ old('email') }}">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Password</label>
                <input name="password" id="password" type="password" class="form-control @error('password')
                    is-invalid
                @enderror" value="{{ old('password') }}">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Kirim Data</button>
        </form>
    </div>
@endsection
