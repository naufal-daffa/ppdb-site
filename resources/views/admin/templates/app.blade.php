<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMPB SMK WIKRAMA BOGOR - Dashboard</title>
    <!-- Font Awesome (v6) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts - Inter (Modern, professional font) -->
    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- MDB UI Kit (v9.1.0) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.min.css" rel="stylesheet" />
    <!-- CDN CSS datatables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css">
    <!-- Favicon Placeholder (Menggunakan logo sekolah) -->
    <link rel="shortcut icon" href="https://placehold.co/16x16/007bff/white?text=W">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    @stack('style')

    <style>
        /* Menggunakan Inter Font Family */
        :root {
            --sidebar-width: 280px;
            --primary-blue: #1a73e8; /* Blue yang lebih elegan */
            --primary-dark: #2c3e50;
            --sidebar-bg: #ffffff;
            --sidebar-hover-bg: #f3f6ff; /* Light blue tint on hover */
            --sidebar-active-bg: #e5edff; /* More distinct active background */
            --border-color: #e0e6f0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc; /* Background lebih cerah */
            overflow-x: hidden;
        }

        /* Styling Sidebar */
        .sidebar {
            height: 100vh;
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            color: var(--primary-dark);
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.08); /* Shadow yang lebih lembut */
            transition: margin-left 0.3s;
            z-index: 1050;
            padding-bottom: 20px;
        }

        .sidebar-header {
            padding: 1.5rem 1rem 1rem 1rem;
            border-bottom: 1px solid var(--border-color);
            text-align: center;
        }

        .sidebar-header img {
            max-width: 80px;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header h5 {
            margin-top: 10px;
            font-weight: 700;
            color: var(--primary-dark);
        }

        .sidebar .nav-link {
            color: var(--primary-dark);
            padding: 0.8rem 1.5rem;
            margin: 0.25rem 0.75rem;
            border-radius: 10px; /* Sudut lebih membulat */
            transition: all 0.2s;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .sidebar .nav-link i {
            margin-right: 15px;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
            color: #6c757d; /* Default icon color */
        }

        .sidebar .nav-link:hover {
            background-color: var(--sidebar-hover-bg);
            color: var(--primary-blue);
        }

        .sidebar .nav-link:hover i {
            color: var(--primary-blue);
        }

        .sidebar .nav-link.active {
            background-color: var(--sidebar-active-bg);
            color: var(--primary-blue);
            font-weight: 600;
            /* Border-left diganti dengan box-shadow */
            box-shadow: inset 3px 0 0 0 var(--primary-blue);
        }

        .sidebar .nav-link.active i {
            color: var(--primary-blue);
        }

        /* Styling Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px 30px;
            transition: margin-left 0.3s;
            min-height: 100vh;
        }

        .top-navbar {
            background-color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 0.8rem 1.5rem;
            margin-bottom: 25px;
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--primary-dark);
            cursor: pointer;
            display: none;
        }

        .user-info .dropdown-toggle {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--primary-dark);
            font-weight: 500;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-blue);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-weight: bold;
            font-size: 1.1rem;
        }

        /* Card Modern Look */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 25px;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
            padding: 1.25rem 1.5rem;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            color: var(--primary-dark);
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 20px 30px;
            margin-top: auto; /* Push footer to the bottom */
            color: #7f8c8d;
            font-size: 0.9rem;
            border-top: 1px solid var(--border-color);
            background-color: white;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.03);
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s;
        }

        /* Alert Styling */
        .custom-alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1060;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            .sidebar.show {
                margin-left: 0;
            }

            .main-content {
                margin-left: 0;
                padding: 15px;
            }

            .footer {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: block;
            }
        }
    </style>
    @stack('style')
</head>

