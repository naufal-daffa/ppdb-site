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
    public function index()
    {
        $applicant = Auth::user()->applicant;

        if (!$applicant) {
            return redirect()->route('applicants.index')->with('error', 'Lengkapi data pendaftaran terlebih dahulu.');
        }

        return view('applicants.documents.index', compact('applicant'));
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
        $applicant = Auth::user()->applicant;
        if (!$applicant) abort(404);

        $request->validate([
            'kartu_keluarga'   => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'akte_kelahiran'   => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'ijazah'           => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'surat_kelulusan'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'ktp_ayah'         => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'ktp_ibu'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'surat_kesehatan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $folder = 'documents/applicant_' . $applicant->id;
        $data = ['status_verifikasi' => 'menunggu'];

        $fields = ['kartu_keluarga','akte_kelahiran','ijazah','surat_kelulusan','ktp_ayah','ktp_ibu','surat_kesehatan'];

        foreach ($fields as $field) {
            if ($request->hasFile($field)) {
                // Hapus file lama
                $oldPath = Document::where('applicant_id', $applicant->id)->value($field);
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }

                $file = $request->file($field);
                $filename = $field . '_' . $applicant->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs($folder, $filename, 'public');
                $data[$field] = $path;
            }
        }

        // Update atau buat baru → semua field langsung masuk DB
        Document::updateOrCreate(
            ['applicant_id' => $applicant->id],
            $data
        );

        return back()->with('success', 'Dokumen berhasil disimpan!');
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
