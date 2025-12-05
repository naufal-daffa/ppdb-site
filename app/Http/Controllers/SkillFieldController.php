<?php

namespace App\Http\Controllers;

use App\Models\SkillField;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SkillFieldExport;

class SkillFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skillField = SkillField::all();
        return view('admin.skill-fields.index', compact('skillField'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.skill-fields.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required|min:10'
        ], [
            'nama.required' => 'Nama bioskop wajib diisi!',
            'deskripsi.required' => 'Lokasi bioskop wajib diisi!',
            'deskripsi.min:10' => 'Lokasi bioskop minimal 10 karakter!',
        ]);
        $createSkillField = SkillField::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);
        if ($createSkillField) {
            return redirect()->route('admin.skill-fields.index')->with('success', 'Berhasil membuat data!');
        } else {
            return redirect()->back()->with('error', 'Gagal! silahkan coba lagi');
        };
    }

    /**
     * Display the specified resource.
     */
    public function show(SkillField $skillField)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SkillField $skillField, $id)
    {
        $skillField = SkillField::where('id', $id)->first();
        // dd($skillField);
        return view('admin.skill-fields.edit', compact('skillField'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required|min:10'
        ], [
            'nama.required' => 'Nama bidang keahlian wajib diisi!',
            'deskripsi.required' => 'Lokasi bidang keahlian wajib diisi!',
            'deskripsi.min:10' => 'Lokasi bidang keahlian minimal 10 karakter!',
        ]);

        $updateSkillField = SkillField::where('id', $id)->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        if ($updateSkillField) {
            return redirect()->route('admin.skill-fields.index')->with('success', 'Berhasil membuat data!');
        } else {
            return redirect()->back()->with('error', 'Gagal! silahkan coba lagi');
        };
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SkillField $skillField, $id)
    {
        $deleteSkillField = SkillField::where('id', $id)->delete();
        if ($deleteSkillField) {
            return redirect()->route('admin.skill-fields.index')->with('success', 'Data berhasil dihapus!');
        } else {
            return redirect()->back()->with('failed', 'Gagal! silahkan coba lagi');
        }
    }
    public function dataForDatatables()
    {
        $skillFields = SkillField::query();
        return DataTables::of($skillFields)
            ->addIndexColumn()
            ->addColumn('buttons', function ($data) {
                $btnEdit = '<a href="' . route('admin.skill-fields.edit', $data->id) . '" class="btn btn-primary">Edit</a>';
                $btnDelete = '<form action="' . route('admin.skill-fields.delete', $data->id) . '" method="POST">' .
                    csrf_field() .
                    method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger">Hapus</button>
                        </form>';
                return '<div class="d-flex justify-content-center gap-3">' . $btnEdit . $btnDelete . '</div>';
            })
            ->rawColumns(['buttons'])
            ->make(true);
    }
    public function export()
    {
        return Excel::download(new SkillFieldExport, 'skill-fields.xlsx');
    }
    public function trash()
    {
        $skillField = SkillField::onlyTrashed()->get();
        return view('admin.skill-fields.trash', compact('skillField'));
    }
    public function restore($id)
    {
        $skillField = SkillField::onlyTrashed()->findOrFail($id);
        $skillField->restore();

        return redirect()->route('admin.skill-fields.trash')->with('success', 'Data berhasil dipulihkan!');
    }

    public function deletePermanent($id)
    {
        $skillField = SkillField::onlyTrashed()->findOrFail($id);
        $skillField->forceDelete();

        return redirect()->route('admin.skill-fields.trash')->with('success', 'Data berhasil dihapus permanen!');
    }
}
