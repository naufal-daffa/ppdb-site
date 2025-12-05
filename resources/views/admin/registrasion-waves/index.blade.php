@extends('admin.templates.app')

@section('content')
<div class="container mt-5">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-end gap-3 mb-4">
        <a href="{{ route('admin.registrasion-waves.export') }}" class="btn btn-secondary">
            Export (.xlsx)
        </a>
        <a href="{{ route('admin.registrasion-waves.create') }}" class="btn btn-success">
            Tambah Gelombang
        </a>
        <a href="{{ route('admin.registrasion-waves.trash') }}" class="btn btn-warning">
            Sampah
        </a>
    </div>

    <h5 class="mb-3">Data Gelombang Pendaftaran</h5>

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="tableData" class="table table-bordered table-hover" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th width="5%">#</th>
                        <th>Nama Gelombang</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th width="10%">Status</th>
                        <th width="28%">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    const table = $('#tableData').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.registrasion-waves.datatables') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'nama_gelombang', name: 'nama_gelombang' },
            { data: 'tanggal_mulai', name: 'tanggal_mulai' },
            { data: 'tanggal_selesai', name: 'tanggal_selesai' },
            { data: 'activeBadge', name: 'activeBadge', orderable: false, searchable: false },
            { data: 'buttons', name: 'buttons', orderable: false, searchable: false, className: 'text-center' }
        ],
        language: {
            processing: "Memuat data...",
            zeroRecords: "Tidak ada data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(difilter dari _MAX_ total data)",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }
        }
    });

    $('#tableData tbody').on('click', 'button', function(e) {
        const button = this;
        const form = button.closest('form');

        if (!form) return;

        e.preventDefault();


        if (button.classList.contains('btn-danger')) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Gelombang ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }


        else if (button.classList.contains('btn-success')) {
            Swal.fire({
                title: 'Aktifkan gelombang ini?',
                text: "Semua gelombang lain akan otomatis dinonaktifkan.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, aktifkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }


        else if (button.classList.contains('btn-warning') && button.textContent.trim().includes('Nonaktifkan')) {
            Swal.fire({
                title: 'Nonaktifkan gelombang ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fd7e14',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, nonaktifkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    });


    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
});
</script>
@endpush
