<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;

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
        $users = User::all();
        $applicants = Applicant::where('status_verifikasi', 'diterima')->get();
        // dd($applicants);

        $staff = Staff::with(['user', 'applicant'])->get();
        return view('admin.staff.create', compact('users', 'applicants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required',
            'applicant_id' => 'required',
            'tanggal_wawancara' => 'required|date',
            'waktu_wawancara' => 'required',
        ], [

        ]);

        $staff = Staff::create([
            'user_id' => $request->staff_id,
            'applicant_id' => $request->applicant_id,
            'tanggal_wawancara' => $request->tanggal_wawancara,
            'waktu_wawancara' => $request->waktu_wawancara,
        ]);

        if($staff){
            return redirect()->route('admin.staff.index')->with('success', 'Berhasil Menambahkan data!');
        }else{
            return redirect()->back()->with('error', 'Gagal! Silahkan coba lagi');
        }
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
}
