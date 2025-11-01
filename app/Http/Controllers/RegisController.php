<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\RegistrationWave;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Exception;


class RegisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('signup');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|max:255',
            'nisn' => 'required|numeric|unique:applicants,nisn',
            'jenis_kelamin' => 'required',
            'asal_sekolah' => 'required|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat_email' => 'required|email|unique:users,email',
            'alamat' => 'required',
            'nomor_telepon' => 'required',
            'pekerjaan_ayah' => 'required',
            'pekerjaan_ibu' => 'required',
            'nomor_telepon_wali' => 'required|numeric',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.max' => 'Nama lengkap tidak boleh lebih dari 255 karakter.',
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.numeric' => 'NISN harus berupa angka.',
            'nisn.unique' => 'NISN sudah terdaftar.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'asal_sekolah.required' => 'Asal sekolah wajib diisi.',
            'asal_sekolah.max' => 'Asal sekolah tidak boleh lebih dari 255 karakter.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            'alamat_email.required' => 'Alamat email wajib diisi.',
            'alamat_email.email' => 'Format email tidak valid.',
            'alamat_email.unique' => 'Email sudah digunakan.',
            'alamat.required' => 'Alamat wajib diisi.',
            'nomor_telepon.required' => 'Nomor telepon wajib diisi.',
            'pekerjaan_ayah.required' => 'Pekerjaan ayah wajib diisi.',
            'pekerjaan_ibu.required' => 'Pekerjaan ibu wajib diisi.',
            'nomor_telepon_wali.required' => 'Nomor telepon wali wajib diisi.',
            'nomor_telepon_wali.numeric' => 'Nomor telepon wali harus berupa angka.',
        ]);

        $wave = RegistrationWave::where('aktif', 1)->first();

        $usernameBase = explode('@', $request->alamat_email)[0];
        $username = $usernameBase . rand(100, 999);
        $passwordPlain = str_pad(rand(0, 9999999999), 10, '0', STR_PAD_LEFT);
        $passwordHash = Hash::make($passwordPlain);

        $user = User::create([
            'nama' => $username,
            'email' => $request->alamat_email,
            'password' => $passwordHash,
            'role' => 'applicant',
        ]);

        $lastApplicant = Applicant::latest('id')->first();
        $userIdFormatted = str_pad(($lastApplicant?->id ?? 0) + 1, 4, '0', STR_PAD_LEFT);

        $applicant = Applicant::create([
            'user_id' => $user->id,
            'nisn' => $request->nisn,
            'nama_lengkap' => $request->nama_lengkap,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'nomor_telepon' => $request->nomor_telepon,
            'jenis_kelamin' => $request->jenis_kelamin,
            'asal_sekolah' => $request->asal_sekolah,
            'pekerjaan_ayah' => $request->pekerjaan_ayah,
            'pekerjaan_ibu' => $request->pekerjaan_ibu,
            'nomor_telepon_wali' => $request->nomor_telepon_wali,
            'id_registration_wave' => $wave->id,
        ]);
        $paymentUrl = null;
        try {
            $midtrans = new MidtransService();

            $orderId = 'PPDB-' . $applicant->id . '-' . time();
            $grossAmount = 250000;
            $customer = [
                'first_name' => $request->nama_lengkap,
                'email' => $request->alamat_email,
                'phone' => $request->nomor_telepon_wali,
            ];

            $payment = $midtrans->createTransaction($orderId, $grossAmount, $customer);
            $paymentUrl = $payment['url'] ?? null;

            if ($paymentUrl) {
                $applicant->update(['payment_url' => $paymentUrl]);
            }
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
        }

        $qr = $paymentUrl
            ? base64_encode(QrCode::format('png')->size(200)->generate($paymentUrl))
            : null;

        $pdf = Pdf::loadView('pdf.registration_info', [
            'nama' => $request->nama_lengkap,
            'username' => $username,
            'password' => $passwordPlain,
            'user_id' => $userIdFormatted,
            'tanggal_daftar' => now()->format('d-m-Y'),
            'nomor_telepon_wali' => $request->nomor_telepon_wali,
            'gelombang' => $wave->nama_gelombang ?? 'Belum Ditentukan',
            'payment_url' => $paymentUrl,
            'qr' => $qr,
        ]);

        try {
            Mail::send([], [], function ($message) use ($request, $pdf, $paymentUrl) {
                $message->from(config('mail.from.address'), config('mail.from.name'))
                    ->to($request->alamat_email)
                    ->subject('Akun PPDB & Link Pembayaran')
                    ->attachData($pdf->output(), 'Akun_PPDB_Wikrama.pdf')
                    ->html('
                <h3>Halo ' . e($request->nama_lengkap) . '!</h3>
                <p>Terima kasih telah mendaftar di <b>PPDB SMK Wikrama Bogor</b>.</p>
                <p>Silakan lakukan pembayaran biaya pendaftaran melalui tautan berikut:</p>
                <p><a href="' . $paymentUrl . '">👉 Bayar Sekarang di Midtrans</a></p>
                <p>Atau gunakan QR Code di file PDF yang terlampir.</p>
                <p>Salam hangat,<br><b>Panitia PPDB SMK Wikrama Bogor</b></p>
            ');
            });
        } catch (Exception $e) {
            Log::error('Email send failed: ' . $e->getMessage());
        }



        if ($applicant && $user) {
            return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Cek email Anda untuk akun dan QR pembayaran.');
        } else {
            return redirect()->back()->with('error', 'Gagal! Silahkan coba lagi');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
