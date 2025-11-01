@extends('templates.app')

@section('content')
<div class="container mt-3 mb-5 p-5 rounded-5 text-white" style="background: linear-gradient(321.82deg, #002FC7 60.48%, #00218D 95.5%);">
    @if (Session::get('error'))
    <div class="alert alert-danger w-100">{{ Session::get('error') }}</div>
    @endif
    <div class="container-fluid">
        <form action="{{ route('signup.store') }}" method="POST">
            @csrf
            <label for="">Nama Lengkap Siswa</label>
            <input type="text" name="nama_lengkap"  value="{{ old('nama_lengkap') }}" class="mb-3 form-control">

            <div class="row">
                <div class="col-6">
                    <label for="">NISN</label>
                    <input type="number" name="nisn"  value="{{ old('nisn') }}" class="mb-3 form-control">
                </div>
                <div class="col-6">
                    <label for="">Jenis Kelamin</label>
                    <select name="jenis_kelamin"  value="{{ old('jenis_kelamin') }}" class="mb-3 form-select">
                        <option value="">Silahkan pilih</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
            </div>

            <label for="">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir"  value="{{ old('tanggal_lahir') }}" class="mb-3 form-control">

            <label for="">Asal Sekolah</label>
            <input type="text" name="asal_sekolah"  value="{{ old('asal_sekolah') }}" class="mb-3 form-control">

            <label for="">Alamat Email</label>
            <input type="email" name="alamat_email"  value="{{ old('alamat_email') }}" class="mb-3 form-control">

            <label for="">Alamat</label>
            <input type="text" name="alamat"  value="{{ old('alamat') }}" class="mb-3 form-control">

            <label for="">Nomor Telepone</label>
            <input type="number" name="nomor_telepon"  value="{{ old('nomor_telepon') }}" class="mb-3 form-control" placeholder="08xxxxxxxxxxx">

            <div class="row">
                <div class="col-6">
                    <label for="">Pekerjaan Ayah</label>
                    <input type="text" name="pekerjaan_ayah"  value="{{ old('pekerjaan_ayah') }}" class="mb-3 form-control">
                </div>
                <div class="col-6">
                    <label for="">Pekerjaan Ibu</label>
                    <input type="text" name="pekerjaan_ibu"  value="{{ old('pekerjaan_ibu') }}" class="mb-3 form-control">
                </div>
            </div>

            <label for="">Nomor Telepone Wali</label>
            <input type="number" name="nomor_telepon_wali"  value="{{ old('nomor_telepon_wali') }}" class="mb-3 form-control" placeholder="08xxxxxxxxxxx">

            <button class="btn" style="background: #FFF508" type="submit">Kirim</button>
        </form>
    </div>
</div>
@endsection
