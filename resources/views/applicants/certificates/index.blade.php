@extends('applicants.app')

@section('content')
<div class="container py-5">
    <h3 class="mb-4 text-primary">Upload Sertifikat Prestasi</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('applicants.certificates.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">File Sertifikat (PDF/Gambar)</label>
                        <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" required accept=".pdf,.jpg,.jpeg,.png">
                        @error('file') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nama Sertifikat</label>
                        <input type="text" name="nama_sertifikat" class="form-control" required placeholder="Contoh : Juara 1 Lomba OSN Matematika">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary d-block">Upload</button>
                    </div>
                </div>
                <div class="mt-3">
                    <textarea name="deskripsi" class="form-control" rows="2" placeholder="Deskripsi singkat (opsional)"></textarea>
                </div>
            </form>
        </div>
    </div>

    <h5>Daftar Sertifikat ({{ $certificates->count() }})</h5>
    <div class="row">
        @forelse($certificates as $cert)
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1">{{ $cert->nama_sertifikat }}</h6>
                            <small class="text-muted">{{ $cert->deskripsi }}</small>
                            <div class="mt-2">
                                <span class="badge bg-{{ $cert->status_badge ?? 'warning' }}">
                                    {{ ucwords($cert->status_verifikasi ?? 'pending') }}
                                </span>
                            </div>
                        </div>
                        <div class="text-end">
                            <a href="{{ Storage::url($cert->file_path) }}" target="_blank" class="btn btn-sm btn-success">Lihat</a>
                            <form action="{{ route('applicants.certificates.destroy', $cert) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Belum ada sertifikat diunggah.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
