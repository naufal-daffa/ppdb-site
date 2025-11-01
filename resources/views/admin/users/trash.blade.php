@extends('admin.templates.app')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    <div class="container mt-5">
        <div class="d-flex justify-content-end gap-3">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">← Kembali</a>

        </div>
        <h5>Data Sampah : Gelombang Pendaftaran</h5>
        <table id="tableData" class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    {{-- <th>Aktif</th> --}}
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @forelse ($users as $index => $item)
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->email }}</td>
                        <td>@if ($item->role == 'admin')
                            <div class="badge badge-success">Admin</div>
                            @else
                            <div class="badge badge-info">Staff</div>
                        @endif</td>
                        {{-- <td>{{ $item->deleted_at->format('d M Y H:i') }}</td> --}}
                        <td class="d-flex gap-2">
                            <form action="{{ route('admin.users.restore', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-success btn-sm">Pulihkan</button>
                            </form>

                            <form action="{{ route('admin.users.delete_permanent', $item->id) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin hapus permanen?')">Hapus Permanen</button>
                            </form>
                        </td>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            Data Belum Ada
                        </td>
                    </tr>
                    @endforelse
                </tr>
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
