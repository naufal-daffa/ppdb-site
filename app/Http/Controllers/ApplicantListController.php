<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\AdmissionPath;
use App\Models\RegistrationWave;
use Illuminate\Http\Request;

class ApplicantListController extends Controller
{
    public function index(Request $request)
    {
        $query = Applicant::query()
            ->with(['registrationWave', 'user', 'majorChoices'])
            ->latest();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('wave') && !empty($request->wave)) {
            $query->where('id_registration_wave', $request->wave);
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status_pendaftaran', $request->status);
        }

        $applicants = $query->paginate(12);
        $waves = RegistrationWave::all();
        $admissionPaths = AdmissionPath::all();
        $statuses = ['menunggu', 'diverifikasi', 'ditolak', 'diterima'];

        return view('staff.applicants.index', compact(['applicants', 'waves', 'statuses', 'admissionPaths']));
    }

    /**
     * Display the specified applicant with full details
     */
    // public function show($id)
    // {
    //     $applicant = Applicant::select('*')
    //         ->where('id', $id)
    //         ->first();

    //     if (!$applicant) {
    //         abort(404);
    //     }

    //     $applicant->load('user');
    //     $applicant->load('registrationWave');
    //     $applicant->load(['majorChoices' => function($q) {
    //         $q->with('skillField');
    //     }]);
    //     $applicant->load('document');
    //     $applicant->load('certificates');
    //     $applicant->load('staff');
    //     $applicant->load('selections');
    //     $applicant->load('admissionPath');


    //     return view('staff.applicants.show', compact('applicant'));
    // }
    public function show($id)
    {
        $applicant = Applicant::with([
            'user',
            'registrationWave',
            'majorChoices.skillField',
            'document',
            'certificates',
            'staff',
            'selections',
            'admissionPath' => function($query) {
                $query->withCount('applicants'); 
            }
        ])->findOrFail($id);
        $admissionPaths = AdmissionPath::all();

        return view('staff.applicants.show', compact(['applicant', 'admissionPaths']));
    }

    public function updateAdmissionPath(Request $request, $id)
    {
        $request->validate([
            'admission_path_id' => 'nullable|exists:admission_paths,id',
            'notes' => 'nullable|string|max:500'
        ]);

        $applicant = Applicant::findOrFail($id);

        $applicant->update([
            'admission_path_id' => $request->admission_path_id
        ]);

        if ($request->filled('notes')) {
            session()->flash('admission_path_note', $request->notes);
        }

        return redirect()->route('staff.applicants.show', $id)
            ->with('success', 'Jalur pendaftaran berhasil diperbarui!')
            ->withFragment('admission-path');
    }

    public function resetAdmissionPath($id)
    {
        $applicant = Applicant::findOrFail($id);
        $applicant->update(['admission_path_id' => null]);

        return redirect()->route('staff.applicants.show', $id)
            ->with('warning', 'Jalur pendaftaran telah direset!')
            ->withFragment('admission-path');
    }
}
