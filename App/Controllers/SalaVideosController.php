<?php declare(strict_types=1);

namespace App\controllers;

use function Vendor\renderView\view;

require __DIR__ . '/../../Vendor/renderView/View.php';

class SalaVideosController
{
    public function index()
    {
        return view('salaVideos');
    }
}
