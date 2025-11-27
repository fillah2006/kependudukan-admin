<?php

namespace App\Http\Controllers;

use App\Models\Kelahiran;
use App\Models\OrangTua;
use Illuminate\Http\Request;

class KelahiranController extends Controller
{
    public function index()
    {
        // Pagination
        $kelahiran = Kelahiran::with('orangtua')->latest()->paginate(10);

        // Hitung statistik dari SEMUA data (bukan dari paginated)
        $totalLakiLaki = Kelahiran::where('jenis_kelamin', 'L')->count();
        $totalPerempuan = Kelahiran::where('jenis_kelamin', 'P')->count();
        $totalKelahiran = Kelahiran::count();

        return view('kelahiran.index', compact(
            'kelahiran',
            'totalLakiLaki',
            'totalPerempuan',
            'totalKelahiran'
        ));
    }

    public function create()
    {
        $orangtua = OrangTua::orderBy('nama')->get();
        return view('kelahiran.create', compact('orangtua'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bayi' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'berat_badan' => 'nullable|numeric|min:0',
            'panjang_badan' => 'nullable|numeric|min:0',
            'alamat' => 'nullable|string',
            'no_akte' => 'nullable|string|max:100',
            'orangtua_id' => 'required|exists:orang_tua,id'
        ]);

        Kelahiran::create($request->all());

        return redirect()->route('kelahiran.index')
            ->with('success', 'Data kelahiran berhasil ditambahkan.');
    }

    public function show(Kelahiran $kelahiran)
    {
        return view('kelahiran.show', compact('kelahiran'));
    }

    public function edit(Kelahiran $kelahiran)
    {
        $orangtua = OrangTua::orderBy('nama')->get();
        return view('kelahiran.edit', compact('kelahiran', 'orangtua'));
    }

    public function update(Request $request, Kelahiran $kelahiran)
    {
        $request->validate([
            'nama_bayi' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'berat_badan' => 'nullable|numeric|min:0',
            'panjang_badan' => 'nullable|numeric|min:0',
            'alamat' => 'nullable|string',
            'no_akte' => 'nullable|string|max:100',
            'orangtua_id' => 'required|exists:orang_tua,id'
        ]);

        $kelahiran->update($request->all());

        return redirect()->route('kelahiran.index')
            ->with('success', 'Data kelahiran berhasil diperbarui.');
    }

    public function destroy(Kelahiran $kelahiran)
    {
        $kelahiran->delete();

        return redirect()->route('kelahiran.index')
            ->with('success', 'Data kelahiran berhasil dihapus.');
    }
}
