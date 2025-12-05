@extends('staff.templates.app')

@section('content')
<div class="container-fluid py-4">
    <h3>Verifikasi Dokumen - {{ $applicant->nama_lengkap }}</h3>
    <p class="text-muted">NISN: {{ $applicant->nisn }}</p>

    <form action="{{ route('staff.documents.verify.store', $applicant->id) }}" method="POST">
        @csrf

        @php
            $fields = [
                'kartu_keluarga'   => 'Kartu Keluarga (KK)',
                'akte_kelahiran'   => 'Akte Kelahiran',
                'ijazah'           => 'Ijazah',
                'surat_kelulusan'  => 'Surat Keterangan Lulus',
                'ktp_ayah'         => 'KTP Ayah',
                'ktp_ibu'          => 'KTP Ibu',
                'surat_kesehatan'  => 'Surat Kesehatan',
            ];

            $status = $applicant->document->verification_status ?? [];
            $notes  = $applicant->document->verification_notes ?? [];
        @endphp

        <div class="row">
            @foreach($fields as $key => $label)
                @php
                    $path = $applicant->document->{$key};
                    $current = $status[$key] ?? 'pending';
                @endphp
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <strong>{{ $label }}</strong>
                            @if($path)
                                <a href="{{ Storage::url($path) }}" target="_blank" class="btn btn-sm btn-success">Lihat</a>
                            @else
                                <span class="badge bg-danger">Belum Upload</span>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status[{{ $key }}]" value="approved"
                                           {{ $current === 'approved' ? 'checked' : '' }} required>
                                    <label class="form-check-label text-success">Disetujui</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status[{{ $key }}]" value="rejected"
                                           {{ $current === 'rejected' ? 'checked' : '' }}>
                                    <label class="form-check-label text-danger">Ditolak</label>
                                </div>
                            </div>
                            <textarea name="notes[{{ $key }}]" class="form-control form-control-sm" rows="2"
                                      placeholder="Alasan penolakan (wajib jika ditolak)">{{ $notes[$key] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-lg btn-primary px-5">Simpan Verifikasi</button>
            <a href="{{ route('staff.documents.index') }}" class="btn btn-secondary btn-lg">Kembali</a>
        </div>
    </form>
</div>
@endsection
