<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $filename)
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
            abort(404);
        }

        // Path file di MinIO
        $path = "categories/{$filename}";

        // Periksa apakah file ada di MinIO
        if (!Storage::disk('s3')->exists($path)) {
            abort(404);
        }

        // Dapatkan MIME type
        $mimeType = Storage::disk('s3')->mimeType($path);

        // Stream file
        return response()->stream(function () use ($path) {
            $stream = Storage::disk('s3')->readStream($path);
            while (!feof($stream)) {
                echo fread($stream, 1024 * 8); // Membaca file dalam blok 8 KB
            }
            fclose($stream);
        }, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
        ]);
    }
}
