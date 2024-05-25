<?php declare(strict_types=1);

namespace App\Controllers;

use Vendor\RenderView\View;

require_once __DIR__.'/../../Vendor/autoload.php';

class SalaVideosController
{
    public function index()
    {
        return View::view('salaVideos');
    }
}
