<?php declare(strict_types=1);

namespace App\controllers;

use App\Services\MembrosService;

use function Vendor\renderView\view;

class MembrosController
{
    protected MembrosService $service;
    
    public function __construct() 
    {
        require __DIR__.'/../Services/MembrosService.php';
        
        $this->service = $service;
    }
    
    public function index()
    {
        $membros = $this->service->all();

        return view('membros', $membros);
    }
}