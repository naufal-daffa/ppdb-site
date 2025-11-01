<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Models\Applicant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::whereIn('role', ['admin', 'staff'])->get();
        return view('admin.users.index', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:8',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ], [
            'nama.required' => 'Nama Pengguna Wajib diisi!',
            'nama.min' => 'Nama Minimal berisi 8 karakter!',
            'email.required' => 'Email mulai wajib diisi!',
            'password.required' => 'Password wajib diisi!',
            'password.min' => 'Password Minimal berisi 8 karakter!',
        ]);

        $users = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'staff'
        ]);

        if($users){
            return redirect()->route('admin.users.index')->with('success', 'Berhasil menambahkan data');
        }else{
            return redirect()->back()->with('error', 'Gagal menambahkan data!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, $id)
    {
        $user = User::where('id', $id)->delete();

        if($user){
            return redirect()->route('admin.users.index')->with('success', 'Berhasil menghapus data');
        }else{
            return redirect()->back()->with('error', 'Gagal menghapus data');
        }
    }

    public function login(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required',
                'password' => 'required'
            ],
            [
                'nama.required' => 'Email wajib diisi',
                'password.required' => 'Password wajib diisi'
            ]
        );

        $data = $request->only(['nama', 'password']);


        if (Auth::attempt($data)) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Login Berhasil dilakukan!');
            } elseif (Auth::user()->role == 'staff') {
                return redirect()->route('staff.dashboard')->with('login', 'Login Berhasil dilakukan!');
            } else {
                return redirect()->route('applicants.index')->with('success', 'Login berhasil dilakukan!');
            }
        } else {
            return redirect()->back()->with('error', 'Gagal login! Coba lagi');
        };
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home')->with('logout', 'Anda berhasil logout! Silahkan login kembali untuk akses lengkap');
    }

    public function dataForDatatables(){
        $users = User::whereIn('role', ['admin', 'staff'])->get();
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('roleBadge', function($data){
                if($data->role == 'admin'){
                    return '<div class="badge badge-success">Admin</div>';
                }else{
                    return '<div class="badge badge-info">Staff</div>';
                }
            })
            ->addColumn('buttons', function ($data) {
                $btnEdit = '<a href="' . route('admin.users.edit', $data->id) . '" class="btn btn-primary">Edit</a>';
                $btnDelete = '<form action="' . route('admin.users.delete', $data->id) . '" method="POST">' .
                    csrf_field() .
                    method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger">Hapus</button>
                        </form>';
                return '<div class="d-flex justify-content-center gap-3">' . $btnEdit . $btnDelete . '</div>';
            })
            ->rawColumns(['roleBadge','buttons'])
            ->make(true);
    }
    public function trash()
    {
        $users = User::onlyTrashed()->get();
        return view('admin.users.trash', compact('users'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('admin.users.trash')->with('success', 'Data berhasil dipulihkan!');
    }

    public function deletePermanent($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();

        return redirect()->route('admin.users.trash')->with('success', 'Data berhasil dihapus permanen!');
    }
    public function export()
    {
        return Excel::download(new UserExport, 'users.xlsx');
    }

}
