<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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

        $applicantsYangSudahAdaJadwal = Staff::withTrashed()
            ->whereNotNull('applicant_id')
            ->pluck('applicant_id')
            ->toArray();

        $applicants = Applicant::with('user')
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
    public function edit(Staff $staff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staff $staff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        //
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
                return "
                    <a href='$edit' class='btn btn-sm btn-warning'>Edit</a>
                    <form action='$delete' method='POST' style='display:inline-block;'>
                        " . csrf_field() . method_field('DELETE') . "
                        <button type='submit' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin hapus?\")'>Hapus</button>
                    </form>
                ";
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
