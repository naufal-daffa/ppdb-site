<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ScheduleExport;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.staff.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 'staff')->get();

        // Ambil applicant yang:
        // 1. Belum punya jadwal wawancara
        // 2. Dokumen sudah ada
        // 3. Status verifikasi = diverifikasi / lengkap
        // 4. Belum ditolak & belum di-softdelete
        $applicantsYangSudahAdaJadwal = Staff::withTrashed()
            ->whereNotNull('applicant_id')
            ->pluck('applicant_id')
            ->toArray();

        $applicants = Applicant::with('user', 'document')
            ->whereHas('document', function ($q) {
                $q->whereIn('status_verifikasi', ['diverifikasi', 'lengkap']);
            })
            ->where('status_pendaftaran', '!=', 'ditolak')
            ->whereNull('deleted_at')
            ->whereNotIn('id', $applicantsYangSudahAdaJadwal)
            ->get();

        return view('admin.staff.create', compact('users', 'applicants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'staff_id'      => 'required|exists:users,id',
            'applicant_id'  => 'required|exists:applicants,id',
            'tanggal_wawancara' => 'required|date',
            'waktu_wawancara'   => 'required',
        ]);

        $staff = Staff::create([
            'user_id'           => $request->staff_id,
            'applicant_id'      => $request->applicant_id,
            'tanggal_wawancara' => $request->tanggal_wawancara,
            'waktu_wawancara'   => $request->waktu_wawancara,
        ]);

        return $staff
            ? redirect()->route('admin.staff.index')->with('success', 'Berhasil Menambahkan data!')
            : redirect()->back()->with('error', 'Gagal! Silahkan coba lagi');
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $staff = Staff::findOrFail($id);
        $users = User::where('role', 'staff')->get();

        $applicantsYangSudahAdaJadwal = Staff::whereNotNull('applicant_id')
            ->where('id', '!=', $id)
            ->pluck('applicant_id')
            ->toArray();

        $applicants = Applicant::with('user', 'document')
            ->whereHas('document', function ($q) {
                $q->whereIn('status_verifikasi', ['diverifikasi', 'lengkap']);
            })
            ->where('status_pendaftaran', '!=', 'ditolak')
            ->whereNull('deleted_at')
            ->whereNotIn('id', $applicantsYangSudahAdaJadwal)
            ->get();

        if ($staff->applicant_id) {
            $currentApplicant = Applicant::with('user', 'document')->find($staff->applicant_id);
            if ($currentApplicant && in_array($currentApplicant->document?->status_verifikasi, ['diverifikasi', 'lengkap'])) {
                $applicants->prepend($currentApplicant);
            }
        }

        return view('admin.staff.edit', compact('staff', 'users', 'applicants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'staff_id'      => 'required|exists:users,id',
            'applicant_id'  => 'required|exists:applicants,id',
            'tanggal_wawancara' => 'required|date',
            'waktu_wawancara'   => 'required',
            // 'status_kehadiran'  => 'nullable|in:hadir,tidak hadir',
        ]);

        $staff = Staff::findOrFail($id);

        $updated = $staff->update([
            'user_id'           => $request->staff_id,
            'applicant_id'      => $request->applicant_id,
            'tanggal_wawancara' => $request->tanggal_wawancara,
            'waktu_wawancara'   => $request->waktu_wawancara,
            // 'status_kehadiran'  => $request->status_kehadiran ?? $staff->status_kehadiran,
        ]);

        return $updated
            ? redirect()->route('admin.staff.index')->with('success', 'Berhasil mengupdate data!')
            : redirect()->back()->with('error', 'Gagal! Silahkan coba lagi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff, $id)
    {
        $staff = Staff::find($id);
        $staff->delete();
        return redirect()->route('admin.staff.index')->with('success', 'berhasil');
    }

    public function dataForDatatables()
    {
        $query = Staff::with(['user', 'applicant'])->select('staff.*');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('nama_staff', fn($row) => $row->user?->nama ?? 'Staff Dihapus')
            ->addColumn('nama_pendaftar', fn($row) => $row->applicant?->nama_lengkap ?? 'Pendaftar Dihapus')
            ->addColumn('tanggal_wawancara', fn($row) => $row->tanggal_wawancara ? \Carbon\Carbon::parse($row->tanggal_wawancara)->format('d-m-Y') : '-')
            ->addColumn('waktu_wawancara', fn($row) => $row->waktu_wawancara ? substr($row->waktu_wawancara, 0, 5) : '-')
            ->addColumn('status_kehadiran', fn($row) => $row->status_kehadiran ?? 'Belum hadir')
            ->addColumn('aksi', function ($row) {
                $edit   = route('admin.staff.edit', $row->id);
                $delete = route('admin.staff.delete', $row->id);
                if($row->status_kehadiran == 'tidak hadir'){
                    return "
                        <a href='$edit' class='btn btn-sm btn-warning'>Edit</a>
                        <form action='$delete' method='POST' style='display:inline-block;'>
                            " . csrf_field() . method_field('DELETE') . "
                            <button type='submit' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin hapus?\")'>Hapus</button>
                        </form>
                    ";
                }else{
                    return "<span class='badge badge-success'>Pendaftar Hadir</span>";
                }
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function export()
    {
        return Excel::download(new ScheduleExport, 'Schedules.xlsx');
    }

    public function trash()
    {
        $staff = Staff::withTrashed()->with(['user', 'applicant'])->get();
        return view('admin.staff.trash', compact('staff'));
    }

    public function restore($id)
    {
        $staff = Staff::onlyTrashed()->findOrFail($id);
        $staff->restore();

        return redirect()->route('admin.staff.trash')->with('success', 'Data berhasil dipulihkan!');
    }

    public function deletePermanent($id)
    {
        $staff = Staff::onlyTrashed()->findOrFail($id);
        $staff->forceDelete();

        return redirect()->route('admin.staff.trash')->with('success', 'Data berhasil dihapus permanen!');
    }
}
