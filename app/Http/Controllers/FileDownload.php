<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileDownload extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $fileName = $request->fileName;
        $filePath = public_path() . "/downloads/" . $fileName;
        return Storage::disk('local')->download($filePath);
    }
}
