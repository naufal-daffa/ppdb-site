@extends('admin.templates.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">{{ isset($admissionPath) ? 'Edit' : 'Tambah' }} Jalur Pendaftaran</h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($admissionPath) ? route('admin.admission-paths.update', $admissionPath->id) : route('admin.admission-paths.store') }}" method="POST">
                        @csrf
                        @if(isset($admissionPath))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="prestasi" class="form-label">Nama Jalur Pendaftaran *</label>
                            <input type="text" class="form-control @error('prestasi') is-invalid @enderror"
                                   id="prestasi" name="prestasi"
                                   value="{{ old('prestasi', $admissionPath->prestasi ?? '') }}"
                                   placeholder="Contoh: Akademik, Non-Akademik, Prestasi">
                            @error('prestasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                {{ isset($admissionPath) ? 'Update' : 'Simpan' }}
                            </button>
                            <a href="{{ route('admin.admission-paths.index') }}" class="btn btn-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
