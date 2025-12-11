<?php

namespace App\Http\Controllers;

use App\Models\PelangganFile;
use Illuminate\Http\Request;

class PelangganFileController extends Controller
{
    public function destroy($id)
    {
        $file = PelangganFile::findOrFail($id);

        if (file_exists(public_path('storage/'.$file->path))) {
            unlink(public_path('storage/'.$file->path));
        }

        $file->delete();

        return back()->with('success', 'File berhasil dihapus');
    }
}
