@extends('applicants.app')

@section('content')
    <div class="container my-5">

        {{-- Notifikasi Sukses (Menggunakan style Bootstrap 5) --}}
        @if (Session::get('success'))
            <div class="alert alert-success d-flex align-items-center mb-4 rounded-3 shadow-sm" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div>
                    {{ Session::get('success') }}
                </div>
            </div>
            {{-- Tambahkan SVG icons di file utama/layout jika belum ada --}}
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </symbol>
            </svg>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-4xl font-extrabold text-gray-900">
                Data Pendaftar
            </h1>
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary d-flex align-items-center">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-body p-4 p-lg-5">

                <div class="pb-4 border-bottom mb-4">
                    <h2 class="display-6 fw-bold text-primary mb-1">
                        {{ $applicant->nama_lengkap }}
                    </h2>
                    <div class="d-flex align-items-center mt-2 space-x-4">
                        <p class="text-secondary fs-5 mb-0">NISN: <span class="fw-bold text-dark">{{ $applicant->nisn }}</span></p>
                        <span class="badge text-uppercase fw-bold p-2
                            @if ($applicant->status_pendaftaran == 'diterima')
                                bg-success text-white border border-success
                            @elseif ($applicant->status_pendaftaran == 'menunggu')
                                bg-warning text-dark border border-warning
                            @elseif ($applicant->status_pendaftaran == 'ditolak')
                                bg-danger text-white border border-danger
                            @endif">
                            {{ $applicant->status_pendaftaran ?? 'Belum Ada Status' }}
                        </span>
                    </div>
                </div>

                {{-- Bagian Detail: Menggunakan Bootstrap Grid (row/col) --}}
                <div class="row g-4 mt-3">

                    {{-- Kolom Kiri: Data Pribadi --}}
                    <div class="col-md-6">
                        <div class="card h-100 border-primary border-opacity-25 bg-light-subtle">
                            <div class="card-body p-4">
                                <h3 class="fs-4 fw-bold text-dark mb-4 border-bottom border-primary border-opacity-50 pb-2">
                                    <i class="fas fa-user-circle me-2 text-primary"></i> Informasi Pribadi
                                </h3>

                                <dl class="row mb-0">
                                    <div class="col-sm-5 text-secondary fw-medium mb-3">Tanggal Lahir</div>
                                    <div class="col-sm-7 text-dark fw-semibold text-end">{{ \Carbon\Carbon::parse($applicant->tanggal_lahir)->format('d F Y') }}</div>

                                    <div class="col-sm-5 text-secondary fw-medium mb-3">Jenis Kelamin</div>
                                    <div class="col-sm-7 text-dark fw-semibold text-end">{{ $applicant->jenis_kelamin }}</div>

                                    <div class="col-sm-5 text-secondary fw-medium mb-3">Nomor Telepon</div>
                                    <div class="col-sm-7 text-dark fw-semibold text-end">{{ $applicant->nomor_telepon }}</div>

                                    <div class="col-sm-5 text-secondary fw-medium pt-2">Alamat</div>
                                    <div class="col-sm-7 text-dark text-end pt-2 text-wrap">{{ $applicant->alamat }}</div>
                                </dl>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Data Pendidikan & Wali --}}
                    <div class="col-md-6">
                        <div class="card h-100 border-success border-opacity-25 bg-light-subtle">
                            <div class="card-body p-4">
                                <h3 class="fs-4 fw-bold text-dark mb-4 border-bottom border-success border-opacity-50 pb-2">
                                    <i class="fas fa-graduation-cap me-2 text-success"></i> Sekolah & Keluarga
                                </h3>
                                <dl class="row mb-0">
                                    <div class="col-sm-5 text-secondary fw-medium mb-3">Asal Sekolah</div>
                                    <div class="col-sm-7 text-dark fw-bolder text-end">{{ $applicant->asal_sekolah }}</div>

                                    <div class="col-sm-5 text-secondary fw-medium mb-3">Pekerjaan Ayah</div>
                                    <div class="col-sm-7 text-dark fw-semibold text-end">{{ $applicant->pekerjaan_ayah }}</div>

                                    <div class="col-sm-5 text-secondary fw-medium mb-3">Pekerjaan Ibu</div>
                                    <div class="col-sm-7 text-dark fw-semibold text-end">{{ $applicant->pekerjaan_ibu }}</div>

                                    <div class="col-sm-5 text-secondary fw-medium mb-3">No. Telepon Wali</div>
                                    <div class="col-sm-7 text-dark fw-semibold text-end">{{ $applicant->nomor_telepon_wali }}</div>

                                    @if ($applicant->majorChoices->count())
                                        <div class="col-12 border-top border-secondary border-opacity-25 pt-4 mt-3">
                                            <dt class="text-secondary fw-bold mb-2 d-flex align-items-center">
                                                <i class="fas fa-clipboard-list me-2 text-primary"></i> Pilihan Jurusan
                                            </dt>
                                            <dd class="text-dark">
                                                <ol class="list-group list-group-flush">
                                                    {{-- {{ dd($applicant->majorChoices) }} --}}
                                                    @foreach ($applicant->majorChoices as $choice)
                                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                                                            {{ $choice->nama }}
                                                            <span class="badge bg-secondary rounded-pill">Prioritas {{ $choice->pivot->priority }}</span>
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            </dd>
                                        </div>
                                    @endif
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- <div class="mt-5 pt-4 border-top d-flex justify-content-end space-x-3">
                    <button onclick="alert('Implementasi Verifikasi')" class="btn btn-success btn-lg shadow-sm">
                        <i class="fas fa-check-circle me-2"></i> Verifikasi Data
                    </button>
                    <button onclick="alert('Implementasi Edit')" class="btn btn-primary btn-lg shadow-sm">
                        <i class="fas fa-edit me-2"></i> Edit Data
                    </button>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
