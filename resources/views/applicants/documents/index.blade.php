{{-- resources/views/applicants/documents.blade.php --}}

@extends('applicants.app')

@section('content')
    <div class="container my-5">
        <div class="w-75 mx-auto">
            <h4 class="text-center mb-5 fw-bold text-primary">Unggah Dokumen Persyaratan</h4>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('applicants.documents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">

                    @php
                        $fields = [
                            'kartu_keluarga' => ['label' => 'Kartu Keluarga (KK)', 'required' => true],
                            'akte_kelahiran' => ['label' => 'Akte Kelahiran', 'required' => true],
                            'ijazah' => ['label' => 'Ijazah Terakhir', 'required' => false],
                            'surat_kelulusan' => ['label' => 'Surat Keterangan Lulus (SKL)', 'required' => false],
                            'ktp_ayah' => ['label' => 'KTP Ayah', 'required' => false],
                            'ktp_ibu' => ['label' => 'KTP Ibu', 'required' => false],
                            'surat_kesehatan' => ['label' => 'Surat Keterangan Sehat', 'required' => false],
                        ];
                    @endphp

                    @foreach ($fields as $field => $info)
                        @php
                            $filePath = $applicant->document?->{$field} ?? null;
                            $hasFile = $filePath && Storage::disk('public')->exists($filePath);
                        @endphp
                        <div class="col-md-6">
                            <label class="form-label fw-medium">
                                {{ $info['label'] }}
                                @if ($info['required'])
                                    <span class="text-danger">*</span>
                                @endif
                            </label>

                            @if ($hasFile)
                                <div class="mb-2">
                                    <a href="{{ Storage::url($filePath) }}" target="_blank" class="btn btn-sm btn-success">
                                        Lihat Dokumen
                                    </a>
                                    <span class="badge bg-info ms-2">Sudah diunggah</span>
                                </div>
                            @endif

                            <input type="file" name="{{ $field }}"
                                class="form-control @error($field) is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                            @error($field)
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    @endforeach

                </div>

                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        Simpan Dokumen
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
