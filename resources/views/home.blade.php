@extends('templates.app')
@push('style')
    <style>
        :root {
            --white: #FFFFFF;
            --navy: #263F88;
            --yellow: #FFF508;
            --blue: #002FC7;
            --muted: #6b7280;
            --radius: 12px;
            --glass: rgba(255, 255, 255, 0.06);
            --max-width: 1100px;
            /* --container-padding: 1.25rem; */
            --shadow-sm: 0 6px 18px rgba(38, 63, 136, 0.08);
        }

        * {
            box-sizing: border-box
        }

        html {
            scroll-behavior: smooth
        }
        .btn-outline-custom {
            border: 2px solid #;
            background-color: transparent;
            /* transition: all 0.3s ease; */
        }
        /* HERO */
        .hero {
            padding-top: 84px;
            padding-bottom: 48px;
            position: relative;
            overflow: hidden
        }

        /* .hero-bg {
            position: absolute;
            inset: 0;
            z-index: 0
        } */

        /* .hero-gradient {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--navy) 0%, var(--blue) 60%);
            opacity: 0.12;
        } */

        .hero-deco {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 120%;
            height: 160px;
            opacity: 0.35;
            pointer-events: none
        }

        .hero-inner {
            display: flex;
            gap: 2rem;
            align-items: center;
            min-height: 440px;
            position: relative;
            z-index: 2;
            padding-top: 2rem;
            padding-bottom: 2rem
        }

        .hero-left {
            flex: 1;
            max-width: 640px
        }

        .hero-right {
            flex: 1;
            display: flex;
            justify-content: center
        }

        h1 {
            /* font-size: 2rem; */
            margin: 0 0 0.6rem 0;
            color: #000000;
            font-weight: 700
        }

        .accent {
            color: var(--blue)
        }

        .lead {
            color: var(--muted);
            margin-bottom: 1rem
        }

        .hero-actions {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1rem
        }

        .btn-primary {
            background: var(--navy);
            color: white;
            padding: 0.6rem 0.95rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600
        }

        .btn-outline {
            border: 2px solid var(--navy);
            padding: 0.52rem 0.9rem;
            border-radius: 10px;
            text-decoration: none;
            color: var(--navy);
            font-weight: 600
        }

        .hero-features {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
            color: var(--muted);
            list-style: none;
            padding: 0
        }

        /* spotlight image */
        .card-spotlight {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.7), rgba(255, 255, 255, 0.85));
            border-radius: 14px;
            padding: 10px;
            box-shadow: var(--shadow-sm);
            width: 100%;
            max-width: 520px
        }

        .card-spotlight img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            display: block
        }

        .card-badge {
            position: relative;
            margin-top: 8px;
            background: var(--yellow);
            display: inline-block;
            padding: 6px 10px;
            border-radius: 8px;
            font-weight: 700;
            color: #111
        }

        /* sections */
        .section {
            padding: 56px 0
        }

        .white-section {
            background: var(--white)
        }

        .alt-section {
            background: linear-gradient(180deg, rgba(2, 47, 199, 0.03), rgba(255, 255, 255, 0.0));
        }

        /* section head */
        .section-head {
            margin-bottom: 1.25rem
        }

        .section-head h2 {
            margin: 0;
            font-size: 1.25rem;
            color: var(--navy)
        }

        .section-head p.muted {
            margin: 0;
            color: var(--muted)
        }

        /* cards and grids */
        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem
        }

        .card {
            background: var(--white);
            padding: 1rem;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(2, 47, 199, 0.04)
        }

        .card.small {
            text-align: center;
            padding: 1.25rem
        }

        .icon {
            font-size: 28px;
            margin-bottom: 0.5rem
        }

        .majors-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem
        }

        .major-card {
            display: flex;
            gap: 0.9rem;
            align-items: flex-start;
            padding: 1rem;
            border-radius: 12px;
            background: linear-gradient(180deg, rgba(255, 245, 0, 0.04), rgba(255, 255, 255, 0.02));
            box-shadow: none
        }

        .maj-icon {
            font-size: 32px
        }

        /* testimonials */
        .testimonial-wrap {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative
        }

        .testimonial-slider {
            overflow: hidden;
            flex: 1;
            position: relative
        }

        .testi-slide {
            position: absolute;
            inset: 0;
            padding: 1.25rem;
            border-radius: 12px;
            background: var(--white);
            display: none;
            align-items: center;
            gap: 1rem;
            flex-direction: column;
            box-shadow: var(--shadow-sm)
        }

        .testi-slide.active {
            display: flex
        }

        .avatar {
            width: 84px;
            height: 84px;
            border-radius: 999px;
            object-fit: cover;
            margin-bottom: 0.6rem
        }

        .t-prev,
        .t-next {
            background: var(--navy);
            color: white;
            border: 0;
            padding: 0.6rem 0.9rem;
            border-radius: 10px;
            cursor: pointer
        }

        .dots {
            display: flex;
            gap: .45rem;
            justify-content: center;
            margin-top: 1rem
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            border: 0;
            background: #e5e7eb;
            cursor: pointer
        }

        .dot.active {
            background: var(--navy)
        }

        /* video frame */
        .video-frame {
            max-width: 900px;
            margin: 0 auto;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            background: #000
        }

        .video-frame iframe {
            width: 100%;
            height: 480px;
            border: 0;
            display: block
        }

        /* CTA */
        .cta-section {
            background: linear-gradient(90deg, var(--blue), var(--navy));
            color: white;
            text-align: center;
            padding: 36px 0;
            border-radius: 8px
        }

        .cta-section a {
            color: var(--navy);
            background: var(--yellow);
            padding: 0.5rem 0.9rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700
        }

        /* footer */
        .footer {
            background: var(--navy);
            color: white;
            padding: 16px 0
        }

        .footer-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem
        }

        .socials a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            margin-left: 8px;
            font-weight: 700
        }

        /* responsive */
        @media (max-width:900px) {
            .grid-2 {
                grid-template-columns: 1fr
            }

            .grid-3 {
                grid-template-columns: repeat(2, 1fr)
            }

            .majors-grid {
                grid-template-columns: 1fr
            }

            .hero-inner {
                flex-direction: column-reverse;
                gap: 1.25rem
            }

            .nav-links {
                display: none
            }

            .nav-toggle {
                display: inline-block
            }

            .hero-right {
                width: 100%
            }

            .video-frame iframe {
                height: 260px
            }
        }

        @media (max-width:520px) {
            .grid-3 {
                grid-template-columns: 1fr
            }

            h1 {
                font-size: 1.4rem
            }

            .card-spotlight {
                max-width: 100%
            }

            .section {
                padding: 36px 0
            }
        }
    </style>
