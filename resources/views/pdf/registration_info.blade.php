<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Akun PPDB SMK Wikrama</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
        }

        .header {
            text-align: center;
        }

        .info {
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #ccc;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>SMK Wikrama Bogor</h2>
        <p><strong>Informasi Akun PPDB</strong></p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td>Nama Lengkap</td>
                <td>{{ $nama }}</td>
            </tr>
            <tr>
                <td>Username</td>
                <td>{{ $username }}</td>
            </tr>
            <tr>
                <td>Password</td>
                <td>{{ $password }}</td>
            </tr>
            <tr>
                <td>Nomor Peserta</td>
                <td>{{ $user_id }}</td>
            </tr>
            <tr>
                <td>Tanggal Daftar</td>
                <td>{{ $tanggal_daftar }}</td>
            </tr>
            <tr>
                <td>Nomor Telepon Wali</td>
                <td>{{ $nomor_telepon_wali }}</td>
            </tr>
            <tr>
                <td>Gelombang Pendaftaran</td>
                <td>{{ $gelombang }}</td>
            </tr>
        </table>
    </div>
    <h3>Link Pembayaran</h3>
    <p>Anda dapat membayar biaya pendaftaran melalui link berikut:</p>
    <p><a href="{{ $payment_url }}">{{ $payment_url }}</a></p>

    <p>Dengan total pembayaran sebesar : Rp. 250.000</p>


    <p>Terima kasih telah mendaftar di SMK Wikrama Bogor. Silakan gunakan akun ini untuk melanjutkan proses PPDB di
        website resmi.</p>
</body>

</html>
