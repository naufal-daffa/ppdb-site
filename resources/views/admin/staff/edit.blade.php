@extends('admin.templates.app')

@section('content')
    <div class="w-75 d-block mx-auto mt-3 p-4">
        @if (Session::get('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif

        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif

        <h5 class="text-center mb-3">Edit Data Jadwal Staff Dan Pendaftar</h5>

        <form action="{{ route('admin.staff.update', $staff->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="staff_id" class="form-label">Pilih nama staff</label>
                <select name="staff_id" id="staff_id" class="form-select @error('staff_id') is-invalid @enderror">
                    <option value="">Pilih Staff</option>
                    @foreach ($users as $user)
                        @if ($user->role == 'staff')
                            <option value="{{ $user->id }}" {{ old('staff_id', $staff->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->nama }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('staff_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="applicant_id" class="form-label">Pilih Pendaftar</label>
                <select name="applicant_id" id="applicant_id" class="form-select @error('applicant_id') is-invalid @enderror">
                    <option value="">Pilih Pendaftar</option>
                    @foreach ($applicants as $applicant)
                        @if ($applicant->status_pendaftaran !== 'ditolak' && $applicant->deleted_at === null)
                            <option value="{{ $applicant->id }}" {{ old('applicant_id', $staff->applicant_id) == $applicant->id ? 'selected' : '' }}>
                                {{ $applicant->nama_lengkap }} - {{ $applicant->nisn }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('applicant_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tanggal_wawancara" class="form-label">Tanggal Wawancara</label>
                <input type="date" name="tanggal_wawancara" id="tanggal_wawancara"
                    class="form-control @error('tanggal_wawancara') is-invalid @enderror"
                    value="{{ old('tanggal_wawancara', $staff->tanggal_wawancara ? \Carbon\Carbon::parse($staff->tanggal_wawancara)->format('Y-m-d') : '') }}">
                @error('tanggal_wawancara')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="waktu_wawancara" class="form-label">Waktu Wawancara</label>
                <input type="time" name="waktu_wawancara" id="waktu_wawancara"
                    class="form-control @error('waktu_wawancara') is-invalid @enderror"
                    value="{{ old('waktu_wawancara', $staff->waktu_wawancara) }}">
                @error('waktu_wawancara')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status_kehadiran" class="form-label">Status Kehadiran</label>
                <select name="status_kehadiran" id="status_kehadiran" class="form-select @error('status_kehadiran') is-invalid @enderror">
                    <option value="">Pilih Status</option>
                    <option value="hadir" {{ old('status_kehadiran', $staff->status_kehadiran) == 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="tidak hadir" {{ old('status_kehadiran', $staff->status_kehadiran) == 'tidak hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                </select>
                @error('status_kehadiran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Biarkan kosong jika belum diketahui</small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update Data</button>
                <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
@endsection

@push('styles')
<style>
    .w-75 {
        max-width: 800px;
    }
    .form-control:focus, .form-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>
@endpush
