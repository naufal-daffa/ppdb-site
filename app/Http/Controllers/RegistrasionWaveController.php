<?php

namespace App\Http\Controllers;

// use App\Models\RegistrasionWave;

use App\Exports\RegistrasionWaveExport;
use App\Models\RegistrationWave;
use Illuminate\Http\Request;
use App\Models\RegistrasionWave;
use Maatwebsite\Excel\Facades\Excel;
use Psy\CodeCleaner\ReturnTypePass;
use Yajra\DataTables\Facades\DataTables;

class RegistrasionWaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registrasionWave = RegistrationWave::all();
        return view('admin.registrasion-waves.index', compact('registrasionWave'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.registrasion-waves.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_gelombang' => 'required|min:8',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required|after:tanggal_mulai',
        ], [
            'nama_gelombang.required' => 'Nama Gelombang Wajib diisi!',
            'nama_gelombang.min' => 'Minimal berisi 8 karakter!',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi!',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi!',
            'tanggal_selesai.after' => 'Tanggal selesai wajib bertanggal setelah tanggal mulai!',
        ]);

        $registrasionWave = RegistrationWave::create([
            'nama_gelombang' => $request->nama_gelombang,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'aktif' => 1
        ]);

        if ($registrasionWave) {
            return redirect()->route('admin.registrasion-waves.index')->with('success', 'Berhasil menambahkan data');
        } else {
            return redirect()->back()->with('error', 'Gagal! silahkan coba lagi');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RegistrationWave $registrasionWave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RegistrationWave $registrasionWave, $id)
    {
        $registrasionWave = RegistrationWave::where('id', $id)->first();
        // dd($registrasionWave);
        return view('admin.registrasion-waves.edit', compact('registrasionWave'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RegistrationWave $registrasionWave, $id)
    {
        $request->validate([
            'nama_gelombang' => 'required|min:8',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required|after:tanggal_mulai',
        ], [
            'nama_gelombang.required' => 'Nama Gelombang Wajib diisi!',
            'nama_gelombang.min' => 'Minimal berisi 8 karakter!',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi!',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi!',
            'tanggal_selesai.after' => 'Tanggal selesai wajib bertanggal setelah tanggal mulai!',
        ]);

        $registrasionWave = RegistrationWave::where('id', $id)->update([
            'nama_gelombang' => $request->nama_gelombang,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        if ($registrasionWave) {
            return redirect()->route('admin.registrasion-waves.index')->with('success', 'Berhasil mengubah data');
        } else {
            return redirect()->back()->with('error', 'Gagal! silahkan coba lagi');
        }
    }

    public function patch($id)
    {
        $registrasionWaves = RegistrationWave::findOrFail($id);
        if ($registrasionWaves->aktif == 1) {
            $registrasionWaves->aktif = 0;
            $registrasionWaves = $registrasionWaves->save();

            if ($registrasionWaves) {
                return redirect()->route('admin.registrasion-waves.index')->with('success', 'Film berhasil dinonaktifkan');
            } else {
                return redirect()->back()->with('error', 'Gagal! silahkan coba lagi');
            }
        } else {
            $registrasionWaves->aktif = 1;
            $registrasionWaves = $registrasionWaves->save();

            if ($registrasionWaves) {
                return redirect()->route('admin.registrasion-waves.index')->with('success', 'Film berhasil diaktifkan');
            } else {
                return redirect()->back()->with('error', 'Gagal! silahkan coba lagi');
            }
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RegistrationWave $registrasionWave, $id)
    {
        $deleteRegistrasionWave = RegistrationWave::where('id', $id)->delete();
        if ($deleteRegistrasionWave) {
            return redirect()->route('admin.registrasion-waves.index')->with('success', 'Data berhasil dihapus!');
        } else {
            return redirect()->back()->with('failed', 'Gagal! silahkan coba lagi');
        }
    }

    public function dataForDatatables()
    {
        $registrationWaves = RegistrationWave::query();
        return DataTables::of($registrationWaves)
            ->addIndexColumn()
            ->addcolumn('activeBadge', function ($data) {
                if ($data->aktif == 1) {
                    return '<div class="badge badge-success">Aktif</div>';
                } else {
                    return '<div class="badge badge-danger">Tidak Aktif</div>';
                }
            })
            ->addColumn('buttons', function ($data) {
                $btnEdit = '<a href="' . route('admin.registrasion-waves.edit', $data->id) . '" class="btn btn-primary">Edit</a>';
                $btnDelete = '<form action="' . route('admin.registrasion-waves.delete', $data->id) . '" method="POST">' .
                    csrf_field() .
                    method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger">Hapus</button>
                        </form>';
                $btnNonAktif = '';
                $btnAktif = '';
                if ($data->aktif == 1) {
                    $btnNonAktif = '<form action="' . route('admin.registrasion-waves.patch', $data->id) . '" method="POST">' .
                        csrf_field() .
                        method_field('PATCH') .
                        '<button type="submit" class="btn btn-warning">Non-Aktifkan Gelombang</button>' .
                        '</form>';
                } else {
                    $btnAktif = '<form action="' . route('admin.registrasion-waves.patch', $data->id) . '" method="POST">' .
                        csrf_field() .
                        method_field('PATCH') .
                        '<button type="submit" class="btn btn-warning">Aktifkan Gelombang</button>' .
                        '</form>';
                }
                return '<div class="d-flex justify-content-center gap-3">' . $btnNonAktif . $btnAktif . $btnEdit . $btnDelete . '</div>';
            })
            ->rawColumns(['activeBadge', 'buttons'])
            ->make(true);
    }
    public function trash()
    {
        $registrasionWaves = registrationWave::onlyTrashed()->get();
        return view('admin.registrasion-waves.trash', compact('registrasionWaves'));
    }

    public function restore($id)
    {
        $registrasionWave = registrationWave::onlyTrashed()->findOrFail($id);
        $registrasionWave->restore();

        return redirect()->route('admin.registrasion-waves.trash')->with('success', 'Data berhasil dipulihkan!');
    }

    public function forceDelete($id)
    {
        $registrasionWave = registrationWave::onlyTrashed()->findOrFail($id);
        $registrasionWave->forceDelete();

        return redirect()->route('admin.registrasion-waves.trash')->with('success', 'Data berhasil dihapus permanen!');
    }
    public function export()
    {
        return Excel::download(new RegistrasionWaveExport, 'registrasion-waves.xlsx');
    }
}
