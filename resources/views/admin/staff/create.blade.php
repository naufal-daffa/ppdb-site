@extends('admin.templates.app')

@section('content')
    <div class="w-75 d-block mx-auto mt-3 p-4">
        @if (Session::get('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <h5 class="text-center mb-3">Tambah Data Jadwal Staff Dan Pendaftar</h5>
        <form action="{{ route('admin.staff.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Pilih nama staff</label>
                <select name="staff_id" id="" class="form-select">
                    <option value="">Staff</option>
                    @foreach ($users as $user)
                        @if ($user['role'] == 'staff')
                            <option value="{{ $user['id'] }}">{{ $user['nama'] }}</option>
                        @endif
                    @endforeach
                </select>
                @error('nama')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <select name="applicant_id" class="form-select"> <!-- nama field jadi applicant_id -->
                <option value="">Pendaftar</option>
                @foreach ($applicants as $applicant)
                    @if ($applicant->status_pendaftaran !== 'ditolak' && $applicant->deleted_at === null)
                        <option value="{{ $applicant->id }}">{{ $applicant->nama_lengkap }}</option>
                    @endif
                @endforeach
            </select>
            @error('applicant_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            @error('applicant_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <label for="name" class="form-label">Tanggal wawancara</label>
            <input type="date" name="tanggal_wawancara" id=""
                class="form-control @error('tanggal_wawancara')
                    is-invalid
                @enderror"
                value="{{ old('tanggal_wawancara') }}">
            @error('tanggal_wawancara')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <div class="mb-3">
                <label for="name" class="form-label">Waktu wawancara</label>
                <input type="time" name="waktu_wawancara" id=""
                    class="form-control @error('waktu_wawancara')
                            is-invalid
                        @enderror"
                    value="{{ old('waktu_wawancara') }}">
                @error('waktu_wawancara')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Kirim Data</button>
        </form>
    </div>
    </div>
@endsection
