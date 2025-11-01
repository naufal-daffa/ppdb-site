@extends('admin.templates.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('admin.majors.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>
    <h5>Data Sampah : Jurusan Terhapus</h5>

    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Bidang Keahlian</th>
                <th>Nama Jurusan</th>
                <th>Deskripsi</th>
                <th>Tanggal Dihapus</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($majors as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->skillField->nama ?? '-' }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->deskripsi }}</td>
                    <td>{{ $item->deleted_at->format('d M Y H:i') }}</td>
                    <td class="d-flex gap-2">
                        <form action="{{ route('admin.majors.restore', $item->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success btn-sm">Pulihkan</button>
                        </form>

                        <form action="{{ route('admin.majors.delete_permanent', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus permanen?')">Hapus Permanen</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data di sampah</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
