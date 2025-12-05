<?php

namespace App\Http\Controllers;

use App\Models\Selection;
use App\Models\Applicant;
use App\Models\Staff;
use App\Models\ApplicantMajorChoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class SelectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applicants = Applicant::query()
            ->whereHas('staff', function ($q) {
                $q->where('user_id', Auth::id())
                  ->whereNotNull('tanggal_wawancara');
            })
            ->with([
                'staff',
                'selections',
                'majorChoices' => fn($q) =>
                    $q->orderBy('priority') // Urutkan berdasarkan prioritas
            ])
            ->orderBy(
                Staff::select('tanggal_wawancara')
                    ->whereColumn('staff.applicant_id', 'applicants.id')
                    ->where('staff.user_id', Auth::id())
                    ->limit(1)
            )
            ->orderBy(
                Staff::select('waktu_wawancara')
                    ->whereColumn('staff.applicant_id', 'applicants.id')
                    ->where('staff.user_id', Auth::id())
                    ->limit(1)
            )
            ->get();

        return view('staff.selections.index', compact('applicants'));
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
    public function store(Request $request, Applicant $applicant)
    {
        $request->validate([
            'nilai_ujian'     => 'required|numeric|min:0|max:100',
            'nilai_wawancara' => 'required|numeric|min:0|max:100',
        ]);

        $hasil_akhir = ($request->nilai_ujian * 0.4) + ($request->nilai_wawancara * 0.6);
        $hasil_akhir = round($hasil_akhir, 2);

        $status = 'tidak_lulus';
        $status_pendaftaran = 'ditolak';

        if ($hasil_akhir >= 85) {
            $status = 'lulus';
            $status_pendaftaran = 'diterima';
        }

        Selection::updateOrCreate(
            ['applicant_id' => $applicant->id],
            [
                'nilai_ujian'     => $request->nilai_ujian,
                'nilai_wawancara' => $request->nilai_wawancara,
                'hasil_akhir'     => $hasil_akhir,
                'status'          => $status,
            ]
        );

        // LOGIC BARU: Update status_kehadiran menjadi 'hadir' di tabel Staff
        Staff::where('applicant_id', $applicant->id)
            ->where('user_id', Auth::id()) // Pastikan hanya jadwal staff yang sedang login yang diupdate
            ->update(['status_kehadiran' => 'hadir']);

        $applicant->update([
            'status_pendaftaran' => $status_pendaftaran
        ]);

        return back()->with('success', 'Penilaian berhasil disimpan! Status: ' . ucfirst(str_replace('_', ' ', $status)));
    }
    /**
     * Display the specified resource.
     */
    public function show(selection $selection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(selection $selection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, selection $selection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(selection $selection)
    {
        //
    }
}
