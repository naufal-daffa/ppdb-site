@extends('admin.templates.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Trash - Jalur Pendaftaran</h5>
            <a href="{{ route('admin.admission-paths.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
        <div class="card-body">
            @if($admissionPaths->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-trash fa-4x text-muted mb-3"></i>
                    <p class="text-muted">Tidak ada data di trash</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Jalur</th>
                                <th>Jumlah Pendaftar</th>
                                <th>Dihapus</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admissionPaths as $path)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $path->prestasi }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $path->applicants()->count() }}</span>
                                </td>
                                <td>
                                    {{ $path->deleted_at->translatedFormat('d F Y H:i') }}
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('admin.admission-paths.restore', $path->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm"
                                                    onclick="return confirm('Yakin ingin memulihkan data?')">
                                                <i class="fas fa-trash-restore me-1"></i>Restore
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.admission-paths.delete-permanent', $path->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Yakin ingin menghapus permanen? Data tidak dapat dikembalikan!')">
                                                <i class="fas fa-trash-alt me-1"></i>Hapus Permanen
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        {{-- @if($admissionPaths->isNotEmpty())
        <div class="card-footer bg-white">
            <form action="{{ route('admin.admission-paths.delete-permanent') }}" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus semua data permanen?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    <i class="fas fa-trash me-1"></i>Hapus Semua Permanen
                </button>
            </form>
        </div>
        @endif --}}
    </div>
</div>
@endsection
