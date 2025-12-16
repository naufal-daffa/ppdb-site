{{-- resources/views/staff/applicants/show.blade.php --}}
@extends('staff.templates.app')

@push('style')
<style>
    .avatar-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        border: 3px solid #e9ecef;
        margin: 0 auto;
    }

    .avatar-initials {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .nav-tabs .nav-link {
        color: #6c757d;
        font-weight: 500;
    }

    .nav-tabs .nav-link.active {
        color: #0d6efd;
        font-weight: 600;
    }

    .card.border {
        border-color: #e9ecef !important;
    }

    .card.border:hover {
        border-color: #0d6efd !important;
    }

    @media print {
        .nav-tabs,
        .card-footer,
        .btn,
        .no-print {
            display: none !important;
        }

        .tab-content > .tab-pane {
            display: block !important;
            opacity: 1 !important;
        }

        body {
            background: white;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4 no-print">
        <a href="{{ route('staff.applicants.index') }}" class="btn btn-outline-secondary">
            Kembali ke Daftar
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Detail Pendaftar</h5>
                <small class="opacity-75">ID: {{ $applicant->id }}</small>
            </div>
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
                <span class="badge bg-{{ $color }} fs-6">
                    {{ ucfirst($applicant->status_pendaftaran) }}
                </span>
            </div>
        </div>

        <div class="card-body">
            <div class="row mb-5">
                <div class="col-md-3 text-center">
                    <div class="avatar-circle mb-3 mx-auto">
                        <div class="avatar-initials bg-primary text-white"
                             style="width: 100px; height: 100px; font-size: 36px;">
                            {{ substr($applicant->nama_lengkap, 0, 2) }}
                        </div>
                    </div>
                    <h4 class="mb-1">{{ $applicant->nama_lengkap }}</h4>
                    <p class="text-muted">{{ $applicant->asal_sekolah }}</p>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted small mb-1">NISN</label>
                                <p class="fw-bold mb-0">{{ $applicant->nisn }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small mb-1">Tanggal Lahir</label>
                                <p class="fw-bold mb-0">
                                    {{ $applicant->tanggal_lahir ? \Carbon\Carbon::parse($applicant->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small mb-1">Jenis Kelamin</label>
                                <p class="fw-bold mb-0">{{ $applicant->jenis_kelamin ?? '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small mb-1">Alamat</label>
                                <p class="fw-bold mb-0">{{ $applicant->alamat ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted small mb-1">No. Telepon</label>
                                <p class="fw-bold mb-0">{{ $applicant->nomor_telepon ?? '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small mb-1">Email</label>
                                <p class="fw-bold mb-0">{{ $applicant->user->email ?? '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small mb-1">Gelombang</label>
                                <p class="fw-bold mb-0">{{ $applicant->registrationWave->nama_gelombang ?? '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small mb-1">Status Pembayaran</label>
                                <p class="fw-bold mb-0">
                                    <span class="badge bg-{{ $applicant->bukti_pembayaran ? 'success' : 'warning' }}">
                                        {{ $applicant->bukti_pembayaran ? 'Sudah Bayar' : 'Belum Bayar' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB NAVIGATION - KONDISIONAL --}}
            <ul class="nav nav-tabs mb-4 no-print" id="applicantTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="family-tab" data-bs-toggle="tab" data-bs-target="#family" type="button" role="tab">
                        Data Keluarga
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="major-tab" data-bs-toggle="tab" data-bs-target="#major" type="button" role="tab">
                        Pilihan Jurusan
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab">
                        Dokumen
                    </button>
                </li>

                {{-- TAB SERTIFIKAT: Hanya muncul jika ada sertifikat --}}
                @if($applicant->certificates->isNotEmpty())
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="certificates-tab" data-bs-toggle="tab" data-bs-target="#certificates" type="button" role="tab">
                            Sertifikat
                            <span class="badge bg-primary ms-1">{{ $applicant->certificates->count() }}</span>
                        </button>
                    </li>
                @endif

                {{-- TAB JALUR PENDAFTARAN: Muncul jika ada sertifikat ATAU sudah dipilih jalur --}}
                @if($applicant->certificates->isNotEmpty() || $applicant->admission_path_id)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ !$applicant->certificates->isNotEmpty() && $applicant->admission_path_id ? 'active' : '' }}"
                                id="admission-path-tab" data-bs-toggle="tab" data-bs-target="#admission-path" type="button" role="tab">
                            Jalur Pendaftaran
                            @if($applicant->admission_path_id)
                                <span class="badge bg-success ms-1">Terpilih</span>
                            @endif
                        </button>
                    </li>
                @endif
            </ul>

            <div class="tab-content" id="applicantTabContent">
                {{-- TAB DATA KELUARGA --}}
                <div class="tab-pane fade show active" id="family" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-header bg-light">Data Ayah</div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <label class="text-muted small">Pekerjaan</label>
                                        <p class="fw-bold mb-0">{{ $applicant->pekerjaan_ayah ?? '-' }}</p>
                                    </div>
                                    @if($applicant->document && $applicant->document->ktp_ayah)
                                        <div class="mb-2">
                                            <label class="text-muted small">KTP Ayah</label>
                                            <p>
                                                <a href="{{ asset('storage/' . $applicant->document->ktp_ayah) }}" target="_blank"
                                                   class="btn btn-sm btn-outline-primary">Lihat Dokumen</a>
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-header bg-light">Data Ibu</div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <label class="text-muted small">Pekerjaan</label>
                                        <p class="fw-bold mb-0">{{ $applicant->pekerjaan_ibu ?? '-' }}</p>
                                    </div>
                                    @if($applicant->document && $applicant->document->ktp_ibu)
                                        <div class="mb-2">
                                            <label class="text-muted small">KTP Ibu</label>
                                            <p>
                                                <a href="{{ asset('storage/' . $applicant->document->ktp_ibu) }}" target="_blank"
                                                   class="btn btn-sm btn-outline-primary">Lihat Dokumen</a>
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light">Kontak Wali</div>
                        <div class="card-body">
                            <p class="fw-bold mb-0">{{ $applicant->nomor_telepon_wali ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- TAB PILIHAN JURUSAN --}}
                <div class="tab-pane fade" id="major" role="tabpanel">
                    @if($applicant->majorChoices->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="100">Prioritas</th>
                                        <th>Jurusan</th>
                                        <th>Bidang Keahlian</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($applicant->majorChoices as $choice)
                                        <tr>
                                            <td>
                                                <span class="badge bg-primary fs-6">{{ $choice->pivot->priority }}</span>
                                            </td>
                                            <td class="fw-bold">{{ $choice->nama }}</td>
                                            <td>{{ $choice->skillField->nama ?? '-' }}</td>
                                            <td class="small text-muted">{{ Str::limit($choice->deskripsi ?? '-', 100) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <p class="text-muted">Belum memilih jurusan</p>
                        </div>
                    @endif
                </div>

                {{-- TAB DOKUMEN --}}
                <div class="tab-pane fade" id="documents" role="tabpanel">
                    @if($applicant->document)
                        <div class="row">
                            @php
                                $documents = [
                                    ['name' => 'Kartu Keluarga', 'field' => 'kartu_keluarga'],
                                    ['name' => 'Akte Kelahiran', 'field' => 'akte_kelahiran'],
                                    ['name' => 'Ijazah', 'field' => 'ijazah'],
                                    ['name' => 'Surat Kelulusan', 'field' => 'surat_kelulusan'],
                                    ['name' => 'Surat Kesehatan', 'field' => 'surat_kesehatan'],
                                ];
                            @endphp

                            @foreach($documents as $doc)
                                @if(!empty($applicant->document->{$doc['field']}))
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="card border h-100">
                                            <div class="card-body text-center">
                                                <div class="mb-3">
                                                    {{-- <i class="{{ $doc['icon'] }} fa-3x text-primary"></i> --}}
                                                </div>
                                                <h6>{{ $doc['name'] }}</h6>
                                                <div class="mt-3">
                                                    <a href="{{ asset('storage/' . $applicant->document->{$doc['field']}) }}" target="_blank"
                                                       class="btn btn-sm btn-primary">Lihat</a>
                                                    <a href="{{ asset('storage/' . $applicant->document->{$doc['field']}) }}" download
                                                       class="btn btn-sm btn-outline-primary">Unduh</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            <div class="col-12 mt-4">
                                <div class="card border">
                                    <div class="card-header bg-light">Status Verifikasi Dokumen</div>
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <span class="badge bg-{{ $applicant->document->status_verifikasi == 'terverifikasi' ? 'success' : ($applicant->document->status_verifikasi == 'ditolak' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($applicant->document->status_verifikasi ?? 'Belum diverifikasi') }}
                                        </span>
                                        {{-- <small class="text-muted">Lokasi: {{ $applicant->document->lokasi_berkas ?? '-' }}</small> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">Belum mengupload dokumen</div>
                    @endif
                </div>

                {{-- TAB SERTIFIKAT --}}
                @if($applicant->certificates->isNotEmpty())
                    <div class="tab-pane fade" id="certificates" role="tabpanel">
                        <div class="row">
                            @foreach($applicant->certificates as $certificate)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card border h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <h6 class="mb-1">{{ $certificate->nama_file }}</h6>
                                                    <small class="text-muted">
                                                        {{ $certificate->created_at?->translatedFormat('d F Y') }}
                                                    </small>
                                                </div>
                                                <span class="badge bg-info">Sertifikat</span>
                                            </div>
                                            <p class="small text-muted">{{ Str::limit($certificate->deskripsi, 100) }}</p>
                                            <div class="mt-3">
                                                <a href="{{ asset('storage/' . $certificate->file_path) }}" target="_blank"
                                                   class="btn btn-sm btn-primary">Lihat</a>
                                                <a href="{{ asset('storage/' . $certificate->file_path) }}" download
                                                   class="btn btn-sm btn-outline-primary">Unduh</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- TAB JALUR PENDAFTARAN --}}
                @if($applicant->certificates->isNotEmpty() || $applicant->admission_path_id)
                    <div class="tab-pane fade {{ !$applicant->certificates->isNotEmpty() && $applicant->admission_path_id ? 'show active' : '' }}"
                         id="admission-path" role="tabpanel">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card border">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Pilih / Update Jalur Pendaftaran</h6>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('staff.applicants.update-admission-path', $applicant->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Jalur Pendaftaran</label>
                                                <select name="admission_path_id" class="form-select @error('admission_path_id') is-invalid @enderror">
                                                    <option value="">-- Pilih Jalur --</option>
                                                    @foreach($admissionPaths as $path)
                                                        <option value="{{ $path->id }}"
                                                            {{ old('admission_path_id', $applicant->admission_path_id) == $path->id ? 'selected' : '' }}>
                                                            {{ $path->prestasi }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('admission_path_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="d-flex gap-2">
                                                <button type="submit" class="btn btn-primary">Simpan Jalur</button>
                                                @if($applicant->admission_path_id)
                                                    <button type="button" class="btn btn-outline-danger" onclick="confirmReset()">
                                                        Reset Jalur
                                                    </button>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border h-100">
                                    <div class="card-header bg-light">Informasi Jalur Saat Ini</div>
                                    <div class="card-body">
                                        @if($applicant->admissionPath)
                                            <div class="text-center mb-4">
                                                <h4 class="text-primary">{{ $applicant->admissionPath->prestasi }}</h4>
                                                <span class="badge bg-success">Terpilih</span>
                                            </div>
                                            <p class="small text-muted">
                                                {{ [
                                                    'Akademik' => 'Berdasarkan nilai rapor',
                                                    'Prestasi' => 'Memiliki sertifikat prestasi',
                                                    'Non-Akademik' => 'Prestasi olahraga/seni',
                                                    'Afirmasi' => 'Keluarga kurang mampu',
                                                    'Zonasi' => 'Domisili dekat sekolah',
                                                ][$applicant->admissionPath->prestasi] ?? 'Jalur khusus' }}
                                            </p>
                                            <p class="mb-0">
                                                <strong>{{ $applicant->admissionPath->applicants_count ?? 0 }}</strong> pendaftar di jalur ini
                                            </p>
                                        @else
                                            <div class="text-center text-muted py-4">
                                                <p>Belum ada jalur yang dipilih</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="card-footer bg-light d-flex justify-content-between no-print">
            <small class="text-muted">
                Terdaftar: {{ $applicant->created_at?->translatedFormat('d F Y H:i') ?? '-' }}
            </small>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmReset() {
    Swal.fire({
        title: 'Reset Jalur Pendaftaran?',
        text: "Jalur yang sudah dipilih akan dihapus.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Reset',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("staff.applicants.reset-admission-path", $applicant->id) }}';
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endpush
