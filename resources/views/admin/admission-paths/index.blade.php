@extends('admin.templates.app')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    <div class="container mt-5">
        <div class="d-flex justify-content-end gap-3 mb-3">
            <a href="{{ route('admin.admission-paths.export') }}" class="btn btn-secondary">Export (.xlsx)</a>
            <a href="{{ route('admin.admission-paths.create') }}" class="btn btn-success">Tambah Data</a>
            <a href="{{ route('admin.admission-paths.trash') }}" class="btn btn-warning">Lihat Data Sampah</a>
        </div>

        <h5>Data Jalur Pendaftaran</h5>
        <div class="card shadow-sm">
            <div class="card-body">
                <table id="admissionPathsTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Jalur</th>
                            <th>Jumlah Pendaftar</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            $('#admissionPathsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.admission-paths.datatables') }}", // PASTIKAN ROUTE INI BENAR
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'prestasi',
                        name: 'prestasi',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'applicants_count',
                        name: 'applicants_count',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return '<span class="badge bg-info">' + data + '</span>';
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        orderable: true,
                        searchable: false,
                        render: function(data) {
                            return new Date(data).toLocaleDateString('id-ID');
                        }
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
