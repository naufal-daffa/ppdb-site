<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applicant = Auth::user()->applicant;
        $certificates = $applicant->certificates()->latest()->get();
        return view('applicants.certificates.index', compact('certificates', 'applicant'));
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

        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'nama_sertifikat' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $path = $request->file('file')->storeAs(
            'certificates/applicant_' . $applicant->id,
            'sertifikat_' . $applicant->id . '_' . time() . '.' . $request->file('file')->extension(),
            'public'
        );

        Certificate::create([
            'applicant_id' => $applicant->id,
            'file_path' => $path,
            'nama_sertifikat' => $request->nama_sertifikat,
            'deskripsi' => $request->deskripsi,
            'status_verifikasi' => 'pending',
        ]);

        return back()->with('success', 'Sertifikat berhasil diunggah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Certificate $certificate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Certificate $certificate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Certificate $certificate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificate $certificate)
    {
        if ($certificate->applicant_id !== Auth::user()->applicant->id) {
            abort(403);
        }

        Storage::disk('public')->delete($certificate->file_path);
        $certificate->delete();

        return back()->with('success', 'Sertifikat dihapus.');
    }
}
