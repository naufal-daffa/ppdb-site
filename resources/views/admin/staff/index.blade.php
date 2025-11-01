@extends('admin.templates.app')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    <div class="container mt-5">
        <div class="d-flex justify-content-end gap-3">
            {{-- <a href="{{ route('admin.skill-field.export') }}" class="btn btn-secondary">Export (.xlsx)</a> --}}
            <a href="{{ route('admin.staff.create') }}" class="btn btn-success">Tambah Data</a>
            {{-- <a href="{{ route('admin.skill-field.trash') }}" class="btn btn-warning">Lihat Data Sampah</a> --}}

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
{{-- @push('script')
    <script>
        $(function() {
            $('#tableData').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.skill-fields.datatables') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
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
@endpush --}}
