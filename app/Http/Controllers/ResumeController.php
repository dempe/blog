<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ResumeController extends Controller
{
    public function show(): BinaryFileResponse {
        return Response::file(public_path('resume.pdf'), ['Content-Type' => 'application/pdf']);
    }
}
