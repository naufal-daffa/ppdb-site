@extends('staff.templates.app')

@section('content')
<div class="container-fluid py-4">
    <h2 class="mb-4">Verifikasi Dokumen Pendaftar</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse($applicants as $applicant)
            @php $doc = $applicant->document; @endphp
            <div class="col-md-4 mb-4">
                <div class="card shadow border-left-primary h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $applicant->nama_lengkap }}</h5>
                        <p class="text-muted small">NISN: {{ $applicant->nisn }}</p>
                        <p class="mb-2">
                            <strong>Status:</strong>
                            <span class="badge bg-{{
                                $doc->status_verifikasi == 'lengkap' ? 'success' :
                                ($doc->status_verifikasi == 'perlu_perbaikan' ? 'danger' : 'warning')
                            }}">
                                {{ ucwords(str_replace('_', ' ', $doc->status_verifikasi)) }}
                            </span>
                        </p>
                        <a href="{{ route('staff.documents.verify', $applicant->id) }}"
                           class="btn btn-primary btn-sm">Verifikasi Dokumen</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Tidak ada dokumen yang perlu diverifikasi saat ini.
                </div>
            </div>
        @endforelse
    </div>

    {{ $applicants->links() }}
</div>
@endsection
