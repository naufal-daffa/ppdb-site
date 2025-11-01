@extends('admin.templates.app')

@section('content')
    <div class="container mt-5">
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <div class="d-flex justify-content-end">
            <a href="{{ route('admin.applicants.export') }}" class="btn btn-secondary">Export (.xlsx)</a>
        </div>
        <h5 class="mb-3">Data Pendaftar</h5>
        <table class="table table-bordered" id="tableApplicants">
            <thead>
                <tr>
                    <th>#</th>
                    <th>NISN</th>
                    <th>Nama Lengkap</th>
                    <th>Nomor Telepon Wali</th>
                    <th>Asal Sekolah</th>
                    <th>Bukti Pembayaran</th>
                    <th>Jurusan</th>
                    <th>Jalur Prestasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        {{-- Modal detail --}}
        <div class="modal fade" id="modalDetail" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalTitle">Detail Pendaftar</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="modalDetailBody">...</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            $('#tableApplicants').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.applicants.datatables') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nisn',
                        name: 'nisn',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_lengkap',
                        name: 'nama_lengkap',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'nomor_telepon_wali',
                        name: 'nomor_telepon_wali',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'asal_sekolah',
                        name: 'asal_sekolah',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'bukti_pembayaran',
                        name: 'bukti_pembayaran',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'jurusan',
                        name: 'jurusan',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'jalur_prestasi',
                        name: 'jalur_prestasi',
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
            });
        });

        function showModal(item) {
            let content = `
        <ul class="list-group">
            <li class="list-group-item"><strong>NISN:</strong> ${item.nisn}</li>
            <li class="list-group-item"><strong>Nama Lengkap:</strong> ${item.nama_lengkap}</li>
            <li class="list-group-item"><strong>Alamat:</strong> ${item.alamat}</li>
            <li class="list-group-item"><strong>Tanggal Lahir:</strong> ${item.tanggal_lahir}</li>
            <li class="list-group-item"><strong>Nomor Telepon:</strong> ${item.nomor_telepon}</li>
            <li class="list-group-item"><strong>Nomor Telepon Wali:</strong> ${item.nomor_telepon_wali ?? '-'}</li>
        </ul>
    `;

            $('#modalDetailBody').html(content);
            new bootstrap.Modal(document.getElementById('modalDetail')).show();
        }
    </script>
@endpush
