<?php

namespace App\Http\Controllers;

use App\Models\AdmissionPath;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class AdmissionPathController extends Controller
{
    public function index()
    {
        return view('admin.admission-paths.index');
    }

    public function create()
    {
        return view('admin.admission-paths.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'prestasi' => 'required|min:3|max:100|unique:admission_paths,prestasi'
        ]);

        AdmissionPath::create($request->only('prestasi'));

        return redirect()->route('admin.admission-paths.index')
            ->with('success', 'Jalur pendaftaran berhasil ditambahkan');
    }

    public function edit($id)
    {
        $admissionPath = AdmissionPath::findOrFail($id);
        return view('admin.admission-paths.edit', compact('admissionPath'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'prestasi' => 'required|min:3|max:100|unique:admission_paths,prestasi,' . $id
        ]);

        $admissionPath = AdmissionPath::findOrFail($id);
        $admissionPath->update($request->only('prestasi'));

        return redirect()->route('admin.admission-paths.index')
            ->with('success', 'Jalur pendaftaran berhasil diupdate');
    }

    public function destroy($id)
    {
        $admissionPath = AdmissionPath::findOrFail($id);
        $admissionPath->delete();

        return redirect()->route('admin.admission-paths.index')
            ->with('success', 'Jalur pendaftaran berhasil dihapus');
    }

    public function restore($id)
    {
        $admissionPath = AdmissionPath::onlyTrashed()->findOrFail($id);
        $admissionPath->restore();

        return redirect()->route('admin.admission-paths.trash')
            ->with('success', 'Data berhasil dipulihkan');
    }

    public function trash()
    {
        $admissionPaths = AdmissionPath::onlyTrashed()->get();
        return view('admin.admission-paths.trash', compact('admissionPaths'));
    }

    public function deletePermanent($id)
    {
        $admissionPath = AdmissionPath::onlyTrashed()->findOrFail($id);
        $admissionPath->forceDelete();

        return redirect()->route('admin.admission-paths.trash')
            ->with('success', 'Data berhasil dihapus permanen');
    }

    public function dataForDatatables()
    {
        $admissionPaths = AdmissionPath::query();

        return DataTables::of($admissionPaths)
            ->addIndexColumn()
            ->addColumn('applicants_count', function ($data) {
                return $data->applicants()->count();
            })
            ->addColumn('buttons', function ($data) {
                $btnEdit = '<a href="' . route('admin.admission-paths.edit', $data->id) . '"
                           class="btn btn-primary btn-sm">Edit</a>';

                $btnDelete = '<form action="' . route('admin.admission-paths.delete', $data->id) . '"
                             method="POST" class="d-inline">
                             ' . csrf_field() . '
                             ' . method_field('DELETE') . '
                             <button type="submit" class="btn btn-danger btn-sm"
                                     onclick="return confirm(\'Yakin ingin menghapus?\')">
                                 Hapus
                             </button>
                             </form>';

                return '<div class="d-flex gap-2">' . $btnEdit . $btnDelete . '</div>';
            })
            ->rawColumns(['buttons'])
            ->make(true);
    }

    public function export()
    {
        return Excel::download(new AdmissionPathExport, 'admission-paths.xlsx');
    }
}
