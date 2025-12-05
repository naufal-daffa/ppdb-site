@extends('applicants.app')

@section('title', 'Pilihan Jurusan Terkunci')

@section('content')
<div class="min-vh-100 d-flex align-items-center py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">

                <!-- Card Utama -->
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <!-- Header Card dengan Gradient -->
                    <div class="bg-gradient-primary text-white py-5 px-4 text-center position-relative overflow-hidden">
                        <div class="position-absolute top-0 end-0 opacity-10">
                            <i class="bi bi-shield-lock-fill" style="font-size: 18rem;"></i>
                        </div>
                        <div class="position-relative">
                            <i class="bi bi-lock-fill mb-3" style="font-size: 4.5rem;"></i>
                            <h2 class="fw-bold mb-2">Pilihan Jurusan Terkunci</h2>
                            <p class="lead mb-0 opacity-90">
                                Kamu telah menyelesaikan pemilihan jurusan
                            </p>
                        </div>
                    </div>

                    <!-- Body Card -->
                    <div class="card-body p-5 p-md-6">
                        <div class="text-center mb-5">
                            <p class="text-muted fs-5">
                                Pilihan jurusan yang kamu simpan <strong>tidak dapat diubah lagi</strong>.<br>
                                Berikut adalah pilihan final kamu:
                            </p>
                        </div>

                        <!-- Daftar Pilihan dengan Desain Lebih Mewah -->
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <div class="list-group list-group-flush">
                                    @foreach($chosenMajors as $choice)
                                        <div class="list-group-item bg-light border-0 rounded-3 mb-3 shadow-sm px-4 py-4">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="avatar avatar-lg rounded-circle bg-primary text-white fw-bold fs-4 d-flex align-items-center justify-content-center"
                                                             style="width: 60px; height: 60px;">
                                                            {{ $loop->iteration }}
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-4">
                                                        <h5 class="mb-1 fw-bold text-dark">
                                                            {{ $choice->major->nama }}
                                                        </h5>
                                                        <p class="mb-0 text-muted">
                                                            <i class="bi bi-building me-2"></i>
                                                            {{ $choice->major->skillField->nama }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="badge bg-primary fs-6 px-4 py-2 rounded-pill shadow-sm">
                                                        Prioritas {{ $choice->priority }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Footer Card -->
                        <div class="text-center mt-5 pt-4 border-top border-light">
                            <p class="text-muted small mb-3">
                                Terima kasih telah melengkapi data pendaftaran
                            </p>
                            {{-- <div class="d-flex gap-3 justify-content-center flex-wrap">
                                <a href="{{ route('applicants.dashboard') }}" class="btn btn-primary btn-lg px-5 rounded-pill shadow">
                                    <i class="bi bi-house-door me-2"></i>
                                    Kembali ke Dashboard
                                </a>
                                <a href="{{ route('applicants.documents.index') }}" class="btn btn-outline-secondary btn-lg px-5 rounded-pill">
                                    <i class="bi bi-file-earmark-check me-2"></i>
                                    Lihat Dokumen
                                </a>
                            </div> --}}
                        </div>
                    </div>
                </div>

                <!-- Footer Kecil -->
                <div class="text-center mt-4">
                    <small class="text-muted">
                        <i class="bi bi-info-circle"></i>
                        Jika ada kesalahan data, silakan hubungi panitia PPDB.
                    </small>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

{{-- Tambahkan CSS Gradient Custom (kalau belum ada di layout utama) --}}
@section('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .avatar {
        font-family: 'Segoe UI', sans-serif;
    }
    .list-group-item:hover {
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
</style>
@endsection
