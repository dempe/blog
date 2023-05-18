<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;

class ResumeController extends Controller
{
    public function show()
    {
        $resumePath = public_path('resume.pdf');

        return Response::file($resumePath, ['Content-Type' => 'application/pdf']);
    }
}
