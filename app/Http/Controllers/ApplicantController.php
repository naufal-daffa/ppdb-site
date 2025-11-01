<?php

namespace App\Http\Controllers;

use App\Exports\ApplicantExport;
use App\Models\Applicant;
use App\Models\RegistrationWave;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applicants = Applicant::with(['major', 'admissionPath'])->get();
        return view('admin.applicants.index', compact('applicants'));
    }

    // public function indexPendaftar()
    // {
    //     return view('applicants.home');
    // }

    public function indexPendaftar()
    {
        $applicant = Applicant::where('user_id', Auth::id())->first();
        if (!$applicant) {
            return redirect()->back()->with('error', 'Data pendaftar tidak ditemukan.');
        }
        $needsVerification = in_array($applicant->status_verifikasi, ['menunggu', 'ditolak', null]);

        $acceptedApplicant = null;
        if ($applicant->status_verifikasi === 'diterima') {
            $acceptedApplicant = $applicant;
        }

        if ($needsVerification) {
            return view('applicants.verifikasi', compact('applicant', 'needsVerification'));
        }

        return view('applicants.home', [
            'applicant' => $applicant,
            'acceptedApplicant' => $acceptedApplicant,
        ])->with('diterima', 'Halo ' . ($applicant->nama_lengkap ?? 'Peserta') . ' ! Selamat datang, Silahkan isi dokumen kamu');
    }




    public function indexStaff()
    {
        $applicants = Applicant::whereIn('status_verifikasi', ['diterima', 'menunggu'])->get();
        // dd($applicants);
        return view('staff.home', compact('applicants'));
    }

    public function uploadBuktiPembayaran(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|mimes:jpeg,jpg,png,svg,webp',
        ], [
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diisi!',
            'bukti_pembayaran.mimes' => 'File hanya boleh bertipe JPG/JPEG/PNG/SVG/WEBP',
        ]);

        $buktiPembayaran = $request->file('bukti_pembayaran');

        $fotoBuktiPembayaran = Str::random(5) . "-bukti_pembayaran." . $buktiPembayaran->getClientOriginalExtension();
        $path = $buktiPembayaran->storeAs('bukti-pembayaran', $fotoBuktiPembayaran, 'public');

        $updated = Applicant::where('id', $id)->update([
            'bukti_pembayaran' => $path,
            'status_verifikasi' => 'menunggu'
        ]);

        if ($updated) {
            return redirect()->back()->with('kirim', 'Berhasil upload! Silahkan menunggu');
        } else {
            return redirect()->back()->with('error', 'Gagal! Silahkan coba lagi');
        }
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
        // ==========================
        // VALIDASI INPUT
        // ==========================
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
        ]);

        // ==========================
        // AMBIL GELOMBANG PENDAFTARAN AKTIF
        // ==========================
        $wave = RegistrationWave::where('aktif', 1)->first();

        // ==========================
        // GENERATE USER
        // ==========================
        // naufaldaffa098
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

        // ==========================
        // FORMAT ID UNTUK PDF
        // ==========================
        $lastApplicant = Applicant::latest('id')->first();
        $userIdFormatted = str_pad(($lastApplicant?->id ?? 0) + 1, 4, '0', STR_PAD_LEFT);

        // ==========================
        // SIMPAN DATA APPLICANT
        // ==========================
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

        // ==========================
        // MIDTRANS TRANSACTION
        // ==========================
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

            Log::info('MIDTRANS RETURN:', $payment);

            if (!empty($payment['url'])) {
                $paymentUrl = $payment['url'];
                $applicant->payment_url = $paymentUrl;
                $applicant->save();

                Log::info("Payment URL berhasil disimpan: " . $paymentUrl);
            } else {
                Log::warning("Payment URL kosong dari Midtrans untuk applicant_id: {$applicant->id}");
            }
        } catch (Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
        }

        // ==========================
        // PDF GENERATION TANPA QR
        // ==========================
        $pdf = Pdf::loadView('pdf.registration_info', [
            'nama' => $request->nama_lengkap,
            'username' => $username,
            'password' => $passwordPlain,
            'user_id' => $userIdFormatted,
            'tanggal_daftar' => now()->format('d-m-Y'),
            'nomor_telepon_wali' => $request->nomor_telepon_wali,
            'gelombang' => $wave->nama_gelombang ?? 'Belum Ditentukan',
            'payment_url' => $paymentUrl,
        ]);

        // ==========================
        // SEND EMAIL
        // ==========================
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
                        <p><a href="' . e($paymentUrl ?? '#') . '">👉 Bayar Sekarang di Midtrans</a></p>
                        <p>Salam hangat,<br><b>Panitia PPDB SMK Wikrama Bogor</b></p>
                    ');
            });
        } catch (Exception $e) {
            Log::error('Email send failed: ' . $e->getMessage());
        }

        // ==========================
        // REDIRECT RESULT
        // ==========================
        if ($applicant && $user) {
            return redirect()->route('login')
                ->with('success', 'Pendaftaran berhasil! Cek email Anda untuk akun dan link pembayaran.');
        } else {
            return redirect()->back()
                ->with('error', 'Gagal! Silahkan coba lagi');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Applicant $applicant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Applicant $applicant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Applicant $applicant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Applicant $applicant)
    {
        //
    }

    public function dataForDatatables()
    {
        $applicants = Applicant::query();
        return DataTables::of($applicants)
            ->addIndexColumn()
            ->addColumn('bukti_pembayaran', function ($row) {
                if ($row->bukti_pembayaran) {
                    $img = asset('storage/' . $row->bukti_pembayaran);
                    return "<img src='$img' width='80' class='img-thumbnail'>";
                } else {
                    return '<span class="text-danger">Belum mengunggah</span>';
                }
            })
            ->addColumn('jurusan', function ($row) {
                if ($row->majorChoices->isNotEmpty()) {
                    return $row->majorChoices->first()->major->nama;
                } else {
                    return '<span class="text-muted">Belum memilih</span>';
                }
            })
            ->addColumn('jalur_prestasi', function ($row) {
                if ($row->admissionPath) {
                    return $row->admissionPath->prestasi;
                } else {
                    return '<span class="text-muted">Belum memilih</span>';
                }
            })
            ->addColumn('buttons', function ($row) {
                $item = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                return "<button class='btn btn-sm btn-info' onclick='showModal($item)'>Detail</button>";
            })
            ->rawColumns(['bukti_pembayaran', 'jurusan', 'jalur_prestasi', 'buttons'])
            ->make(true);
    }

    public function dataForDatatablesStaff()
    {
        $applicants = Applicant::whereIn('status_verifikasi', ['diterima', 'menunggu'])->get();
        return DataTables::of($applicants)
            ->addIndexColumn()
            ->addColumn('bukti_pembayaran', function ($row) {
                if ($row->bukti_pembayaran) {
                    $img = asset('storage/' . $row->bukti_pembayaran);
                    return "<img src='$img' width='80' class='img-thumbnail'>";
                } else {
                    return '<span class="text-danger">Belum mengunggah</span>';
                }
            })
            ->addColumn('buttons', function ($data) {
                $btnTolak = '<form action="' . route('staff.applicants.tolak', $data->id) . '" method="POST">' .
                    csrf_field() .
                    method_field('PATCH') .
                    '<button type="submit" class="btn btn-danger">Tolak</button>
                        </form>';
                $btnTerima = '<form action="' . route('staff.applicants.terima', $data->id) . '" method="POST">' .
                    csrf_field() .
                    method_field('PATCH') .
                    '<button type="submit" class="btn btn-success">Terima</button>
                        </form>';
                $item = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
                $modal = "<button class='btn btn-sm btn-info' onclick='showModal($item)'>Detail</button>";
                if ($data->status_verifikasi == 'diterima') {
                    return '<div class="d-flex justify-content-center gap-3">' . $modal . '</div>';
                } elseif ($data->status_verifikasi == 'menunggu') {
                    return '<div class="d-flex justify-content-center gap-3">' . $modal . $btnTerima . $btnTolak . '</div>';;
                }
            })
            ->rawColumns(['bukti_pembayaran', 'buttons'])
            ->make(true);
    }
    public function export()
    {
        return Excel::download(new ApplicantExport, 'applicants.xlsx');
    }

    // staff
    public function diterima($id)
    {
        $user = Applicant::where('id', $id)->update([
            'status_verifikasi' => 'diterima'
        ]);

        if ($user) {
            return redirect()->back()->with('success', 'Berhasil!');
        } else {
            return redirect()->back()->with('error', 'Gagal!');
        }
    }
    // public function ditolak(Applicant $applicant, $id)
    // {
    //     $filePath = 'storage/' . $applicant->bukti_pembayaran;
    //     $result = $applicant->where('id', $id)->update([
    //         'status_verifikasi' => 'ditolak',
    //         'bukti_pembayaran' => null
    //     ]);

    //     Storage::disk('public')->delete($filePath);

    //     if ($result) {
    //         return redirect()->back()->with('success', 'Berhasil!');
    //     } else {
    //         return redirect()->back()->with('error', 'Gagal!');
    //     }
    // }

    public function ditolak(Applicant $applicant, $id)
    {
        $applicantData = $applicant->find($id);

        if ($applicantData && $applicantData->bukti_pembayaran) {
            Storage::disk('public')->delete($applicantData->bukti_pembayaran);
        }

        $result = $applicant->where('id', $id)->update([
            'status_verifikasi' => 'ditolak',
            'bukti_pembayaran' => null
        ]);

        if ($result) {
            return redirect()->back()->with('success', 'Berhasil!');
        } else {
            return redirect()->back()->with('error', 'Gagal!');
        }
    }
}