<body>
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="logoutModalLabel"><i class="fas fa-exclamation-triangle"></i> Konfirmasi Logout</h5>
                    <button type="button" class="btn-close btn-close-white" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Yakin mau Logout? Anda akan diarahkan ke halaman login.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Batal</button>
                    <a href="{{ route('logout') }}" id="confirmLogoutBtn" class="btn btn-danger">Ya, Logout</a>
                </div>
            </div>
        </div>
    </div>

    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            {{-- <div class="d-flex justify-content-center">
                <!-- Placeholder untuk logo, menggunakan URL placeholder -->
                <img src="https://placehold.co/80x80/007bff/white?text=WK" alt="Logo Wikrama" class="mb-3">
            </div> --}}
            <h5>SMK Wikrama Bogor</h5>
            <small class="text-muted">Aplikasi SMPB</small>
        </div>

        <div class="pt-4 overflow-y-auto">
            <ul class="nav flex-column px-2">
                <!-- Dashboard -->
                <li class="nav-item">
                    <!-- ICON FIX: bi bi-house -> fa-chart-line -->
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-chart-line"></i>
                        Dashboard
                    </a>
                </li>
                <!-- Pendaftar -->
                <li class="nav-item">
                    <!-- ICON FIX: bi bi-house -> fa-users -->
                    <a class="nav-link" href="{{ route('admin.applicants.index') }}">
                        <i class="fas fa-users"></i>
                        Pendaftar
                    </a>
                </li>
                <!-- Staff -->
                <li class="nav-item">
                    <!-- ICON FIX: bi bi-house -> fa-user-tie -->
                    <a class="nav-link" href="{{ route('admin.staff.index') }}">
                        <i class="fas fa-user-tie"></i>
                        Penjadwalan Wawancara
                    </a>
                </li>
                <!-- Users -->
                <li class="nav-item">
                    <!-- ICON FIX: bi bi-house -> fa-user-group -->
                    <a class="nav-link" href="{{ route('admin.users.index') }}">
                        <i class="fas fa-user-group"></i>
                        Users
                    </a>
                </li>
                <hr class="mx-4 my-2 text-muted" />
                <!-- Bidang Keahlian -->
                <li class="nav-item">
                    <!-- ICON FIX: bi bi-house -> fa-screwdriver-wrench -->
                    <a class="nav-link" href="{{ route('admin.skill-fields.index') }}">
                        <i class="fas fa-screwdriver-wrench"></i>
                        Bidang Keahlian
                    </a>
                </li>
                <!-- Jurusan -->
                <li class="nav-item">
                    <!-- ICON FIX: bi bi-house -> fa-graduation-cap -->
                    <a class="nav-link" href="{{ route('admin.majors.index') }}">
                        <i class="fas fa-graduation-cap"></i>
                        Jurusan
                    </a>
                </li>
                <!-- Gelombang -->
                <li class="nav-item">
                    <!-- ICON FIX: bi bi-house -> fa-calendar-alt -->
                    <a class="nav-link" href="{{ route('admin.registrasion-waves.index') }}">
                        <i class="fas fa-calendar-alt"></i>
                        Gelombang
                    </a>
                </li>
                <!-- Jalur Masuk -->
                <li class="nav-item">
                    <!-- ICON FIX: bi bi-house -> fa-road -->
                    <a class="nav-link" href="{{ route('admin.admission-paths.index') }}">
                        <i class="fas fa-route"></i>
                        Jalur Masuk
                    </a>
                </li>
                <hr class="mx-4 my-2 text-muted" />
                <!-- Logout (Menggunakan data-mdb-toggle untuk modal) -->
                <li class="nav-item mt-1">
                    <a class="nav-link text-danger" href="{{ route('logout') }}" data-mdb-toggle="modal" data-mdb-target="#logoutModal">
                        <!-- ICON FIX: bi bi-box-arrow-right -> fa-sign-out-alt -->
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content Wrapper -->
    <div class="main-content d-flex flex-column">

        <!-- Top Navbar (MDB/Bootstrap) -->
        {{-- <nav class="top-navbar d-flex justify-content-between align-items-center">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <h4 class="h5 mb-0 text-primary d-none d-sm-block">SMK Wikrama Bogor</h4>

            <!-- User Info Dropdown Placeholder -->
            <div class="dropdown">
                <a class="dropdown-toggle user-info" href="#" id="navbarDropdownMenuLink" role="button"
                    data-mdb-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar">AD</div>
                    <span class="d-none d-lg-inline me-2">Admin User</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-user-circle me-2"></i> Profil
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-cog me-2"></i> Pengaturan
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item text-danger" href="#" data-mdb-toggle="modal" data-mdb-target="#logoutModal">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav> --}}

        <!-- Session Alert Handling (Moved and Styled) -->
        @if (Session::get('failed'))
            <div class="alert alert-warning custom-alert alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> {{ Session::get('failed') }}
                <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Content Section -->
        <div>
            @yield('content')
        </div>


        <!-- Footer -->
        <div class="footer mt-auto">
            <p class="mb-0">&copy; {{ date('Y') }} Aplikasi Penerimaan Siswa Baru (SMPB) SMK Wikrama Bogor. Hak Cipta Dilindungi.</p>
        </div>
    </div>


    @stack('script')
    <!-- MDB & Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"
        xintegrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        xintegrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <!-- Datatables JS -->
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>

    <script>
        // JavaScript untuk Toggle Sidebar Responsif
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const toggleButton = document.getElementById('sidebarToggle');
            const mainContent = document.querySelector('.main-content');
            const footer = document.querySelector('.footer');

            if (toggleButton) {
                toggleButton.addEventListener('click', function () {
                    sidebar.classList.toggle('show');

                    if (window.innerWidth < 992) {
                        document.body.classList.toggle('sidebar-open');
                    }
                });
            }

            // Optional: Sembunyikan sidebar saat mengklik di luar di mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth < 992 && sidebar.classList.contains('show') &&
                    !sidebar.contains(event.target) && !toggleButton.contains(event.target)) {
                    sidebar.classList.remove('show');
                    document.body.classList.remove('sidebar-open');
                }
            });
        });
    </script>

</body>

</html>