@endpush
@section('content')
    <!-- HERO -->
    <section class="container">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="hero-left reveal-up">
                        <p style="color: #696767;">Telah dipercaya lebih dari 10.000+ Orang Tua & SIswa</p>
                        <h1 style="font-size: 40px;">MEMBENTUK <span class="accent">PEMPIMPIN</span><br> MASA DEPAN</h1>
                        {{-- <p class="lead">Sekolah vokasi unggul yang mencetak generasi berkarakter, terampil, dan siap kerja.</p> --}}
                        <p class="mt-3">Ayo! Segera daftarkan dirimu ke <br> SMK Wikrama Bogor</p>
                        <div class="hero-actions mt-5">
                            <a class="btn btn-login-custom" href="#visi-misi">Pedaftaran PPDB</a>
                            <a class="btn accent" href="#daftar">Lihat Program Sekolah</a>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <img style="bottom: 95%;" src="{{ asset('Group3.png') }}" width="400px" height="400px" alt="">
                </div>
            </div>
        </div>
    </section>

    <section id="visi-misi" class="section white-section">
        <div class="container">
            <h2>Visi & Misi</h2>
            <p class="muted">Visi dan misi sekolah SMK Wikrama Bogor</p>

            <div class="grid-2">
                <div class="card reveal-left">
                    <h3>Visi</h3>
                    <p>Menjadi sekolah kejuruan teladan nasional yang berbudaya lingkungan, berkarakter sesuai profil pelajar pancasila, berbasis teknologi informasi, dan mampu memenuhi kebutuhan industri 4.0</p>
                </div>
                <div class="card reveal-right">
                    <h3>Misi</h3>
                    <ol>
                        <li>Mewujudkan sekolah sebagai benteng moralitas bangsa.</li>
                        <li>Mendidik anak bangsa dengan hati dan teknologi sehingga memenuhi kebutuhan mutu dunia kerja.</li>
                        <li>Membangun kebersamaan sosial, jiwa kewirausahaan, dan gerakan cinta tanah air.</li>

                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- KARAKTER (Pancawaluya) -->
    <section id="karakter" class="section alt-section">
        <div class="container">
            <div class="section-head reveal-up">
                <h2>Karakter - Pancawaluya</h2>
                <p class="muted">Nilai-nilai karakter yang ditanamkan pada siswa.</p>
            </div>

            <div class="grid-3">
                <!-- 6 cards -->
                <div class="card small reveal-scale">
                    <div class="icon">🌟</div>
                    <h4>Cageur</h4>
                    <p>Deskripsi singkat tentang karakter kejujuran.</p>
                </div>

                <div class="card small reveal-scale">
                    <div class="icon">🤝</div>
                    <h4>Baguer</h4>
                    <p>Deskripsi singkat tentang karakter kerjasama.</p>
                </div>

                <div class="card small reveal-scale">
                    <div class="icon">💡</div>
                    <h4>Singer</h4>
                    <p>Deskripsi singkat tentang karakter inovasi.</p>
                </div>

                <div class="card small reveal-scale">
                    <div class="icon">🏅</div>
                    <h4>Pinter</h4>
                    <p>Deskripsi singkat tentang karakter prestasi.</p>
                </div>

                <div class="card small reveal-scale">
                    <div class="icon">📚</div>
                    <h4>Bener</h4>
                    <p>Deskripsi singkat tentang karakter disiplin.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- JURUSAN -->
    {{-- <section id="jurusan" class="section white-section">
        <div class="container">
            <div class="section-head reveal-up">
                <h2>Jurusan</h2>
                <p class="muted">Pilih jurusan yang sesuai minat dan bakat (placeholder).</p>
            </div>

            <div class="majors-grid">
                <div class="major-card reveal-up">
                    <div class="maj-icon">🖥️</div>
                    <h4>Rekayasa Perangkat Lunak (RPL)</h4>
                    <p>Deskripsi singkat jurusan RPL.</p>
                </div>

                <div class="major-card reveal-up">
                    <div class="maj-icon">🎨</div>
                    <h4>Desain Komunikasi Visual (DKV)</h4>
                    <p>Deskripsi singkat jurusan DKV.</p>
                </div>

                <div class="major-card reveal-up">
                    <div class="maj-icon">🔧</div>
                    <h4>Teknik Mesin</h4>
                    <p>Deskripsi singkat jurusan Teknik Mesin.</p>
                </div>

                <div class="major-card reveal-up">
                    <div class="maj-icon">🔌</div>
                    <h4>Teknik Listrik</h4>
                    <p>Deskripsi singkat jurusan Teknik Listrik.</p>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- TESTIMONI -->
    {{-- <section id="testimoni" class="section alt-section">
        <div class="container">
            <div class="section-head reveal-up">
                <h2>Testimoni</h2>
                <p class="muted">Suara alumni dan siswa (placeholder).</p>
            </div>

            <div class="testimonial-wrap">
                <button class="t-prev" aria-label="Prev">‹</button>

                <div class="testimonial-slider">
                    <div class="testi-slide active" data-index="0">
                        <img src="https://via.placeholder.com/84.png?text=A" alt="Foto A" class="avatar">
                        <blockquote>"Belajar di Wikrama membuat saya siap kerja. Guru-gurunya mendukung!"</blockquote>
                        <p class="t-author">Rina — RPL</p>
                    </div>

                    <div class="testi-slide" data-index="1">
                        <img src="https://via.placeholder.com/84.png?text=B" alt="Foto B" class="avatar">
                        <blockquote>"Fasilitas praktiknya lengkap, pengalaman magang sangat membantu."</blockquote>
                        <p class="t-author">Andi — DKV</p>
                    </div>

                    <div class="testi-slide" data-index="2">
                        <img src="https://via.placeholder.com/84.png?text=C" alt="Foto C" class="avatar">
                        <blockquote>"Karakter Pancawaluya benar-benar terbentuk selama di sini."</blockquote>
                        <p class="t-author">Siti — Teknik Listrik</p>
                    </div>
                </div>

                <button class="t-next" aria-label="Next">›</button>
            </div>

            <div class="dots" aria-hidden="true">
                <button class="dot active" data-slide="0"></button>
                <button class="dot" data-slide="1"></button>
                <button class="dot" data-slide="2"></button>
            </div>
        </div>
    </section> --}}

    <!-- VIDEO -->
    {{-- <section id="video" class="section video-section">
        <div class="container">
            <div class="section-head reveal-up">
                <h2>Tonton Sekilas Tentang Kami</h2>
                <p class="muted">Video pengenalan sekolah (placeholder YouTube).</p>
            </div>

            <div class="video-frame reveal-up">
                <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Video Pengenalan" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            </div>
        </div>
    </section> --}}

    <!-- CTA / DAFTAR (dummy) -->
    <section id="daftar" class="section cta-section">
        <div class="container reveal-up">
            <h3>Siap bergabung dengan SMK Wikrama Bogor?</h3>
            <p class="muted">Form pendaftaran dan sistem back-end dapat dihubungkan nanti.</p>
            <a href="{{ route('signup') }}">Mulai Pendaftaran</a>
        </div>
    </section>
@endsection
