<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Vendor\RenderView\View;

class SalaVideosController
{
    public function index()
    {
        return view('salaVideos');
    }
}
