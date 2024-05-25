<?php declare(strict_types=1);

namespace App\Controllers;

use App\Services\MembrosService;
use Vendor\RenderView\View;

use function Vendor\Helpers\redirect;

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

        return redirect('arealogada');
    }

    public function delete()
    {
        $this->membrosService->delete($_REQUEST);

        return redirect('arealogada');
    }
}
