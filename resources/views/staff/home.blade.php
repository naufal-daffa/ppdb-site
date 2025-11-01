@extends('staff.templates.app')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    <div class="container mt-5">
        <div class="d-flex justify-content-end gap-3">
            {{-- <a href="{{ route('admin.skill-field.export') }}" class="btn btn-secondary">Export (.xlsx)</a> --}}
            <a href="{{ route('admin.users.create') }}" class="btn btn-success">Tambah Data</a>
            {{-- <a href="{{ route('admin.skill-field.trash') }}" class="btn btn-warning">Lihat Data Sampah</a> --}}

        </div>
        <h5>Data Staff</h5>
        <table id="tableData" class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Lengkap</th>
                    <th>Nisn</th>
                    <th>Nomor Telepon Wali</th>
                    <th>Bukti Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- <tr>
                    @foreach ($applicants as $index => $item)
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item['nama_lengkap'] }}</td>
                        <td>{{ $item['nisn'] }}</td>
                        <td>{{ $item['nomor_telepon_wali'] }}</td>
                        <td><img src="{{ asset('storage/' . $item['bukti_pembayaran']) }}" width="100" alt=""></td>
                        <td></td>
                    @endforeach
                </tr> --}}
            </tbody>
        </table>

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
            $('#tableData').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('staff.applicants.datatables') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_lengkap',
                        name: 'nama_lengkap',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'nisn',
                        name: 'nisn',
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
                        data: 'bukti_pembayaran',
                        name: 'bukti_pembayaran',
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

         function showModal(item) {
            img = item.bukti_pembayaran;
            let content = `
        <ul class="list-group">
            <img src="{{ asset('storage/${img}')}}">
        </ul>
    `;

            $('#modalDetailBody').html(content);
            new bootstrap.Modal(document.getElementById('modalDetail')).show();
        }
    </script>

@endpush
