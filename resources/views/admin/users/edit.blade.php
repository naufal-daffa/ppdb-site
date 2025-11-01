@extends('admin.template.app')

@section('content')
    <div class="w-75 d-block mx-auto mt-3 p-4">
        @if (Session::get('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        @if (Session::get('failed'))
            <div class="alert alert-danger">{{ Session::get('failed') }}</div>
        @endif
        <h5 class="text-center mb-3">Edit Data Keahlian</h5>
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Nama Bidang Keahlian</label>
                <input type="text" name="nama" id="name" class="form-control @error('name')
                    is-invalid
                @enderror" value="{{ $user->nama }}">
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="5" class="form-control @error('deskripsi')
                    is-invalid
                @enderror">{{ $user->deskripsi }}</textarea>
                @error('deskripsi')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Kirim Data</button>
            {{-- <button type="button" class="btn btn-danger"><a href="" class="">Batal</a></button> --}}
            <a href="{{ route('admin.skill-fields.index') }}" class="btn btn-danger">Batal</a>
        </form>
    </div>
@endsection
