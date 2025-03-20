<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response as FacadeResponse;

class StreamController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($dir, $filename)
    {
         // Cegah akses file dengan ekstensi yang tidak diizinkan
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        if (!in_array(strtolower($extension), $allowedExtensions)) {
            abort(404, 'File not found');
        }

        // Path file di MinIO
        $path =  $dir . '/' . $filename;

        // Periksa apakah file ada di MinIO
        if (!Storage::disk('s3')->exists($path)) {
            abort(404, 'File not found');
        }

        // Ambil file dari MinIO sebagai stream
        $stream = Storage::disk('s3')->get($path);
        $mimeType = Storage::disk('s3')->mimeType($path);

        return FacadeResponse::make($stream, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }
}
