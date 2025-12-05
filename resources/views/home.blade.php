@extends('templates.app')

@push('style')
    <style>
        /* CSS Khusus untuk Home Page */

        /* --- HERO Styling --- */
        .hero {
            /* padding-top: 1px; */
            padding-bottom: 80px;
            min-height: 600px;
            background-image: linear-gradient(135deg, rgba(245, 245, 245, 0.5) 0%, rgba(255, 255, 255, 0.8) 100%);
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 900;
            line-height: 1.2;
            color: #000;
        }

        .hero .lead-text {
            font-size: 1.15rem;
            color: #4b5563;
        }

        .hero-image-container {
            width: 100%;
            max-width: 500px;
            height: 480px;
            /* Placeholder for actual image */
            background: url('https://via.placeholder.com/600x600?text=Foto+Siswa+SMK+Wikrama') center / cover no-repeat;
            border-radius: 18px;
            box-shadow: 0 15px 30px rgba(38, 63, 136, 0.2);
        }

        /* --- Visi Misi Styling --- */
        .card-vision-mission {
            transition: transform 0.3s ease;
        }

        .card-vision-mission:hover {
            transform: translateY(-5px);
        }

        /* --- Pancawaluya/Keunggulan Styling --- */
        .pancawaluya-card {
            background-color: var(--white);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .pancawaluya-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(16, 142, 233, 0.15);
        }

        /* --- Jurusan Styling --- */
        .major-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
            background-color: var(--white);
        }

        .major-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(16, 142, 233, 0.15) !important;
            border-color: var(--primary-color) !important;
        }

        .maj-icon {
            font-size: 2.5rem;
            margin-bottom: 0.75rem;
        }

        /* --- Kegiatan Styling --- */
        .kegiatan-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            height: 100%;
        }

        .kegiatan-card:hover {
            transform: translateY(-5px);
        }

        .kegiatan-card img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        /* --- CTA Styling --- */
        .cta-section {
            background: linear-gradient(90deg, var(--primary-hover), var(--navy));
            color: white;
            text-align: center;
            padding: 50px 0;
            border-radius: 15px;
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .cta-section a {
            background: var(--yellow);
            color: #333;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 800;
            font-size: 1.1rem;
            transition: background 0.3s ease;
        }

        .cta-section a:hover {
            background: #ffd700;
        }

        @media (max-width: 992px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero-image-container {
                height: 350px;
            }
        }

        @media (max-width: 768px) {
            .hero {
                min-height: auto;
            }

            .hero-image-container {
                display: none;
            }
        }
    </style>
@endpush

@section('content')
    <section id="home" class="container hero">
        <div class="">
            <div class="row align-items-center">
                <div class="col-md-7 col-lg-6 mb-4 mb-md-0">
                    <div class="hero-left">
                        <p class="text-uppercase fw-bold small" style="color: #696767; letter-spacing: 1.5px;">Telah dipercaya
                            lebih dari 10.000+ Orang Tua & Siswa</p>
                        <h1>MEMBENTUK <span class="accent">PEMIMPIN</span><br> MASA DEPAN</h1>
                        <p class="lead-text mt-3">Ayo! Segera daftarkan dirimu ke **SMK Wikrama Bogor** — Sekolah vokasi
                            unggul yang mencetak generasi berkarakter, terampil, dan siap kerja.</p>
                        <div class="hero-actions mt-4">
                            <a class="btn btn-login-custom btn-lg shadow-2" href="{{ route('signup') }}">Pendaftaran
                                PPDB</a>
                            <a class="btn btn-outline-custom btn-lg ms-3" href="#jurusan">Lihat Program Sekolah</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-lg-6 d-none d-md-flex justify-content-center">

                    <img class="hero-image-container"
                        src="https://www.smadwiwarna.sch.id/wp-content/uploads/2023/11/sekolah-unggulan-di-bogor.jpg"
                        alt="">
                </div>
            </div>
        </div>
    </section>

    <section id="visi-misi" class="section alt-section">
        <div class="container">
            <div class="section-head text-center mb-5">
                <h2 class="fw-bold">Visi & Misi Kami</h2>
                <p class="muted lead">Fondasi kami dalam membentuk generasi penerus bangsa yang unggul.</p>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card card-vision-mission p-4 h-100 border-top border-4 border-warning shadow-3">
                        <div class="icon text-warning mb-3"><i class="fas fa-eye fa-2x"></i></div>
                        <h3 class="fw-bold text-warning">Visi</h3>
                        <p>Menjadi sekolah kejuruan **teladan nasional** yang berbudaya lingkungan, berkarakter sesuai
                            profil pelajar pancasila, berbasis teknologi informasi, dan mampu memenuhi kebutuhan industri
                            4.0</p>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card card-vision-mission p-4 h-100 border-top border-4 border-primary shadow-3">
                        <div class="icon text-primary mb-3"><i class="fas fa-rocket fa-2x"></i></div>
                        <h3 class="fw-bold text-primary">Misi</h3>
                        <ol class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle me-2 text-success"></i>Mewujudkan sekolah
                                sebagai benteng moralitas bangsa.</li>
                            <li class="mb-2"><i class="fas fa-check-circle me-2 text-success"></i>Mendidik anak bangsa
                                dengan hati dan teknologi sehingga memenuhi kebutuhan mutu dunia kerja.</li>
                            <li class="mb-2"><i class="fas fa-check-circle me-2 text-success"></i>Membangun kebersamaan
                                sosial, jiwa kewirausahaan, dan gerakan cinta tanah air.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="pancawaluya" class="section white-section">
        <div class="container">
            <div class="section-head text-center mb-5">
                <h2 class="fw-bold">Kenapa Harus Memilih SMK Wikrama?</h2>
                <p class="muted lead">Kami menerapkan 5 nilai karakter utama yang kami sebut **Pancawaluya** dalam setiap
                    kegiatan siswa.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="pancawaluya-card border-top border-4 border-danger">
                        <div class="icon text-danger mb-2"><i class="fas fa-heartbeat fa-3x"></i></div>
                        <h5 class="fw-bold">1. Cageur</h5>
                        <p class="small text-muted mb-0">(Sehat Lahir Batin) Menjaga fisik dan mental siswa agar siap
                            belajar dan berkarya.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="pancawaluya-card border-top border-4 border-success">
                        <div class="icon text-success mb-2"><i class="fas fa-hand-holding-heart fa-3x"></i></div>
                        <h5 class="fw-bold">2. Bageur</h5>
                        <p class="small text-muted mb-0">(Berakhlak Baik) Pembentukan karakter sosial, etika, dan kepedulian
                            yang tinggi.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="pancawaluya-card border-top border-4 border-primary">
                        <div class="icon text-primary mb-2"><i class="fas fa-shield-alt fa-3x"></i></div>
                        <h5 class="fw-bold">3. Bener</h5>
                        <p class="small text-muted mb-0">(Jujur dan Benar) Mendidik siswa menjunjung tinggi integritas,
                            kejujuran, dan kebenaran.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="pancawaluya-card border-top border-4 border-warning">
                        <div class="icon text-warning mb-2"><i class="fas fa-lightbulb fa-3x"></i></div>
                        <h5 class="fw-bold">4. Pinter</h5>
                        <p class="small text-muted mb-0">(Cerdas) Menciptakan lingkungan belajar yang mendorong kecerdasan
                            akademik dan emosional.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="pancawaluya-card border-top border-4 border-info">
                        <div class="icon text-info mb-2"><i class="fas fa-tools fa-3x"></i></div>
                        <h5 class="fw-bold">5. Singer</h5>
                        <p class="small text-muted mb-0">(Terampil) Fokus pada keahlian vokasi dan keterampilan praktis yang
                            dibutuhkan industri.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="jurusan" class="section alt-section">
        <div class="container">
            <div class="section-head text-center mb-5">
                <h2 class="fw-bold">Program Keahlian Unggulan</h2>
                <p class="muted lead">Pilih jurusan yang sesuai minat dan bakat Anda untuk masa depan karir yang pasti.</p>
            </div>

            <div class="row">
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="major-card p-3 shadow-hover">
                        <div class="maj-icon text-primary"><i class="fas fa-code"></i></div>
                        <h5 class="fw-bold mt-2">TI</h5>
                        <p class="text-muted small">Pengembangan, pengelolaan, dan penerapan teknologi untuk memecahkan masalah di berbagai bidang, terutama bisnis..</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="major-card p-3 shadow-hover">
                        <div class="maj-icon" style="color: #ffc107;"><i class="fas fa-palette"></i></div>
                        <h5 class="fw-bold mt-2">Bismen</h5>
                        <p class="text-muted small">Analisis, perencanaan, dan pengoperasian bisnis secara menyeluruh, mulai dari skala kecil hingga besar..</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="major-card p-3 shadow-hover">
                        <div class="maj-icon text-success"><i class="fas fa-cogs"></i></div>
                        <h5 class="fw-bold mt-2">Pariwisata</h5>
                        <p class="text-muted small">Mempelajari segala aspek industri perjalanan wisata, mulai dari manajemen destinasi dan perhotelan, perencanaan perjalanan, hingga pemasaran dan penyelenggaraan acara seperti MICE (Meetings, Incentives, Conferences, Exhibitions). .</p>
                    </div>
                </div>

                {{-- <div class="col-md-6 col-lg-3 mb-4">
                    <div class="major-card p-3 shadow-hover">
                        <div class="maj-icon text-danger"><i class="fas fa-bolt"></i></div>
                        <h5 class="fw-bold mt-2">Teknik Listrik</h5>
                        <p class="text-muted small">Instalasi dan pemeliharaan sistem kelistrikan bangunan/industri.</p>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>

    <section id="kegiatan" class="section white-section">
        <div class="container">
            <div class="section-head text-center mb-5">
                <h2 class="fw-bold">Kegiatan dan Ekstrakurikuler</h2>
                <p class="muted lead">Mengembangkan minat dan bakat di luar jam pelajaran resmi.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="kegiatan-card bg-white">
                        <img src="https://via.placeholder.com/400x200?text=Pramuka" alt="Kegiatan Pramuka">
                        <div class="p-3">
                            <h5 class="fw-bold">Pramuka Wajib</h5>
                            <p class="small text-muted mb-0">Pembentukan karakter disiplin dan kepemimpinan melalui
                                kegiatan kepramukaan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="kegiatan-card bg-white">
                        <img src="https://via.placeholder.com/400x200?text=Olahraga" alt="Ekstrakurikuler Olahraga">
                        <div class="p-3">
                            <h5 class="fw-bold">Olahraga & Seni</h5>
                            <p class="small text-muted mb-0">Eskul Futsal, Basket, Band, dan Tari untuk menyalurkan bakat
                                non-akademik.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="kegiatan-card bg-white">
                        <img src="https://via.placeholder.com/400x200?text=Pengembangan+IT" alt="Kegiatan IT">
                        <div class="p-3">
                            <h5 class="fw-bold">Klub Pemrograman</h5>
                            <p class="small text-muted mb-0">Mengasah skill coding dan problem solving di luar kurikulum
                                jurusan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="video" class="section alt-section">
        <div class="container">
            <div class="section-head text-center mb-5">
                <h2 class="fw-bold">Tonton Sekilas Tentang Kami</h2>
                <p class="muted lead">Kenali lebih dekat SMK Wikrama Bogor melalui video profil resmi.</p>
            </div>

            <div class="video-frame shadow-5 rounded-3 overflow-hidden mx-auto" style="max-width: 900px;">
                <iframe width="100%" height="300" src="https://www.youtube.com/embed/FnBtV3X3kkw?si=nm_uFBhMhKtNgR-z" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
    </section>

    <section id="daftar" class="container">
        <div class="cta-section shadow-5-strong">
            <h3 class="fw-bold mb-3">Siap bergabung dengan SMK Wikrama Bogor?</h3>
            <p class="lead mb-4">Wujudkan masa depan cerah bersama kami. Daftar sekarang juga!</p>
            <a href="{{ route('signup') }}">Mulai Pendaftaran Sekarang <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
    </section>
@endsection
