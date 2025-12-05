@extends('applicants.app')

@section('content')
<div class="container my-5">
    <div class="w-75 mx-auto">

        <h4 class="text-center mb-5 fw-bold text-primary">Dokumen Persyaratan Pendaftaran</h4>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @php
            $fields = [
                'kartu_keluarga'   => 'Kartu Keluarga (KK)',
                'akte_kelahiran'   => 'Akte Kelahiran',
                'ijazah'           => 'Ijazah Terakhir',
                'surat_kelulusan'  => 'Surat Keterangan Lulus (SKL)',
                'ktp_ayah'         => 'KTP Ayah',
                'ktp_ibu'          => 'KTP Ibu',
                'surat_kesehatan'  => 'Surat Keterangan Sehat',
            ];

            // Ambil status & catatan dari kolom JSON (atau string biasa)
            $status = $document->verification_status ?? [];
            $notes  = $document->verification_notes ?? [];
        @endphp

        {{-- SELALU TAMPILKAN FORM JIKA BELUM LENGKAP --}}
        @if ($document->status_verifikasi !== 'lengkap')
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Unggah Dokumen Persyaratan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('applicants.documents.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-4">
                            @foreach ($fields as $key => $label)
                                @php
                                    $isRejected = ($status[$key] ?? null) === 'rejected';
                                    $fileExists = !empty($document->{$key}) && Storage::disk('public')->exists($document->{$key});
                                @endphp

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">
                                        {{ $label }}
                                        @if (in_array($key, ['kartu_keluarga', 'akte_kelahiran'])) <span class="text-danger">*</span> @endif
                                        @if ($isRejected) <span class="badge bg-danger ms-2">Wajib Upload Ulang</span> @endif
                                    </label>

                                    @if ($fileExists && !$isRejected)
                                        <div class="mb-2">
                                            <a href="{{ Storage::url($document->{$key}) }}" target="_blank" class="btn btn-sm btn-success">
                                                Lihat Dokumen
                                            </a>
                                        </div>
                                    @endif

                                    <input type="file"
                                           name="{{ $key }}"
                                           class="form-control @error($key) is-invalid @enderror
                                                  @if($isRejected) border-danger @endif"
                                           accept=".pdf,.jpg,.jpeg,.png">
                                    @error($key)
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <div class="text-center mt-5">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                Simpan & Kirim Dokumen
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        {{-- STATUS UMUM --}}
        @if ($document->status_verifikasi === 'lengkap')
            <div class="alert alert-success text-center py-4 shadow-sm mt-4">
                <h4>Selamat! Dokumen Anda Sudah Lengkap & Disetujui</h4>
            </div>
        @elseif ($document->status_verifikasi === 'perlu_perbaikan')
            <div class="alert alert-warning shadow-sm mt-4">
                <h5>Ada Dokumen yang Perlu Diperbaiki</h5>
                <p>Silakan upload ulang dokumen yang ditandai <span class="badge bg-danger">Wajib Upload Ulang</span>.</p>
            </div>
        @elseif ($document->status_verifikasi === 'menunggu')
            <div class="alert alert-info shadow-sm mt-4">
                <h5>Dokumen Sedang Diverifikasi</h5>
                <p>Tunggu proses verifikasi oleh panitia.</p>
            </div>
        @else
            <div class="alert alert-secondary shadow-sm mt-4">
                <h5>Belum Mengunggah Dokumen</h5>
                <p>Silakan lengkapi dokumen di atas.</p>
            </div>
        @endif

        {{-- TABEL STATUS DETAIL --}}
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Status Dokumen Anda</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Jenis Dokumen</th>
                            <th width="140">Status</th>
                            <th width="120">File</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fields as $key => $label)
                            @php
                                $fileExists = !empty($document->{$key}) && Storage::disk('public')->exists($document->{$key});
                                $currentStatus = $status[$key] ?? null;
                                $note = $notes[$key] ?? '-';
                            @endphp
                            <tr>
                                <td class="align-middle">{{ $label }}</td>
                                <td class="align-middle text-center">
                                    @if ($currentStatus === 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif ($currentStatus === 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @elseif ($fileExists)
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @else
                                        <span class="badge bg-secondary">Belum Upload</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    @if ($fileExists)
                                        <a href="{{ Storage::url($document->{$key}) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat</a>
                                    @else
                                        <small class="text-muted">-</small>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <small>{{ $note !== '-' ? $note : '-' }}</small>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- {{ Auth::user()->nama }} --}}
            </div>
        </div>
    </div>
</div>
@endsection
