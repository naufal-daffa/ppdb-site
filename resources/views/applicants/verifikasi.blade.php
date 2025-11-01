<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi Pembayaran</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB UI Kit -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.min.css" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="shortcut icon"
        href="https://media.licdn.com/dms/image/v2/C510BAQGcQObmC5ADzw/company-logo_200_200/company-logo_200_200/0/1630582740922/tix_id_logo?e=2147483647&v=beta&t=y7u2Lvw4QGrKw64ZYzcBTp34x8Ih-c1-dy_-m9NV4W4">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>

<body>
    <div class="container my-5">

        @if (session('kirim'))
            <div class="card p-4 bg-success text-white mb-4 shadow-sm">
                <h5><i class="fa-solid fa-check-circle me-2"></i>Berhasil Mengirim!</h5>
                <p>Silakan menunggu verifikasi dari admin.</p>
            </div>
        @endif

        @if ($applicant->status_verifikasi === 'menunggu')
            <div class="card p-4 bg-warning text-dark mb-4 shadow-sm border-0">
                <h5><i class="fa-solid fa-hourglass-half me-2"></i>Status: Menunggu Verifikasi</h5>
                <p>Admin sedang memeriksa bukti pembayaran Anda. Mohon tunggu ya.</p>
            </div>

        @elseif ($applicant->status_verifikasi === 'diterima')
            <div class="card p-4 bg-success text-white mb-4 shadow-sm border-0">
                <h5><i class="fa-solid fa-circle-check me-2"></i>Pembayaran Diterima!</h5>
                <p>Selamat, {{ $applicant->nama_lengkap ?? 'Peserta' }}! Pembayaran kamu telah diverifikasi.</p>
                <a href="{{ route('applicants.index') }}" class="btn btn-light mt-2">
                    <i class="fa-solid fa-arrow-right me-1"></i>Lanjut ke Tahap Selanjutnya
                </a>
            </div>

        @elseif ($applicant->status_verifikasi === 'ditolak')
            <div class="card p-4 bg-danger text-white mb-4 shadow-sm border-0">
                <h5><i class="fa-solid fa-times-circle me-2"></i>Pembayaran Ditolak</h5>
                <p>Silakan upload ulang bukti pembayaran Anda dengan benar agar bisa diverifikasi kembali.</p>
            </div>
        @endif

        @if ($applicant->status_verifikasi === 'ditolak' || $applicant->status_verifikasi === null)
            <div class="card p-4 shadow-sm border-0">
                <form action="{{ route('applicants.upload', $applicant->id) }}" method="POST"
                    enctype="multipart/form-data" id="form">
                    @csrf
                    <label for="bukti_pembayaran" class="form-label fw-bold">Upload Bukti Pembayaran</label>
                    <input type="file" name="bukti_pembayaran" class="form-control mb-3" required>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-upload me-1"></i> Kirim
                    </button>
                </form>
            </div>
        @endif

    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"
        integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.umd.min.js"></script>
</body>

</html>
