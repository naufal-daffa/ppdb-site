@extends('admin.templates.app')

@section('content')
    <div class="w-75 mx-auto my-5">
        @if (Session::get('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <form action="{{ route('admin.majors.update', $major['id']) }}" method="POST">
            @csrf
            @method('PUT')
            {{-- <div class="mb-3">
               <label for="" class="form-label">Nama Bidang Keahlian</label>
                <input type="text" class="form-control" name="skill-field-id" value="{{ $major['skillField']['nama'] }}">
                @error('nama')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div> --}}
            <div class="mb-3">
                <label for="" class="form-label">Nama Jurusan</label>
                <input type="text" class="form-control" name="nama" value="{{ $major['nama'] }}">
                @error('nama')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Deskripsi</label>
                <input type="text" name="deskripsi" class="form-control" value="{{ $major['deskripsi'] }}">
                @error('deskripsi')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Kirim data</button>
        </form>
    </div>
@endsection
