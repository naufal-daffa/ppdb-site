<?php

namespace App\Http\Controllers;

use App\Exports\MajorExport;
use App\Models\Major;
use App\Models\SkillField;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class MajorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $majors = Major::all();
        return view('admin.majors.index', compact('majors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $skillFields = SkillField::all();
        return view('admin.majors.create', compact('skillFields'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'skill-field-id' => 'required',
            'nama' => 'required',
            'deskripsi' => 'required|min:4'
        ], [
            'skill-field-id.required' => 'Bidang Keahlian wajib diisi!',
            'nama.required' => 'Nama Jurusan wajib diisi!',
            'deskripsi.required' => 'Deskripsi jurusan wajib diisi!',
            'deskripsi.min:10' => 'Deskripsi jurusan minimal 4 karakter!',
        ]);
        $createMajor = Major::create([
            'skill_field_id' => $request['skill-field-id'],
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);
        if ($createMajor) {
            return redirect()->route('admin.majors.index')->with('success', 'Berhasil membuat data!');
        } else {
            return redirect()->back()->with('error', 'Gagal! silahkan coba lagi');
        };
    }

    /**
     * Display the specified resource.
     */
    public function show(Major $major)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $major = Major::where('id', $id)->with(['skillField'])->first();
        return view('admin.majors.edit', compact('major'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Major $major, $id)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required|min:4'
        ], [
            'nama.required' => 'Nama Jurusan wajib diisi!',
            'deskripsi.required' => 'Deskripsi jurusan wajib diisi!',
            'deskripsi.min:10' => 'Deskripsi jurusan minimal 4 karakter!',
        ]);
        $updateMajor = Major::where('id', $id)->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);
        if ($updateMajor) {
            return redirect()->route('admin.majors.index')->with('success', 'Berhasil membuat data!');
        } else {
            return redirect()->back()->with('error', 'Gagal! silahkan coba lagi');
        };
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Major $major, $id)
    {
        $deleteMajor = Major::where('id', $id)->delete();
        // $major = SkillField::where('skill-field-id', $id)->count();
        // if ($major) {
        //     return redirect()->route('admin.majors.index')->with('error', 'Tidak dapat menghapus data bioskop! Data tertaut fengan jadwal tayang');
        // }
        if ($deleteMajor) {
            return redirect()->route('admin.majors.index')->with('success', 'Data berhasil dihapus!');
        } else {
            return redirect()->back()->with('failed', 'Gagal! silahkan coba lagi');
        }
    }



    public function dataForDatatables()
    {
        $majors = Major::with(['skillField'])->get();
        return DataTables::of($majors)
            ->addIndexColumn()
            ->addColumn('skill-field', function ($data) {
                return $data->skillField->nama;
            })
            ->addColumn('buttons', function ($data) {
                $btnEdit = '<a href="' . route('admin.majors.edit', $data->id) . '" class="btn btn-primary">Edit</a>';
                $btnDelete = '<form action="' . route('admin.majors.delete', $data->id) . '" method="POST">' .
                    csrf_field() .
                    method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger">Hapus</button>
                    </form>';
                return '<div class="d-flex justify-content-center gap-3">' . $btnEdit . $btnDelete . '</div>';
            })
            ->rawColumns(['skill-field', 'buttons'])
            ->make(true);
    }
    public function trash()
    {
        $majors = Major::onlyTrashed()->with('skillField')->get();
        return view('admin.majors.trash', compact('majors'));
    }

    public function restore($id)
    {
        $major = Major::onlyTrashed()->findOrFail($id);
        $major->restore();

        return redirect()->route('admin.majors.trash')->with('success', 'Data berhasil dipulihkan!');
    }

    public function deletePermanent($id)
    {
        $major = Major::onlyTrashed()->findOrFail($id);
        $major->forceDelete();

        return redirect()->route('admin.majors.trash')->with('success', 'Data berhasil dihapus permanen!');
    }
    public function export()
    {
        return Excel::download(new MajorExport, 'majors.xlsx');
    }
}
