<?php

namespace App\Http\Controllers;

use App\Models\Kematian;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KematianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $filterBulan = $request->bulan;
        $filterTahun = $request->tahun;
        $filterPenyebab = $request->penyebab;

        $query = Kematian::with(['penduduk', 'pelapor'])->latest();

        // Search
        if ($search) {
            $query->search($search);
        }

        // Filter bulan
        if ($filterBulan) {
            $query->whereMonth('tanggal_kematian', $filterBulan);
        }

        // Filter tahun
        if ($filterTahun) {
            $query->whereYear('tanggal_kematian', $filterTahun);
        }

        // Filter penyebab
        if ($filterPenyebab) {
            $query->where('penyebab_kematian', $filterPenyebab);
        }

        $kematians = $query->paginate(10);

        // Statistik
        $totalKematian = Kematian::count();
        $kematianBulanIni = Kematian::bulanIni()->count();
        $kematianHariIni = Kematian::whereDate('tanggal_kematian', today())->count();

        return view('kematian.index', compact(
            'kematians',
            'totalKematian',
            'kematianBulanIni',
            'kematianHariIni',
            'search',
            'filterBulan',
            'filterTahun',
            'filterPenyebab'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
    // Ambil penduduk yang masih hidup
    $penduduks = Penduduk::hidup()
        ->orderBy('first_name')
        ->get(['id', 'nik', 'first_name', 'last_name', 'birthday', 'gender']);

    // Ambil penduduk_id dari request jika ada
    $selectedPenduduk = null;
    if (request('penduduk_id')) {
        $selectedPenduduk = Penduduk::hidup()->find(request('penduduk_id'));
    }

    return view('kematian.create', compact('penduduks', 'selectedPenduduk'));
}
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'penduduk_id' => 'required|exists:penduduks,id',
            'tanggal_kematian' => 'required|date|before_or_equal:today',
            'tempat_kematian' => 'required|string|max:255',
            'penyebab_kematian' => 'required|in:sakit_biasa,kecelakaan,bunuh_diri,pembunuhan,lainnya',
            'keterangan_penyebab' => 'nullable|string|max:500',
            'dimakamkan_di' => 'required|string|max:255',
            'tanggal_pemakaman' => 'required|date|after_or_equal:tanggal_kematian',
            'status_pencatatan' => 'required|in:sementara,permanen',
            'catatan_tambahan' => 'nullable|string',
            'surat_kematian_no' => 'nullable|string|max:50|unique:kematians,surat_kematian_no',
            'surat_kematian_tanggal' => 'nullable|date|before_or_equal:today',
        ]);

        // Cek apakah penduduk sudah tercatat meninggal
        if (Kematian::isPendudukMeninggal($request->penduduk_id)) {
            return back()->withErrors(['penduduk_id' => 'Penduduk ini sudah tercatat meninggal.']);
        }

        // Tambahkan user yang melaporkan
        $validated['dilaporkan_oleh'] = Auth::id();

        Kematian::create($validated);

        return redirect()->route('kematian.index')
            ->with('success', 'Data kematian berhasil dicatat!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kematian = Kematian::with(['penduduk', 'pelapor'])->findOrFail($id);

        return view('kematian.show', compact('kematian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kematian = Kematian::findOrFail($id);
        $penduduks = Penduduk::hidup()
            ->orWhere('id', $kematian->penduduk_id) // Include penduduk yang sudah meninggal ini
            ->orderBy('first_name')
            ->get(['id', 'nik', 'first_name', 'last_name', 'birthday', 'gender']);

        return view('kematian.edit', compact('kematian', 'penduduks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kematian = Kematian::findOrFail($id);

        $validated = $request->validate([
            'penduduk_id' => 'required|exists:penduduks,id',
            'tanggal_kematian' => 'required|date|before_or_equal:today',
            'tempat_kematian' => 'required|string|max:255',
            'penyebab_kematian' => 'required|in:sakit_biasa,kecelakaan,bunuh_diri,pembunuhan,lainnya',
            'keterangan_penyebab' => 'nullable|string|max:500',
            'dimakamkan_di' => 'required|string|max:255',
            'tanggal_pemakaman' => 'required|date|after_or_equal:tanggal_kematian',
            'status_pencatatan' => 'required|in:sementara,permanen',
            'catatan_tambahan' => 'nullable|string',
            'surat_kematian_no' => 'nullable|string|max:50|unique:kematians,surat_kematian_no,' . $id,
            'surat_kematian_tanggal' => 'nullable|date|before_or_equal:today',
        ]);

        // Cek apakah ganti penduduk, dan penduduk baru sudah tercatat meninggal
        if ($request->penduduk_id != $kematian->penduduk_id &&
            Kematian::isPendudukMeninggal($request->penduduk_id)) {
            return back()->withErrors(['penduduk_id' => 'Penduduk ini sudah tercatat meninggal.']);
        }

        $kematian->update($validated);

        return redirect()->route('kematian.index')
            ->with('success', 'Data kematian berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kematian = Kematian::findOrFail($id);
        $kematian->delete();

        return redirect()->route('kematian.index')
            ->with('success', 'Data kematian berhasil dihapus!');
    }

    /**
     * Get autocomplete data for penduduk
     */
    public function getPendudukData($id)
    {
        $penduduk = Penduduk::hidup()->find($id);

        if (!$penduduk) {
            return response()->json(['error' => 'Penduduk tidak ditemukan atau sudah meninggal'], 404);
        }

        return response()->json([
            'nik' => $penduduk->nik,
            'nama_lengkap' => $penduduk->first_name . ' ' . $penduduk->last_name,
            'tanggal_lahir' => $penduduk->birthday->format('d/m/Y'),
            'usia' => $penduduk->birthday->age,
            'gender' => $penduduk->gender == 'L' ? 'Laki-laki' : 'Perempuan',
        ]);
    }

    /**
     * Generate report
     */
    public function report(Request $request)
{
    $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
    $endDate = $request->end_date ?? now()->endOfMonth()->format('Y-m-d');
    $penyebab = $request->penyebab;

    $query = Kematian::with('penduduk')
        ->whereBetween('tanggal_kematian', [$startDate, $endDate]);

    if ($penyebab) {
        $query->where('penyebab_kematian', $penyebab);
    }

    // Apply sorting if requested
    if ($request->sort_by) {
        switch ($request->sort_by) {
            case 'nama_penduduk':
                $query->join('penduduks', 'kematians.penduduk_id', '=', 'penduduks.id')
                    ->orderBy('penduduks.first_name')
                    ->orderBy('penduduks.last_name');
                break;
            case 'penyebab_kematian':
                $query->orderBy('penyebab_kematian');
                break;
            case 'tanggal_kematian':
            default:
                $query->orderBy('tanggal_kematian', 'desc');
                break;
        }
    } else {
        $query->orderBy('tanggal_kematian', 'desc');
    }

    $data = $query->get();

    // ===== PERHITUNGAN STATISTIK =====
    $totalData = $data->count();

    // Hitung statistik berdasarkan penyebab
    $sakitBiasaCount = $data->where('penyebab_kematian', 'sakit_biasa')->count();
    $kecelakaanCount = $data->where('penyebab_kematian', 'kecelakaan')->count();
    $bunuhDiriCount = $data->where('penyebab_kematian', 'bunuh_diri')->count();
    $pembunuhanCount = $data->where('penyebab_kematian', 'pembunuhan')->count();
    $lainnyaCount = $data->where('penyebab_kematian', 'lainnya')->count();

    // Hitung persentase
    $sakitBiasaPercentage = $totalData > 0 ? ($sakitBiasaCount / $totalData) * 100 : 0;
    $kecelakaanPercentage = $totalData > 0 ? ($kecelakaanCount / $totalData) * 100 : 0;
    $bunuhDiriPercentage = $totalData > 0 ? ($bunuhDiriCount / $totalData) * 100 : 0;
    $pembunuhanPercentage = $totalData > 0 ? ($pembunuhanCount / $totalData) * 100 : 0;
    $lainnyaPercentage = $totalData > 0 ? ($lainnyaCount / $totalData) * 100 : 0;

    // Hitung rata-rata usia
    $avgAge = $totalData > 0 ? $data->avg(function($item) {
        return $item->penduduk->birthday->age;
    }) : 0;

    // Statistik perbandingan Sakit Biasa vs Kecelakaan
    $comparisonStats = [
        'sakit_biasa' => [
            'count' => $sakitBiasaCount,
            'percentage' => $sakitBiasaPercentage,
            'label' => 'Sakit Biasa'
        ],
        'kecelakaan' => [
            'count' => $kecelakaanCount,
            'percentage' => $kecelakaanPercentage,
            'label' => 'Kecelakaan'
        ]
    ];

    // Tentukan yang dominan
    $dominantCause = $sakitBiasaCount > $kecelakaanCount ? 'sakit_biasa' : 'kecelakaan';
    $dominantCount = max($sakitBiasaCount, $kecelakaanCount);
    $dominantPercentage = $totalData > 0 ? ($dominantCount / $totalData) * 100 : 0;

    return view('kematian.report', compact(
        'data',
        'startDate',
        'endDate',
        'totalData',
        'sakitBiasaCount',
        'kecelakaanCount',
        'bunuhDiriCount',
        'pembunuhanCount',
        'lainnyaCount',
        'sakitBiasaPercentage',
        'kecelakaanPercentage',
        'bunuhDiriPercentage',
        'pembunuhanPercentage',
        'lainnyaPercentage',
        'avgAge',
        'comparisonStats',
        'dominantCause',
        'dominantCount',
        'dominantPercentage'
    ));
}
}
