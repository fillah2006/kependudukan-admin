<?php
namespace App\Http\Controllers;

use App\Models\OrangTua;
use Illuminate\Http\Request;

class OrangTuaController extends Controller
{
    /**
     * Display a listing of the resource (with pagination, filter, search).
     */
    public function index(Request $request)
    {
        // Search & Filter
        $search        = $request->search;
        $filterKelamin = $request->jenis_kelamin;
        $filterStatus  = $request->status;

        $query = OrangTua::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%$search%")
                    ->orWhere('nik', 'LIKE', "%$search%");
            });
        }

        if ($filterKelamin) {
            $query->where('jenis_kelamin', $filterKelamin);
        }

        if ($filterStatus) {
            $query->where('status', $filterStatus);
        }

        // Pagination
        $orangTua = $query->orderBy('created_at', 'desc')->paginate(10);

        // Statistik
        $totalOrangTua  = OrangTua::count();
        $totalLakiLaki  = OrangTua::where('jenis_kelamin', 'L')->count();
        $totalPerempuan = OrangTua::where('jenis_kelamin', 'P')->count();
        $totalHidup     = OrangTua::where('status', 'hidup')->count();

        return view('orangtua.index', compact(
            'orangTua',
            'totalOrangTua',
            'totalLakiLaki',
            'totalPerempuan',
            'totalHidup',
            'search',
            'filterKelamin',
            'filterStatus'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('orangtua.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'nik'           => 'required|string|unique:orang_tua,nik|max:16',
            'tempat_lahir'  => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat'        => 'required|string',
            'agama'         => 'required|string|max:255',
            'pekerjaan'     => 'required|string|max:255',
            'pendidikan'    => 'required|string|max:255',
            'no_telepon'    => 'required|string|max:15',
            'status'        => 'required|in:hidup,meninggal',
        ]);

        OrangTua::create($validated);

        return redirect()->route('orangtua.index')
            ->with('success', 'Data orang tua berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OrangTua $orangTua)
    {
        return view('orangtua.show', compact('orangTua'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrangTua $orangtua)
    {
        return view('orangtua.edit', compact('orangtua'));
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, OrangTua $orangtua)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'nik'           => 'required|string|max:16|unique:orang_tua,nik,' . $orangtua->id,
            'tempat_lahir'  => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat'        => 'required|string',
            'agama'         => 'required|string|max:255',
            'pekerjaan'     => 'required|string|max:255',
            'pendidikan'    => 'required|string|max:255',
            'no_telepon'    => 'required|string|max:15',
            'status'        => 'required|in:hidup,meninggal',
        ]);

        $orangtua->update($validated);

        return redirect()->route('orangtua.index')
            ->with('success', 'Data orang tua berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $orangTua = OrangTua::findOrFail($id);
        $orangTua->delete();

        return back()->with('success', 'Data orang tua dihapus.');
    }

}
