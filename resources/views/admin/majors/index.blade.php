@extends('admin.templates.app')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    <div class="container mt-5">
        <div class="d-flex justify-content-end gap-3">
            <a href="{{ route('admin.majors.export') }}" class="btn btn-secondary">Export (.xlsx)</a>
            <a href="{{ route('admin.majors.create') }}" class="btn btn-success">Tambah Data</a>
            <a href="{{ route('admin.majors.trash') }}" class="btn btn-warning">Lihat Data Sampah</a>

        </div>
        <h5>Data Jurusan</h5>
        <table id="tableData" class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Bidang Keahlian</th>
                    <th>Jurusan</th>
                    <th>Deskripsi</th>
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
                ajax: "{{ route('admin.majors.datatables') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'skill-field',
                        name: 'skill-field',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'deskripsi',
                        name: 'deskripsi',
                        orderable: false,
                        searchable: true
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
