<?php declare(strict_types=1);

namespace App\controllers;

use function Vendor\renderView\view;

class SalaVideosController
{
    public function index()
    {
        return view('salaVideos');
    }
}
