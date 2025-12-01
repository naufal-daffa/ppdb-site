<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMPB SMK WIKRAMA BOGOR</title>
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
    @stack('style')
    <style>
        :root {
            --sidebar-width: 250px;
            --sidebar-bg: #ffffff;
            --sidebar-color: #2c3e50;
            --sidebar-hover: #f8f9fa;
            --sidebar-active: #e9ecef;
            --border-color: #eaeaea;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            overflow-x: hidden;
        }

        .sidebar {
            min-height: 100vh;
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            color: var(--sidebar-color);
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid var(--border-color);
            text-align: center;
        }

        .sidebar-header h4 {
            margin: 0;
            font-weight: 600;
            color: #000;
        }

        .sidebar .nav-link {
            color: var(--sidebar-color);
            padding: 0.75rem 1.5rem;
            margin: 0.2rem 0.5rem;
            border-radius: 8px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .sidebar .nav-link:hover {
            background-color: var(--sidebar-hover);
            color: #3498db;
        }

        .sidebar .nav-link.active {
            background-color: var(--sidebar-active);
            color: #3498db;
            border-left: 4px solid #3498db;
        }

        .sidebar .nav-item {
            margin-bottom: 0.2rem;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: all 0.3s;
            min-height: 100vh;
        }

        .top-navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 0.8rem 1.5rem;
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #2c3e50;
            cursor: pointer;
            display: none;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #3498db;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-weight: bold;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
            margin-bottom: 20px;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
            padding: 1rem 1.25rem;
        }

        .stat-card {
            text-align: center;
            padding: 1.5rem;
        }

        .stat-card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #3498db;
        }

        .stat-card h3 {
            font-size: 2rem;
            margin: 10px 0;
            color: #2c3e50;
        }

        .stat-card p {
            color: #7f8c8d;
            margin: 0;
        }

        /* Untuk sidebar yang bisa disembunyikan */
        @media (max-width: 992px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            .sidebar.show {
                margin-left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .main-content.sidebar-hidden {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: block;
            }
        }

        .footer {
            text-align: center;
            padding: 20px;
            margin-top: 40px;
            color: #7f8c8d;
            border-top: 1px solid var(--border-color);
        }
    </style>
    @stack('style')
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <div class="d-flex">
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('wikrama-logo.png') }}" width="70px" class="mb-4">
                </div>
            </div>
            <h5>SMK Wikrama Bogor</h5>
        </div>

        <div class="position-sticky pt-3 overflow-y-auto">
            <ul class="nav flex-column">
                <div class="overflow-y-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('staff.dashboard') }}">
                            <i class="bi bi-house"></i>
                            Dashboard Staff
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('staff.applicants.home') }}">
                            <i class="bi bi-house"></i>
                            Pendaftar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('staff.applicants.home') }}">
                            <i class="bi bi-house"></i>
                            Dokumen
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('staff.applicants.home') }}">
                            <i class="bi bi-house"></i>
                            Bukti Pembayaran
                        </a>
                    </li>
                    {{--
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.skill-fields.index') }}">
                            <i class="bi bi-house"></i>
                            Bidang Keahlian
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.majors.index') }}">
                            <i class="bi bi-house"></i>
                            Jurusan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.registrasion-waves.index') }}">
                            <i class="bi bi-house"></i>
                            Gelombang
                        </a>
                    </li> --}}
                    <li class="nav-item mt-1">
                        <a class="nav-link" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            Logout
                        </a>
                    </li>
                </div>
            </ul>
        </div>
    </nav>
    @if (Session::get('failed'))
        <div class="alert alert-warning w-100 d-flex justify-content-end">{{ Session::get('failed') }}</b>
        </div>
    @endif
    <!-- Main Content -->

    <div class="main-content">
        <div class="container mt-5">
            {{-- <div class="d-flex gap-3">
                <a href="{{ route('staff.applicants.home') }}" class="text-info">Bukti Pembayaran</a>
                <a href="" class="text-info">Dokumen</a>
            </div> --}}
        </div>
        @yield('content')
    </div>
    <div class="footer">
        <p>&copy; 2023 MyApp Dashboard. All rights reserved.</p>
    </div>
    </div>

    @stack('script')
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

</body>

</html>
