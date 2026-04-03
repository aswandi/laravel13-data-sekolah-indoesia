<?php

namespace App\Http\Controllers;

use App\Models\SekolahDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class WilayahController extends Controller
{
    /**
     * Homepage - show all provinces with stats
     */
    public function index()
    {
        $provinsiData = Cache::remember('provinsi_stats', 3600, function () {
            return DB::table('sekolah_detail')
                ->select(
                    'provinsi',
                    DB::raw('COUNT(*) as total_sekolah'),
                    DB::raw("SUM(CASE WHEN status_sekolah = 'NEGERI' THEN 1 ELSE 0 END) as total_negeri"),
                    DB::raw("SUM(CASE WHEN status_sekolah = 'SWASTA' THEN 1 ELSE 0 END) as total_swasta"),
                    DB::raw("SUM(CASE WHEN bentuk_pendidikan IN ('SD','MI','SPK SD') THEN 1 ELSE 0 END) as total_sd"),
                    DB::raw("SUM(CASE WHEN bentuk_pendidikan IN ('SMP','SPK SMP') THEN 1 ELSE 0 END) as total_smp"),
                    DB::raw("SUM(CASE WHEN bentuk_pendidikan IN ('SMA','SMK','SMAg.K','SPK SMA') THEN 1 ELSE 0 END) as total_sma_smk"),
                    DB::raw('AVG(lintang) as avg_lat'),
                    DB::raw('AVG(bujur) as avg_lng')
                )
                ->groupBy('provinsi')
                ->orderBy('provinsi')
                ->get();
        });

        $totalSekolah = $provinsiData->sum('total_sekolah');
        $totalNegeri = $provinsiData->sum('total_negeri');
        $totalSwasta = $provinsiData->sum('total_swasta');

        return view('wilayah.index', compact('provinsiData', 'totalSekolah', 'totalNegeri', 'totalSwasta'));
    }

    /**
     * Show kabupaten/kota in a province with stats
     */
    public function provinsi($provinsi)
    {
        $provinsi = urldecode($provinsi);

        $kabupatenData = Cache::remember('kab_' . md5($provinsi), 3600, function () use ($provinsi) {
            return DB::table('sekolah_detail')
                ->select(
                    'kabupaten',
                    DB::raw('COUNT(*) as total_sekolah'),
                    DB::raw("SUM(CASE WHEN status_sekolah = 'NEGERI' THEN 1 ELSE 0 END) as total_negeri"),
                    DB::raw("SUM(CASE WHEN status_sekolah = 'SWASTA' THEN 1 ELSE 0 END) as total_swasta"),
                    DB::raw("SUM(CASE WHEN bentuk_pendidikan IN ('SD','MI','SPK SD') THEN 1 ELSE 0 END) as total_sd"),
                    DB::raw("SUM(CASE WHEN bentuk_pendidikan IN ('SMP','SPK SMP') THEN 1 ELSE 0 END) as total_smp"),
                    DB::raw("SUM(CASE WHEN bentuk_pendidikan IN ('SMA','SMK','SMAg.K','SPK SMA') THEN 1 ELSE 0 END) as total_sma_smk"),
                    DB::raw('AVG(lintang) as avg_lat'),
                    DB::raw('AVG(bujur) as avg_lng')
                )
                ->where('provinsi', $provinsi)
                ->groupBy('kabupaten')
                ->orderBy('kabupaten')
                ->get();
        });

        $totalSekolah = $kabupatenData->sum('total_sekolah');

        return view('wilayah.provinsi', compact('provinsi', 'kabupatenData', 'totalSekolah'));
    }

    /**
     * Show kecamatan in a kabupaten/kota with stats
     */
    public function kabupaten($provinsi, $kabupaten)
    {
        $provinsi = urldecode($provinsi);
        $kabupaten = urldecode($kabupaten);

        $kecamatanData = Cache::remember('kec_' . md5($provinsi . $kabupaten), 3600, function () use ($provinsi, $kabupaten) {
            return DB::table('sekolah_detail')
                ->select(
                    'kecamatan',
                    DB::raw('COUNT(*) as total_sekolah'),
                    DB::raw("SUM(CASE WHEN status_sekolah = 'NEGERI' THEN 1 ELSE 0 END) as total_negeri"),
                    DB::raw("SUM(CASE WHEN status_sekolah = 'SWASTA' THEN 1 ELSE 0 END) as total_swasta"),
                    DB::raw("SUM(CASE WHEN bentuk_pendidikan IN ('SD','MI','SPK SD') THEN 1 ELSE 0 END) as total_sd"),
                    DB::raw("SUM(CASE WHEN bentuk_pendidikan IN ('SMP','SPK SMP') THEN 1 ELSE 0 END) as total_smp"),
                    DB::raw("SUM(CASE WHEN bentuk_pendidikan IN ('SMA','SMK','SMAg.K','SPK SMA') THEN 1 ELSE 0 END) as total_sma_smk"),
                    DB::raw('AVG(lintang) as avg_lat'),
                    DB::raw('AVG(bujur) as avg_lng')
                )
                ->where('provinsi', $provinsi)
                ->where('kabupaten', $kabupaten)
                ->groupBy('kecamatan')
                ->orderBy('kecamatan')
                ->get();
        });

        $totalSekolah = $kecamatanData->sum('total_sekolah');

        return view('wilayah.kabupaten', compact('provinsi', 'kabupaten', 'kecamatanData', 'totalSekolah'));
    }

    /**
     * Show schools in a kecamatan with maps
     */
    public function kecamatan($provinsi, $kabupaten, $kecamatan)
    {
        $provinsi = urldecode($provinsi);
        $kabupaten = urldecode($kabupaten);
        $kecamatan = urldecode($kecamatan);

        $sekolahList = SekolahDetail::with('statistik')
            ->where('provinsi', $provinsi)
            ->where('kabupaten', $kabupaten)
            ->where('kecamatan', $kecamatan)
            ->orderBy('nama')
            ->paginate(20);

        $stats = Cache::remember('stats_kec_' . md5($provinsi . $kabupaten . $kecamatan), 3600, function () use ($provinsi, $kabupaten, $kecamatan) {
            return DB::table('sekolah_detail')
                ->select(
                    DB::raw('COUNT(*) as total_sekolah'),
                    DB::raw("SUM(CASE WHEN status_sekolah = 'NEGERI' THEN 1 ELSE 0 END) as total_negeri"),
                    DB::raw("SUM(CASE WHEN status_sekolah = 'SWASTA' THEN 1 ELSE 0 END) as total_swasta"),
                    DB::raw("SUM(CASE WHEN bentuk_pendidikan IN ('SD','MI','SPK SD') THEN 1 ELSE 0 END) as total_sd"),
                    DB::raw("SUM(CASE WHEN bentuk_pendidikan IN ('SMP','SPK SMP') THEN 1 ELSE 0 END) as total_smp"),
                    DB::raw("SUM(CASE WHEN bentuk_pendidikan IN ('SMA','SMK','SMAg.K','SPK SMA') THEN 1 ELSE 0 END) as total_sma_smk")
                )
                ->where('provinsi', $provinsi)
                ->where('kabupaten', $kabupaten)
                ->where('kecamatan', $kecamatan)
                ->first();
        });

        // Get all school coordinates for map
        $mapMarkers = DB::table('sekolah_detail')
            ->select('nama', 'lintang', 'bujur', 'bentuk_pendidikan', 'status_sekolah', 'npsn')
            ->where('provinsi', $provinsi)
            ->where('kabupaten', $kabupaten)
            ->where('kecamatan', $kecamatan)
            ->whereNotNull('lintang')
            ->whereNotNull('bujur')
            ->where('lintang', '!=', 0)
            ->where('bujur', '!=', 0)
            ->get();

        return view('wilayah.kecamatan', compact(
            'provinsi', 'kabupaten', 'kecamatan',
            'sekolahList', 'stats', 'mapMarkers'
        ));
    }

    /**
     * School detail page with map location
     */
    public function sekolah($npsn)
    {
        $sekolah = SekolahDetail::with(['statistik', 'kepalaSekolah'])
            ->where('npsn', $npsn)
            ->firstOrFail();

        return view('wilayah.sekolah', compact('sekolah'));
    }

    /**
     * API endpoint for search
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 3) {
            return response()->json([]);
        }

        $results = SekolahDetail::where('nama', 'like', "%{$query}%")
            ->orWhere('npsn', 'like', "%{$query}%")
            ->select('nama', 'npsn', 'provinsi', 'kabupaten', 'kecamatan', 'bentuk_pendidikan')
            ->limit(15)
            ->get();

        return response()->json($results);
    }

    /**
     * Sitemap XML for SEO
     */
    public function sitemap()
    {
        $provinsiList = DB::table('sekolah_detail')
            ->select('provinsi')
            ->distinct()
            ->orderBy('provinsi')
            ->get();

        return response()->view('sitemap', compact('provinsiList'))
            ->header('Content-Type', 'text/xml');
    }
}
