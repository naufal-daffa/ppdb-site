<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Applicant;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applicants = Applicant::with(['document', 'user'])
            ->whereHas('document', function ($query) {
                $query->whereIn('status_verifikasi', ['menunggu', 'perlu_perbaikan', 'sedang_diverifikasi']);
            })
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('staff.documents.index', compact('applicants'));
    }

    public function verify($id)
    {
        $applicant = Applicant::with('document')->findOrFail($id);
        return view('staff.documents.verify', compact('applicant'));
    }

    public function updateVerification(Request $request, $id)
    {
        $applicant = Applicant::with('document')->findOrFail($id);
        $document = $applicant->document;

        $status = $request->input('status', []);
        $notes  = $request->input('notes', []);

        $document->verification_status = $status;
        $document->verification_notes  = $notes;

        $rejected = collect($status)->contains('rejected');
        $hasPending = collect($status)->filter(fn($s) => $s !== 'approved')->count() > 0;

        if ($rejected) {
            $document->status_verifikasi = 'perlu_perbaikan';
        } elseif ($hasPending) {
            $document->status_verifikasi = 'sedang_diverifikasi';
        } else {
            $document->status_verifikasi = 'lengkap';
        }

        $document->save();

        return redirect()->route('staff.documents.index')->with('success', "Verifikasi dokumen {$applicant->nama_lengkap} berhasil disimpan!");
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

    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        //
    }
}
