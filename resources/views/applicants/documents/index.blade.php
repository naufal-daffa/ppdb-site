{{-- resources/views/applicants/documents.blade.php --}}

@extends('applicants.app')

@section('content')
<div class="container my-5">
    <div class="w-75 mx-auto">
        <h4 class="text-center mb-5 fw-bold">Unggah Dokumen Persyaratan</h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">

                <!-- Kartu Keluarga -->
                <div class="col-md-6">
                    <label class="form-label fw-medium">Kartu Keluarga (KK) <span class="text-danger">*</span></label>
                    <input type="file" name="kartu_keluarga" class="form-control @error('kartu_keluarga') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                    @error('kartu_keluarga')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Akte Kelahiran -->
                <div class="col-md-6">
                    <label class="form-label fw-medium">Akte Kelahiran <span class="text-danger">*</span></label>
                    <input type="file" name="akte_kelahiran" class="form-control @error('akte_kelahiran') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                    @error('akte_kelahiran')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Ijazah -->
                <div class="col-md-6">
                    <label class="form-label fw-medium">Ijazah Terakhir</label>
                    <input type="file" name="ijazah" class="form-control @error('ijazah') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                    @error('ijazah')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Surat Kelulusan / SKL -->
                <div class="col-md-6">
                    <label class="form-label fw-medium">Surat Keterangan Lulus (SKL)</label>
                    <input type="file" name="surat_kelulusan" class="form-control @error('surat_kelulusan') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                    @error('surat_kelulusan')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- KTP Ayah -->
                <div class="col-md-6">
                    <label class="form-label fw-medium">KTP Ayah</label>
                    <input type="file" name="ktp_ayah" class="form-control @error('ktp_ayah') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                    @error('ktp_ayah')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- KTP Ibu -->
                <div class="col-md-6">
                    <label class="form-label fw-medium">KTP Ibu</label>
                    <input type="file" name="ktp_ibu" class="form-control @error('ktp_ibu') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                    @error('ktp_ibu')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Surat Kesehatan -->
                <div class="col-md-6">
                    <label class="form-label fw-medium">Surat Keterangan Sehat</label>
                    <input type="file" name="surat_kesehatan" class="form-control @error('surat_kesehatan') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                    @error('surat_kesehatan')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

            </div>

            <div class="text-center mt-5">
                <button type="submit" class="btn btn-primary btn-lg px-5">Simpan & Lanjutkan</button>
            </div>
        </form>
    </div>
</div>
@endsection
