@extends('admin.templates.app')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    <div class="container mt-5">
        <div class="d-flex justify-content-end gap-3">
            <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">← Kembali</a>

        </div>
        <h5>Data Sampah : Gelombang Pendaftaran</h5>
        <table id="tableData" class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Staff</th>
                    <th>Nama Pendaftar</th>
                    <th>Tanggal Wawancara</th>
                    <th>Waktu Wawancara</th>
                    <th>Status Kehadiran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($staff as $index => $item)
                <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->user->nama }}</td>
                        <td>{{ $item->applicant->nama_lengkap }}</td>
                        <td>{{ $item->tanggal_wawancara }}</td>
                        <td>{{ $item->waktu_wawancara }}</td>
                        <td>{{ $item->status_kehadiran }}</td>
                        {{-- <td>{{ $item->deleted_at->format('d M Y H:i') }}</td> --}}
                        <td class="d-flex gap-2">
                            <form action="{{ route('admin.staff.restore', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-success btn-sm">Pulihkan</button>
                            </form>

                            <form action="{{ route('admin.staff.delete_permanent', $item->id) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin hapus permanen?')">Hapus Permanen</button>
                            </form>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            Data Belum Ada
                        </td>
                    </tr>
                    @endforelse
            </tbody>
        </table>
    </div>
@endsection
{{-- @push('script')
    <script>
        $(function() {
            $('#tableData').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.registrasion-waves.datatables') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_gelombang',
                        name: 'nama_gelombang',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'tanggal_mulai',
                        name: 'tanggal_mulai',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'tanggal_selesai',
                        name: 'tanggal_selesai',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'activeBadge',
                        name: 'activeBadge',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'buttons',
                        name: 'buttons',
                        orderable: false,
                        searchable: false
                    },
                ]
            })
        })
    </script>
@endpush --}}
