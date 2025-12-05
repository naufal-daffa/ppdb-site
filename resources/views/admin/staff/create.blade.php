{{-- resources/views/admin/staff/create.blade.php --}}
@extends('admin.templates.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tambah Jadwal Wawancara</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('admin.staff.store') }}" method="POST">
                        @csrf

                        <!-- Pilih Staff -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Staff Penjadwal</label>
                            <select name="staff_id" class="form-select @error('staff_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Staff --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('staff_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('staff_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Pilih Pendaftar (Hanya yang dokumen diverifikasi/lengkap) -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Pendaftar
                                <span class="text-success small">(Hanya yang dokumen sudah diverifikasi)</span>
                            </label>
                            <select name="applicant_id" class="form-select @error('applicant_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Pendaftar --</option>
                                @foreach($applicants as $applicant)
                                    <option value="{{ $applicant->id }}" {{ old('applicant_id') == $applicant->id ? 'selected' : '' }}>
                                        {{ $applicant->nama_lengkap }}
                                        ({{ $applicant->document->status_verifikasi ?? 'tidak ada dokumen' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('applicant_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($applicants->isEmpty())
                                <small class="text-muted">Tidak ada pendaftar yang dokumennya sudah diverifikasi.</small>
                            @endif
                        </div>

                        <!-- Tanggal Wawancara -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Wawancara</label>
                            <input type="date" name="tanggal_wawancara" class="form-control @error('tanggal_wawancara') is-invalid @enderror"
                                   value="{{ old('tanggal_wawancara') }}" min="{{ now()->format('Y-m-d') }}" required>
                            @error('tanggal_wawancara')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Waktu Wawancara -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Waktu Wawancara</label>
                            <input type="time" name="waktu_wawancara" class="form-control @error('waktu_wawancara') is-invalid @enderror"
                                   value="{{ old('waktu_wawancara') }}" required>
                            @error('waktu_wawancara')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">
                                Simpan Jadwal
                            </button>
                            <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">
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
