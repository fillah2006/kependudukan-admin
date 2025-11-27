<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penduduk;

class PendudukController extends Controller
{
    /**
     * Display a listing of the resource (search + filter + pagination).
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $filterGender = $request->gender;
        $filterTgl = $request->birthday;

        $query = Penduduk::query();

        // === SEARCH ===
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'LIKE', "%$search%")
                  ->orWhere('last_name', 'LIKE', "%$search%")
                  ->orWhere('nik', 'LIKE', "%$search%");
            });
        }

        // === FILTER JENIS KELAMIN ===
        if ($filterGender) {
            $query->where('gender', $filterGender);
        }

        // === FILTER TANGGAL LAHIR ===
        if ($filterTgl) {
            $query->whereDate('birthday', $filterTgl);
        }

        // Pagination
        $penduduks = $query->orderBy('created_at', 'desc')->paginate(10);

        // Statistik
        $totalPenduduk = Penduduk::count();
        $pendudukBaru = Penduduk::whereDate('created_at', today())->count();

        return view('kependudukan.index', compact(
            'penduduks',
            'totalPenduduk',
            'pendudukBaru',
            'search',
            'filterGender',
            'filterTgl'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kependudukan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|digits:16|unique:penduduks,nik',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthday' => 'required|date',
            'gender' => 'required|in:L,P',
            'phone' => 'nullable|string|max:15'
        ]);

        $cleanData = [
            'nik' => trim($request->nik),
            'first_name' => trim($request->first_name),
            'last_name' => trim($request->last_name),
            'birthday' => $request->birthday,
            'gender' => trim($request->gender),
            'phone' => $request->phone ? trim($request->phone) : null,
        ];

        Penduduk::create($cleanData);

        return redirect()->route('penduduk.index')
            ->with('success', 'Data penduduk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $penduduk = Penduduk::findOrFail($id);
        return view('kependudukan.show', compact('penduduk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $penduduk = Penduduk::findOrFail($id);
        return view('kependudukan.edit', compact('penduduk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nik' => 'required|digits:16|unique:penduduks,nik,' . $id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthday' => 'required|date',
            'gender' => 'required|in:L,P',
            'phone' => 'nullable|string|max:15'
        ]);

        $penduduk = Penduduk::findOrFail($id);

        $cleanData = [
            'nik' => trim($request->nik),
            'first_name' => trim($request->first_name),
            'last_name' => trim($request->last_name),
            'birthday' => $request->birthday,
            'gender' => trim($request->gender),
            'phone' => $request->phone ? trim($request->phone) : null,
        ];

        $penduduk->update($cleanData);

        return redirect()->route('penduduk.index')
            ->with('success', 'Data penduduk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $penduduk = Penduduk::findOrFail($id);
        $penduduk->delete();

        return redirect()->route('penduduk.index')
            ->with('success', 'Data penduduk berhasil dihapus!');
    }
}
