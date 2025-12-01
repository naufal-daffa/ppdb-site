<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Applicant;
use Illuminate\Support\Facades\Auth;

class ApplicantSideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $applicant = Applicant::find($request->applicant_id);
        // dd($applicant);
        return view('applicants.documents.index');
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
        // Pastikan applicant benar-benar ada dan milik user yang login
        $applicant = Applicant::where('id', $request->applicant_id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();

        $request->validate([
            'kartu_keluarga'  => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'akte_kelahiran'  => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'ijazah'          => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'surat_kelulusan' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'ktp_ayah'        => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'ktp_ibu'         => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'surat_kesehatan'=> 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $folder = "documents/" . Auth::user()->id;

        // Siapkan data dasar
        $data = [
            'applicant_id'       => $applicant->id,
            'status_verifikasi'  => 'menunggu',
        ];

        $fields = ['kartu_keluarga','akte_kelahiran','ijazah','surat_kelulusan','ktp_ayah','ktp_ibu','surat_kesehatan'];

        // Load relasi document sekali saja biar lebih cepat & aman
        $document = $applicant->document; // bisa null, tapi kita tangani dengan benar

        foreach ($fields as $field) {
            if ($request->hasFile($field)) {
                // Hapus file lama KALAU ADA
                if ($document && $document->{$field}) {
                    Storage::disk('public')->delete($document->{$field});
                }

                $file     = $request->file($field);
                $filename = $field . '_' . time() . '_' . Auth::user()->id . '.' . $file->getClientOriginalExtension();
                $path     = $file->storeAs($folder, $filename, 'public');

                $data[$field] = $path;
            }
        }

        // Update atau buat baru → otomatis handle kalau document belum ada
        Document::updateOrCreate(
            ['applicant_id' => $applicant->id],
            $data
        );

        return back()->with('success', 'Dokumen berhasil disimpan.');
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
