@extends('admin.template.app')

@section('content')
    <div class="w-75 d-block mx-auto mt-3 p-4">
        @if (Session::get('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <h5 class="text-center mb-3">Tambah Data Bidang Keahlian</h5>
        <form action="{{ route('admin.skill-fields.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama Bidang Keahlian</label>
                <input type="text" name="nama" id="" class="form-control @error('nama')
                    is-invalid
                @enderror" value="{{ old('nama') }}">
                @error('nama')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="5" class="form-control @error('deskripsi')
                    is-invalid
                @enderror">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Kirim Data</button>
        </form>
    </div>
@endsection
