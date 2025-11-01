@extends('admin.templates.app')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    <div class="container mt-5">
        <div class="d-flex justify-content-end gap-3">
            <a href="{{ route('admin.registrasion-waves.export') }}" class="btn btn-secondary">Export (.xlsx)</a>
            <a href="{{ route('admin.registrasion-waves.create') }}" class="btn btn-success">Tambah Data</a>
            <a href="{{ route('admin.registrasion-waves.trash') }}" class="btn btn-warning">Lihat Data Sampah</a>

        </div>
        <h5>Data Gelombang Pendaftaran</h5>
        <table id="tableData" class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Aktif</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
@endsection
@push('script')
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
@endpush
