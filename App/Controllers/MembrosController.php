<?php declare(strict_types=1);

namespace App\Controllers;

use App\Services\MembrosService;
use Vendor\Helpers\Redirect;
use Vendor\RenderView\View;

require_once __DIR__ . '/../../Vendor/autoload.php';

class MembrosController
{
    protected MembrosService $membrosService;

    public function __construct()
    {
        $this->membrosService = new MembrosService;
    }

    public function listaMembros()
    {
        $membros = $this->membrosService->allMembers();

        return View::view('membros', $membros);
    }

    public function alteraStatusMembro()
    {
        $this->membrosService->update($_REQUEST);

        return Redirect::to('arealogada');
    }

    public function delete()
    {
        $this->membrosService->delete($_REQUEST);

        return Redirect::to('arealogada');
    }
}
