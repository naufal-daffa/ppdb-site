<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\RegistrationWave;
use App\Models\Major;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display dashboard statistics and charts
     */
    public function index()
    {
        // Get all applicants with their status
        $totalApplicants = Applicant::count();
        $totalDiterima = Applicant::where('status_pendaftaran', 'diterima')->count();
        $totalMenunggu = Applicant::where('status_pendaftaran', 'menunggu')->count();
        $totalDitolak = Applicant::where('status_pendaftaran', 'ditolak')->count();
        $totalDiverifikasi = Applicant::where('status_pendaftaran', 'diverifikasi')->count();

        // Get registration waves data with all applicants count
        $gelombang = RegistrationWave::withCount(['applicants'])
            ->orderBy('id')
            ->get()
            ->map(function ($wave) {
                return [
                    'nama_gelombang' => $wave->nama_gelombang ?? 'Gelombang ' . $wave->id,
                    'total' => $wave->applicants_count
                ];
            })
            ->toArray();

        // PERBAIKAN: Gunakan query langsung seperti di chartJurusan()
        $jurusanPertama = Major::select('majors.*')
            ->selectRaw('COUNT(applicant_major_choices.applicant_id) as total')
            ->leftJoin('applicant_major_choices', function($join) {
                $join->on('majors.id', '=', 'applicant_major_choices.major_id')
                     ->where('applicant_major_choices.priority', '=', 1);
            })
            ->groupBy('majors.id')
            ->havingRaw('COUNT(applicant_major_choices.applicant_id) > 0')
            ->orderBy('total', 'desc')
            ->get()
            ->map(function ($major) {
                return [
                    'nama_jurusan' => $major->nama,
                    'skill_field' => $major->skillField->nama ?? 'Tidak ada',
                    'total' => $major->total
                ];
            })
            ->toArray();

        return view('admin.dashboard', compact(
            'gelombang',
            'jurusanPertama',
            'totalApplicants',
            'totalDiterima',
            'totalMenunggu',
            'totalDitolak',
            'totalDiverifikasi'
        ));
    }

    /**
     * Get chart data for gelombang (registration waves) - BAR CHART
     */
    public function chartGelombang()
    {
        $gelombang = RegistrationWave::withCount(['applicants'])
            ->orderBy('id')
            ->get();

        $labels = [];
        $data = [];

        foreach ($gelombang as $wave) {
            $labels[] = $wave->nama_gelombang ?? 'Gelombang ' . $wave->id;
            $data[] = $wave->applicants_count;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'colors' => ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6']
        ]);
    }

    /**
     * Get chart data for applicant status - PIE CHART
     */
    public function chartStatusPendaftaran()
    {
        $statusCounts = [
            'diterima' => Applicant::where('status_pendaftaran', 'diterima')->count(),
            'menunggu' => Applicant::where('status_pendaftaran', 'menunggu')->count(),
            'ditolak' => Applicant::where('status_pendaftaran', 'ditolak')->count(),
            'diverifikasi' => Applicant::where('status_pendaftaran', 'diverifikasi')->count(),
        ];

        // Filter out status with 0 count
        $labels = [];
        $data = [];

        foreach ($statusCounts as $status => $count) {
            if ($count > 0) {
                $labels[] = ucfirst($status);
                $data[] = $count;
            }
        }
        
        $statusColors = [
            'diterima' => '#10b981', // Green
            'menunggu' => '#f59e0b', // Yellow
            'ditolak' => '#ef4444',  // Red
            'diverifikasi' => '#3b82f6', // Blue
        ];

        $colors = [];
        foreach ($labels as $label) {
            $statusKey = strtolower($label);
            $colors[] = $statusColors[$statusKey] ?? '#6b7280';
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'colors' => $colors
        ]);
    }

    /**
     * Get chart data for majors (priority 1) - Optional PIE CHART
     */
    public function chartJurusan()
    {
        // Gunakan query yang sama dengan method index()
        $jurusanPertama = Major::select('majors.*')
            ->selectRaw('COUNT(applicant_major_choices.applicant_id) as total')
            ->leftJoin('applicant_major_choices', function($join) {
                $join->on('majors.id', '=', 'applicant_major_choices.major_id')
                     ->where('applicant_major_choices.priority', '=', 1);
            })
            ->groupBy('majors.id')
            ->havingRaw('COUNT(applicant_major_choices.applicant_id) > 0')
            ->orderBy('total', 'desc')
            ->get();

        $labels = [];
        $data = [];

        foreach ($jurusanPertama as $major) {
            $labels[] = $major->nama;
            $data[] = $major->total;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'colors' => $this->generateColors(count($labels))
        ]);
    }

    /**
     * Get statistics summary
     */
    public function getStatistics()
    {
        return response()->json([
            'total' => Applicant::count(),
            'diterima' => Applicant::where('status_pendaftaran', 'diterima')->count(),
            'menunggu' => Applicant::where('status_pendaftaran', 'menunggu')->count(),
            'ditolak' => Applicant::where('status_pendaftaran', 'ditolak')->count(),
            'diverifikasi' => Applicant::where('status_pendaftaran', 'diverifikasi')->count(),
        ]);
    }

    /**
     * Generate random colors for charts
     */
    private function generateColors($count)
    {
        $colors = [];
        $palette = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#14b8a6', '#f97316'];

        for ($i = 0; $i < $count; $i++) {
            $colors[] = $palette[$i % count($palette)] ?? sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        }
        return $colors;
    }
}
