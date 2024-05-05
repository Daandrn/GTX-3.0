<?php declare(strict_types=1);

namespace App\controllers;

use App\Services\MembrosService;

use function Vendor\renderView\view;

require_once __DIR__ . '/../../Vendor/renderView/View.php';

class MembrosController
{
    protected MembrosService $membrosService;

    public function __construct()
    {
        require __DIR__ . '/../Services/MembrosService.php';

        $this->membrosService = new MembrosService;
    }

    public function listaMembros()
    {
        $membros = $this->membrosService->allMembers();

        return view('membros', $membros);
    }

    public function alteraStatusMembro()
    {
        $this->membrosService->update($_REQUEST);

        return header('location: arealogada');
    }

    public function delete()
    {
        $this->membrosService->delete($_REQUEST);

        return header('location: arealogada');
    }
}
