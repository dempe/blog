<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;


class AssetController extends Controller
{
    public function getJavaScript()
    {
        $path = public_path('assets/js/highlight.min.js');
        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/javascript',
        ]);
    }
}
