<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB</title>

        <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB UI Kit -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.min.css" rel="stylesheet" />
    <!-- Favicon -->
    {{-- CDN CSS datatables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css">
    <link rel="shortcut icon" href="https://media.licdn.com/dms/image/v2/C510BAQGcQObmC5ADzw/company-logo_200_200/company-logo_200_200/0/1630582740922/tix_id_logo?e=2147483647&v=beta&t=y7u2Lvw4QGrKw64ZYzcBTp34x8Ih-c1-dy_-m9NV4W4">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('wikrama-logo.png') }}">
    @stack('style')
    <style>

        :root {
            --primary-color: #108EE9;
            --primary-hover: #002FC7;
        }


        body {
            font-family: 'Poppins', sans-serif;
        }

        /* .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        } */

        .nav-link {
            font-size: 18px !important;
        }

        .nav-link:hover {
            color: var(--primary-hover) !important;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(16, 142, 233, 0.25);
        }

        .btn-login-custom {
            background-color: #FFF508;
        }

        .btn-login-custom:hover {
            background-color: #FFF508;
        }

        .btn-outline-custom {
            border: 2px solid #FFF508;
            background-color: transparent;
            /* transition: all 0.3s ease; */
        }

        .btn-outline-custom:hover {
            background-color: #FFF508;
            color: #000;
            /* agar teks tetap terbaca saat hover */
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top justify-align-center px-5">
        <div class="container-fluid">

            <!-- Brand -->
            <img src="{{ asset('wikrama-logo.png') }}" alt="logo" class="ms-4" style="width: 50px; height: 50px;">
            <a class="navbar-brand fs-5 fw-bold ms-3" href="#">SMK WIKRAMA <br> BOGOR</a>

            <!-- Mobile toggle button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Collapsible content -->
            <div class="collapse justify-align-center px-5 navbar-collapse" id="navbarNav">

                <!-- Navigation links - Left side -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 px-3" href="{{ route('home') }}">
                            {{-- <i class="fas fa-home"></i> --}}
                            <span>Beranda</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 px-3" href="#">
                            {{-- <i class="fas fa-film"></i> --}}
                            <span>Tentang Kami</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 px-3" href="#">
                            <span>Jurusan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 px-3" href="#">
                            {{-- <i class="fas fa-film"></i> --}}
                            <span>Testimoni</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 px-3" href="#">
                            <span>Kontak</span>
                        </a>
                    </li>
                </ul>


                {{-- <div class="d-flex justify-content-center flex-grow-1 mx-3">
                    <div class="input-group" style="max-width: 400px;">
                        <input type="search" class="form-control border-end-0"
                               placeholder="Cari film, bioskop, atau lokasi..." aria-label="Search">
                        <button class="btn btn-outline-secondary border-start-0 bg-white" type="button">
                            <i class="fas fa-search text-muted"></i>
                        </button>
                    </div>
                </div> --}}

                <div class="d-flex gap-2 me-4">
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
    <!-- Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="text-center text-lg-start bg-body-tertiary text-muted">
        <!-- Section: Social media -->
        {{-- <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
            <!-- Left -->
            <div class="me-5 d-none d-lg-block">
                <span>Get connected with us on social networks:</span>
            </div>
            <!-- Left -->

            <!-- Right -->
            <div>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-google"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-github"></i>
                </a>
            </div>
            <!-- Right -->
        </section> --}}
        <!-- Section: Social media -->

        <!-- Section: Links  -->
        <section class="container">
            <div class="mt-5">
                <!-- Grid row -->
                <div class="row mt-3">
                    <!-- Grid column -->
                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                        <!-- Content -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            <img src="{{ asset('wikrama-logo.png') }}" alt="logo" class="" style="width: 60px; height: 60px;">SMK Wikrama
                        </h6>
                        <p>
                            Here you can use rows and columns to organize your footer content. Lorem ipsum
                            dolor sit amet, consectetur adipisicing elit.
                        </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            Products
                        </h6>
                        <p>
                            <a href="#!" class="text-reset">Angular</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">React</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Vue</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Laravel</a>
                        </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            Useful links
                        </h6>
                        <p>
                            <a href="#!" class="text-reset">Pricing</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Settings</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Orders</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Help</a>
                        </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
                        <p><i class="fas fa-home me-3"></i> New York, NY 10012, US</p>
                        <p>
                            <i class="fas fa-envelope me-3"></i>
                            info@example.com
                        </p>
                        <p><i class="fas fa-phone me-3"></i> + 01 234 567 88</p>
                        <p><i class="fas fa-print me-3"></i> + 01 234 567 89</p>
                    </div>
                    <!-- Grid column -->
                </div>
                <!-- Grid row -->
            </div>
        </section>
        <!-- Section: Links  -->

        <!-- Copyright -->
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            © <?= date('Y') ?> Copyright:
            <a class="text-reset fw-bold" href="#">SMK WIKRAMA BOGOR</a>
        </div>
        <!-- Copyright -->
    </footer>
    <!-- Footer -->
    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"
        integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.umd.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.js"></script> --}}
    {{-- CDN JS datatables  --}}
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>

    @stack('script')
</body>

</html>
