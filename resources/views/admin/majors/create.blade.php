@extends('admin.templates.app')

@section('content')
    <div class="w-75 mx-auto my-5">
        @if (Session::get('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <form action="{{ route('admin.majors.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <select name="skill-field-id" id="type" rows="5" class="form-select
                    @error('type')
                        is-invalid
                    @enderror
                " value="{{ old('skill-field-id') }}">
                    <option value="">Pilih Bidang Keahlian</option>
                    @foreach ($skillFields as $skillField)
                        <option value="{{ $skillField['id'] }}">{{ $skillField['nama'] }}</option>
                    @endforeach
                </select>
                @error('skill-field-id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Nama Jurusan</label>
                <input type="text" class="form-control" name="nama" value="{{ old('nama') }}">
                @error('nama')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Deskripsi</label>
                <input type="text" name="deskripsi" class="form-control" value="{{ old('deskripsi') }}">
                @error('deskripsi')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Kirim data</button>
        </form>
    </div>
@endsection
