<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB - SMK WIKRAMA BOGOR</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700,800,900&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css">
    <link rel="shortcut icon" href="https://placehold.co/16x16/1a73e8/white?text=W">

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    @stack('style')

    <style>
        /* Variabel Warna Korporat */
        :root {
            --primary-color: #108EE9;
            --primary-hover: #002FC7;
            --navy: #263F88;
            --yellow: #FFF508;
            --white: #FFFFFF;
            --muted: #6b7280;
            --shadow-sm: 0 6px 18px rgba(38, 63, 136, 0.08);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        /* --- Navbar Styling --- */
        .navbar-brand {
            font-weight: 800;
            color: var(--navy) !important;
        }

        .nav-link {
            font-size: 16px !important;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-hover) !important;
        }

        .btn-login-custom {
            background-color: var(--yellow) !important;
            color: #333 !important;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .btn-login-custom:hover {
            background-color: #ffd700 !important;
            box-shadow: 0 4px 10px rgba(255, 245, 8, 0.5);
        }

        .btn-outline-custom {
            border: 2px solid var(--navy);
            color: var(--navy);
            background-color: transparent;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-custom:hover {
            background-color: var(--navy);
            color: var(--white);
        }

        /* --- Global Sections & Typography --- */
        .section {
            padding: 80px 0;
        }

        .alt-section {
            background-color: #eef5ff;
        }

        .section-head h2 {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--navy);
        }

        .section-head p.lead {
            font-size: 1.15rem;
            color: #4b5563;
        }

        .accent {
            color: var(--primary-hover);
        }

        .border-start-5 {
            border-left-width: 5px !important;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top px-3 px-md-5">
        <div class="container-fluid">

            <img src="{{ asset('wikrama-logo.png') }}" alt="logo" class="ms-0" style="width: 45px; height: 45px;">
            <a class="navbar-brand fs-5 fw-bold ms-2" href="#">SMK WIKRAMA <br> BOGOR</a>

            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="{{ route('home') }}#home"><span>Beranda</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="{{ route('home') }}#visi-misi"><span>Visi & Misi</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="{{ route('home') }}#jurusan"><span>Jurusan</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="{{ route('home') }}#pancawaluya"><span>Keunggulan</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="{{ route('home') }}#kegiatan"><span>Kegiatan</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="{{ route('home') }}#kontak"><span>Kontak</span></a>
                    </li>
                </ul>

                <div class="d-flex gap-2 me-0">
                    <a href="{{ route('signup') }}" class="btn btn-outline-custom">Daftar</a>
                    <a href="{{ route('login') }}" class="btn btn-login-custom">Login</a>
                </div>

            </div>
        </div>
    </nav>

    @if (Session::get('failed'))
        <div class="alert alert-warning w-100 d-flex justify-content-end">{{ Session::get('failed') }}</b>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer id="kontak" class="text-center text-lg-start bg-dark text-white">
        <section class="container p-4">
            <div class="mt-5">
                <div class="row mt-3">
                    <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold mb-4 text-warning">
                            <img src="{{ asset('wikrama-logo.png') }}" alt="logo" class="me-2" style="width: 40px; height: 40px;">SMK Wikrama Bogor
                        </h6>
                        <p class="small text-muted">
                            Sekolah kejuruan yang berkomitmen mencetak pemimpin masa depan berkarakter Pancawaluya, berbasis teknologi informasi, dan siap bersaing di industri 4.0.
                        </p>
                    </div>
                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold mb-4 text-white">
                            Program Keahlian
                        </h6>
                        <p><a href="{{ route('home') }}#jurusan" class="text-reset">TI</a></p>
                        <p><a href="{{ route('home') }}#jurusan" class="text-reset">BISMEN</a></p>
                        <p><a href="{{ route('home') }}#jurusan" class="text-reset">PARISWISATA</a></p>
                        {{-- <p><a href="{{ route('home') }}#jurusan" class="text-reset">Teknik Listrik</a></p> --}}
                    </div>
                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold mb-4 text-white">
                            Informasi Cepat
                        </h6>
                        <p><a href="{{ route('home') }}#visi-misi" class="text-reset">Visi & Misi</a></p>
                        <p><a href="{{ route('home') }}#pancawaluya" class="text-reset">Keunggulan</a></p>
                        <p><a href="{{ route('signup') }}" class="text-reset">Pendaftaran PPDB</a></p>
                        <p><a href="#" class="text-reset">FAQ</a></p>
                    </div>
                    <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                        <h6 class="text-uppercase fw-bold mb-4 text-white">Hubungi Kami</h6>
                        <p><i class="fas fa-home me-3"></i> Jl. Raya Wangun, Kel. Sindangsari, Kec. Bogor Timur, Kota Bogor</p>
                        <p><i class="fas fa-envelope me-3"></i> info@smkwikrama.sch.id</p>
                        <p><i class="fas fa-phone me-3"></i> +62 251 8242411</p>
                    </div>
                    </div>
                </div>
        </section>
        <div class="text-center p-4 small" style="background-color: rgba(0, 0, 0, 0.2);">
            © <?= date('Y') ?> Copyright:
            <a class="text-reset fw-bold" href="#">SMK WIKRAMA BOGOR</a>
        </div>
        </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"
        integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.umd.min.js"></script>

    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>

    @stack('script')
</body>

</html>
