@extends('staff.templates.app')
@push('style')
    <style>
        .avatar-circle {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border: 2px solid #e9ecef;
        }

        .avatar-initials {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
        }

        .hover-shadow:hover {
            transform: translateY(-5px);
            transition: transform 0.2s ease;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .card {
            transition: all 0.3s ease;
        }

        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Pagination Style */
        .pagination-wrapper {
            margin-top: 2rem;
        }

        .pagination .page-link {
            border-radius: 6px;
            margin: 0 3px;
            padding: 6px 12px;
            font-size: 14px;
            border: 1px solid #dee2e6;
            color: #495057;
            transition: all 0.3s ease;
        }

        .pagination .page-link:hover {
            background-color: #f8f9fa;
            border-color: #0d6efd;
            color: #0d6efd;
        }

        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            color: #adb5bd;
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }

        .pagination-info {
            font-size: 14px;
            color: #6c757d;
            margin-top: 10px;
        }

        @media (max-width: 768px) {
            .pagination .page-link {
                padding: 4px 8px;
                font-size: 13px;
                margin: 0 2px;
            }
        }

        @media (max-width: 576px) {
            .pagination .page-link {
                padding: 3px 6px;
                font-size: 12px;
                margin: 0 1px;
            }

            .pagination {
                flex-wrap: wrap;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0">Daftar Pendaftar</h4>
                <p class="text-muted mb-0">Data lengkap semua peserta pendaftaran</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('staff.applicants.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-sync-alt"></i>
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('staff.applicants.index') }}" method="GET" class="row g-3">
                    <!-- Search Input -->
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0"
                                placeholder="Cari nama, NISN, telepon, sekolah, atau email..."
                                value="{{ request('search') }}">
                        </div>
                    </div>

                    <!-- Wave Filter -->
                    <div class="col-md-3">
                        <select name="wave" class="form-select">
                            <option value="">Semua Gelombang</option>
                            @foreach ($waves as $wave)
                                <option value="{{ $wave->id }}" {{ request('wave') == $wave->id ? 'selected' : '' }}>
                                    {{ $wave->nama_gelombang }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Stats -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card border-start border-primary border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">Total</p>
                                <h4 class="mb-0">{{ $applicants->total() }}</h4>
                            </div>
                            <div class="avatar-sm rounded-circle bg-primary bg-opacity-10 p-3">
                                <i class="fas fa-users text-primary fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card border-start border-success border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">Sudah Bayar</p>
                                <h4 class="mb-0">
                                    {{ \App\Models\Applicant::whereNotNull('bukti_pembayaran')->count() }}
                                </h4>
                            </div>
                            <div class="avatar-sm rounded-circle bg-success bg-opacity-10 p-3">
                                <i class="fas fa-check-circle text-success fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card border-start border-warning border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">Terverifikasi</p>
                                <h4 class="mb-0">
                                    {{ \App\Models\Applicant::where('status_verifikasi', 'diterima')->count() }}
                                </h4>
                            </div>
                            <div class="avatar-sm rounded-circle bg-warning bg-opacity-10 p-3">
                                <i class="fas fa-check-circle text-warning fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card border-start border-info border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">Diterima</p>
                                <h4 class="mb-0">
                                    {{ \App\Models\Applicant::where('status_pendaftaran', 'diterima')->count() }}
                                </h4>
                            </div>
                            <div class="avatar-sm rounded-circle bg-info bg-opacity-10 p-3">
                                <i class="fas fa-user-graduate text-info fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Applicants Cards -->
        @if ($applicants->isEmpty())
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-users fa-4x text-muted"></i>
                </div>
                <h5 class="text-muted">Tidak ada data pendaftar</h5>
                @if (request()->has('search'))
                    <p class="text-muted">Tidak ditemukan hasil untuk "{{ request('search') }}"</p>
                    <a href="{{ route('staff.applicants.index') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-arrow-left me-1"></i> Tampilkan Semua
                    </a>
                @endif
            </div>
        @else
            <!-- Card Grid -->
            <div class="row">
                @foreach ($applicants as $applicant)
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="card shadow-sm h-100 border hover-shadow">
                            <!-- Card Header with Status -->
                            <div class="card-header bg-light py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        @php
                                            $statusColors = [
                                                'menunggu' => 'warning',
                                                'diverifikasi' => 'info',
                                                'ditolak' => 'danger',
                                                'diterima' => 'success',
                                            ];
                                            $color = $statusColors[$applicant->status_pendaftaran] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $color }}">
                                            {{ ucfirst($applicant->status_pendaftaran) }}
                                        </span>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-link text-muted p-0" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('staff.applicants.show', $applicant) }}">
                                                    <i class="fas fa-eye me-2"></i> Detail Lengkap
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body">
                                <!-- Avatar & Name -->
                                <div class="text-center mb-3">
                                    <div class="mb-2">
                                        <div class="avatar-circle mx-auto">
                                            <div class="avatar-initials bg-primary text-white">
                                                {{ substr($applicant->nama_lengkap, 0, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="mb-1 fw-bold text-truncate" title="{{ $applicant->nama_lengkap }}">
                                        {{ $applicant->nama_lengkap }}
                                    </h6>
                                    <p class="text-muted small mb-0 text-truncate">{{ $applicant->asal_sekolah }}</p>
                                </div>

                                <!-- Details -->
                                <div class="border-top pt-3">
                                    <!-- NISN -->
                                    <div class="mb-2 d-flex align-items-start">
                                        <i class="fas fa-id-card text-muted me-2 mt-1" style="width: 16px;"></i>
                                        <div class="flex-grow-1">
                                            <small class="text-muted d-block">NISN</small>
                                            <small class="fw-bold">{{ $applicant->nisn }}</small>
                                        </div>
                                    </div>

                                    <!-- Gelombang -->
                                    <div class="mb-2 d-flex align-items-start">
                                        <i class="fas fa-wave-square text-muted me-2 mt-1" style="width: 16px;"></i>
                                        <div class="flex-grow-1">
                                            <small class="text-muted d-block">Gelombang</small>
                                            <small class="fw-bold">{{ $applicant->registrationWave->nama_gelombang ?? '-' }}</small>
                                        </div>
                                    </div>

                                    <!-- Telepon Wali -->
                                    <div class="mb-2 d-flex align-items-start">
                                        <i class="fas fa-phone text-muted me-2 mt-1" style="width: 16px;"></i>
                                        <div class="flex-grow-1">
                                            <small class="text-muted d-block">Telepon Wali</small>
                                            <small class="fw-bold">{{ $applicant->nomor_telepon_wali }}</small>
                                        </div>
                                    </div>

                                    <!-- Pilihan Jurusan -->
                                    @if ($applicant->majorChoices->isNotEmpty())
                                        <div class="mb-2 d-flex align-items-start">
                                            <i class="fas fa-graduation-cap text-muted me-2 mt-1"
                                                style="width: 16px;"></i>
                                            <div class="flex-grow-1">
                                                <small class="text-muted d-block">Pilihan Jurusan</small>
                                                @foreach ($applicant->majorChoices as $choice)
                                                    <div class="d-flex align-items-center">
                                                        <span
                                                            class="badge bg-secondary me-1">{{ $choice->pivot->priority }}</span>
                                                        <small>{{ $choice->nama ?? '-' }}</small>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Card Footer -->
                            <div class="card-footer bg-transparent border-top-0 pt-0">
                                <a href="{{ route('staff.applicants.show', $applicant) }}"
                                    class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-info-circle me-1"></i> Detail Lengkap
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Custom Pagination -->
            @if ($applicants->hasPages())
                <div class="pagination-wrapper">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center mb-2">
                            {{-- Previous Page Link --}}
                            @if ($applicants->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">
                                        <i class="fas fa-chevron-left"></i>
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $applicants->previousPageUrl() }}">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @php
                                $current = $applicants->currentPage();
                                $last = $applicants->lastPage();
                                $start = max($current - 2, 1);
                                $end = min($current + 2, $last);
                            @endphp

                            {{-- First Page Link --}}
                            @if ($start > 1)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $applicants->url(1) }}">1</a>
                                </li>
                                @if ($start > 2)
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                @endif
                            @endif


                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $current)
                                    <li class="page-item active">
                                        <span class="page-link">{{ $i }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $applicants->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endif
                            @endfor


                            @if ($end < $last)
                                @if ($end < $last - 1)
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                @endif
                                <li class="page-item">
                                    <a class="page-link" href="{{ $applicants->url($last) }}">{{ $last }}</a>
                                </li>
                            @endif


                            @if ($applicants->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $applicants->nextPageUrl() }}">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                </li>
                            @endif
                        </ul>

                        <div class="text-center pagination-info">
                            Menampilkan
                            <strong>{{ $applicants->firstItem() }}</strong> -
                            <strong>{{ $applicants->lastItem() }}</strong>
                            dari <strong>{{ $applicants->total() }}</strong> data
                        </div>
                    </nav>
                </div>
            @endif
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paginationLinks = document.querySelectorAll('.pagination .page-link');
            paginationLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (!this.closest('.page-item').classList.contains('disabled') &&
                        !this.closest('.page-item').classList.contains('active')) {
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
@endpush
