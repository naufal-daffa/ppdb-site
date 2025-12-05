@extends('templates.app')

@section('content')
<div class="container w-50 mx-auto d-block my-5">
    <div class="card shadow-lg rounded-lg">
        <div class="card-body p-5">
            <h2 class="card-title text-center mb-4">Lupa Kata Sandi</h2>
            <p class="text-center text-muted mb-4">
                Masukkan alamat email Anda. Kami akan mengirimkan kata sandi baru yang dibuat secara otomatis ke email tersebut.
            </p>

            {{-- Menampilkan pesan sukses atau error dari Session --}}
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-block w-100 mb-4">
                    Kirim Kata Sandi Baru
                </button>
            </form>

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-decoration-none">Kembali ke Login</a>
            </div>
        </div>
    </div>
</div>
@endsection
