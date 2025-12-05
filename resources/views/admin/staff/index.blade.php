@extends('admin.templates.app')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    <div class="container mt-5">
        <div class="d-flex justify-content-end gap-3">
            <a href="{{ route('admin.staff.export') }}" class="btn btn-secondary">Export (.xlsx)</a>
            <a href="{{ route('admin.staff.create') }}" class="btn btn-success">Tambah Data</a>
            <a href="{{ route('admin.staff.trash') }}" class="btn btn-warning">Lihat Data Sampah</a>

        </div>
        <h5>Data Jadwal Wawancara</h5>
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
                ajax: "{{ route('admin.staff.datatables') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_staff',
                        name: 'nama_staff'
                    },
                    {
                        data: 'nama_pendaftar',
                        name: 'nama_pendaftar'
                    },
                    {
                        data: 'tanggal_wawancara',
                        name: 'tanggal_wawancara'
                    },
                    {
                        data: 'waktu_wawancara',
                        name: 'waktu_wawancara'
                    },
                    {
                        data: 'status_kehadiran',
                        name: 'status_kehadiran'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
