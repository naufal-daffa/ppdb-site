@extends('staff.templates.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Penilaian Wawancara</h5>
        </div>
        <div class="card-body p-0">
            @if($applicants->isEmpty())
                <div class="alert alert-info text-center m-4">
                    Belum ada jadwal wawancara untuk Anda hari ini.
                </div>
            @else
                <div class="alert alert-info m-3 mb-0">
                    <small>
                        <i class="fas fa-info-circle me-1"></i>
                        <strong>Informasi:</strong> Status dihitung otomatis:<br>
                        • Hasil Akhir ≥ 85: <span class="badge bg-success">Lulus</span><br>
                        • Hasil Akhir < 85: <span class="badge bg-danger">Tidak Lulus</span><br>
                        Hasil akhir = (40% Nilai Ujian + 60% Nilai Wawancara)
                    </small>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Nama Peserta</th>
                                <th>Jadwal Wawancara</th>
                                <th>Prioritas Jurusan</th>
                                <th>Nilai Ujian</th>
                                <th>Nilai Wawancara</th>
                                <th>Hasil Akhir</th>
                                <th>Status Seleksi</th>
                                <th>Status Pendaftaran</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($applicants as $applicant)
                                @php
                                    $selection = $applicant->selections->first();
                                    $majorChoices = $applicant->majorChoices;
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $applicant->nama_lengkap }}</strong><br>
                                        <small class="text-muted">{{ $applicant->asal_sekolah }}</small>
                                    </td>
                                    <td>
                                        @if($applicant->staff && $applicant->staff->tanggal_wawancara)
                                            {{ \Carbon\Carbon::parse($applicant->staff->tanggal_wawancara)->translatedFormat('d F Y') }}<br>
                                            <span class="badge bg-info">{{ substr($applicant->staff->waktu_wawancara ?? '', 0, 5) }}</span>
                                        @else
                                            <span class="text-muted">Belum dijadwalkan</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($majorChoices->isNotEmpty())
                                            <div class="small">
                                                @foreach($majorChoices as $choice)
                                                    <div>
                                                        <span class="badge bg-secondary">{{ $choice->pivot->priority }}</span>
                                                        {{ $choice->nama }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-muted">Belum memilih</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('staff.selection.store', $applicant->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="number" name="nilai_ujian" step="0.01" min="0" max="100"
                                                   class="form-control form-control-sm" style="width:90px"
                                                   value="{{ old('nilai_ujian', $selection?->nilai_ujian) }}"
                                                   required>
                                    </td>
                                    <td>
                                            <input type="number" name="nilai_wawancara" step="0.01" min="0" max="100"
                                                   class="form-control form-control-sm" style="width:90px"
                                                   value="{{ old('nilai_wawancara', $selection?->nilai_wawancara) }}"
                                                   required>
                                    </td>
                                    <td class="text-center fw-bold">
                                        {{ $selection?->hasil_akhir ? number_format($selection->hasil_akhir, 2) : '-' }}
                                    </td>
                                    <td>
                                        @if($selection?->status)
                                            @php
                                                $statusColors = [
                                                    'lulus' => 'success',
                                                    'tidak_lulus' => 'danger',
                                                    'cadangan' => 'warning'
                                                ];
                                                $statusLabels = [
                                                    'lulus' => 'Lulus',
                                                    'tidak_lulus' => 'Tidak Lulus',
                                                    'cadangan' => 'Cadangan'
                                                ];
                                                $color = $statusColors[$selection->status] ?? 'secondary';
                                                $label = $statusLabels[$selection->status] ?? $selection->status;
                                            @endphp
                                            <span class="badge bg-{{ $color }}">
                                                {{ $label }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $pendaftaranColors = [
                                                'diterima' => 'success',
                                                'ditolak' => 'danger',
                                                'cadangan' => 'warning',
                                                'menunggu' => 'secondary',
                                                'diverifikasi' => 'info'
                                            ];
                                            $pendaftaranLabels = [
                                                'diterima' => 'Diterima',
                                                'ditolak' => 'Ditolak',
                                                'cadangan' => 'Cadangan',
                                                'menunggu' => 'Menunggu',
                                                'diverifikasi' => 'Diverifikasi'
                                            ];
                                            $color = $pendaftaranColors[$applicant->status_pendaftaran] ?? 'secondary';
                                            $label = $pendaftaranLabels[$applicant->status_pendaftaran] ?? $applicant->status_pendaftaran;
                                        @endphp
                                        <span class="badge bg-{{ $color }}">
                                            {{ $label }}
                                        </span>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-primary btn-sm w-100">
                                            <i class="fas fa-save me-1"></i>
                                            {{ $selection ? 'Update' : 'Simpan' }}
                                        </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
