<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\SkillField;
use App\Models\ApplicantMajorChoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplicantMajorChoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applicant = Auth::user()->applicant;

        $hasChosen = ApplicantMajorChoice::where('applicant_id', $applicant->id)->exists();

        if ($hasChosen) {
            $chosenMajors = ApplicantMajorChoice::where('applicant_id', $applicant->id)
                ->with(['major.skillField'])
                ->orderBy('priority')
                ->get();

            return view('applicants.majors.locked', compact('chosenMajors', 'applicant'));
        }

        // Ambil semua bidang keahlian + jurusannya
        $skillFields = SkillField::with(['majors' => fn($q) => $q->whereNull('deleted_at')])
            ->orderBy('nama')
            ->get();

        // Coba ambil pilihan sementara (jika user pernah buka halaman ini)
        $tempChoices = ApplicantMajorChoice::where('applicant_id', $applicant->id)
            ->with('major.skillField')
            ->orderBy('priority')
            ->get();

        // Kalau sudah ada pilihan sementara → otomatis pilih bidangnya
        $selectedSkillFieldId = $tempChoices->first()?->major?->skill_field_id;

        return view('applicants.majors.index', compact(
            'skillFields',
            'tempChoices',
            'selectedSkillFieldId',
            'applicant'
        ));
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

        $alreadyChosen = ApplicantMajorChoice::where('applicant_id', $applicant->id)->exists();
        if ($alreadyChosen) {
            return back()->with('error', 'Kamu sudah memilih jurusan sebelumnya dan tidak dapat mengubahnya lagi.');
        }

        $request->validate([
            'priorities'   => 'required|array|min:1',
            'priorities.*' => 'exists:majors,id'
        ]);

        $newMajorIds = array_unique($request->priorities);

        DB::transaction(function () use ($applicant, $newMajorIds) {
            foreach ($newMajorIds as $index => $majorId) {
                ApplicantMajorChoice::create([
                    'applicant_id' => $applicant->id,
                    'major_id'     => $majorId,
                    'priority'     => $index + 1
                ]);
            }
        });

        return redirect()->route('applicants.choices.index')
            ->with('success', 'Pilihan jurusan berhasil disimpan! Kamu tidak dapat mengubahnya lagi.');
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
