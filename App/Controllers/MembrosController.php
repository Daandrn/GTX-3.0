<?php declare(strict_types=1);

namespace App\controllers;

use function Vendor\renderView\view;

class MembrosController
{
    public function index()
    {
        require __DIR__ . "/../model/model.membros.php";
        $teste = "aaa";

        return view('membros', compact('teste'));
    }
}