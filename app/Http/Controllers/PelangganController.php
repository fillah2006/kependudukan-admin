<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\PelangganFile;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::orderBy('id', 'DESC')->paginate(10);
        return view('admin.pelanggan.index', compact('pelanggan'));
    }

    public function create()
    {
        return view('admin.pelanggan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'dokumen.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $pelanggan = Pelanggan::create([
            'nama' => $request->nama,
        ]);

        // upload multiple dokumen
        if ($request->hasFile('dokumen')) {
            foreach ($request->file('dokumen') as $file) {
                $path = $file->store('uploads/pelanggan', 'public');

                PelangganFile::create([
                    'pelanggan_id' => $pelanggan->id,
                    'path' => $path
                ]);
            }
        }

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambah');
    }

    public function show($id)
    {
        $pelanggan = Pelanggan::with('files')->findOrFail($id);
        return view('admin.pelanggan.show', compact('pelanggan'));
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::with('files')->findOrFail($id);
        return view('admin.pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'dokumen.*' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $pelanggan->update([
            'nama' => $request->nama
        ]);

        // upload dokumen baru bila ada
        if ($request->hasFile('dokumen')) {
            foreach ($request->file('dokumen') as $file) {
                $path = $file->store('uploads/pelanggan', 'public');

                PelangganFile::create([
                    'pelanggan_id' => $pelanggan->id,
                    'path' => $path
                ]);
            }
        }

        return redirect()->route('pelanggan.show', $pelanggan->id)
            ->with('success', 'Data pelanggan diperbarui');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        // hapus dokumen fisik
        foreach ($pelanggan->files as $file) {
            if (file_exists(public_path('storage/'.$file->path))) {
                unlink(public_path('storage/'.$file->path));
            }
        }

        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan dihapus');
    }
}
