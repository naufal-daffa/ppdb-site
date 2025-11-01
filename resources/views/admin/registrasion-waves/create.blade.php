@extends('admin.templates.app')

@section('content')
    <div class="w-75 d-block mx-auto mt-3 p-4">
        @if (Session::get('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <h5 class="text-center mb-3">Tambah Data Gelombang Pendaftaran</h5>
        <form action="{{ route('admin.registrasion-waves.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama Gelombang</label>
                <input type="text" name="nama_gelombang" id="" class="form-control @error('nama_gelombang')
                    is-invalid
                @enderror" value="{{ old('nama_gelombang') }}">
                @error('nama_gelombang')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" id="" class="form-control @error('tanggal_mulai')
                    is-invalid
                @enderror" value="{{ old('tanggal_mulai') }}">
                @error('tanggal_mulai')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" id="" class="form-control @error('tanggal_selesai')
                    is-invalid
                @enderror" value="{{ old('tanggal_selesai') }}">
                @error('tanggal_selesai')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Kirim Data</button>
        </form>
    </div>
@endsection
