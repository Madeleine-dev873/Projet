<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ElectorUploadAttempt;
use App\Models\ElectorUploadError;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ElectorUploadController extends Controller
{
    public function uploadElectors(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->store('uploads');
        $fileHash = hash_file('sha256', storage_path("app/$filePath"));

        $attempt = ElectorUploadAttempt::create([
            'user_id' => Auth::id(),
            'file_name' => $fileName,
            'file_hash' => $fileHash,
            'status' => 'pending',
            'error_count' => 0,
        ]);

        return back()->with('success', 'Fichier uploadé avec succès !');
    }
}
