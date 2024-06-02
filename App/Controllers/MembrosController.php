<?php declare(strict_types=1);

namespace App\Controllers;

use App\DTO\Membros\UpdateNickDTO;
use App\DTO\Membros\UpdatePasswordDTO;
use App\DTO\UpdateStreamChannelDTO;
use App\Requests\Request;
use App\Services\AreaLogadaService;
use App\Services\MembrosService;
use App\Services\StreamChannelService;
use Vendor\Helpers\Redirect;
use Vendor\RenderView\View;

require_once __DIR__ . '/../../Vendor/autoload.php';

class MembrosController
{
    protected MembrosService       $membrosService;
    protected StreamChannelService $streamChannelService;
    protected AreaLogadaService    $areaLogadaService;

    public function __construct()
    {
        $this->membrosService       = new MembrosService;
        $this->streamChannelService = new StreamChannelService;
        $this->areaLogadaService    = new AreaLogadaService;

        if (!$this->areaLogadaService->sessionExists()) {
            Redirect::to("inicio");
            return;
        }
    }

    public function listaMembros()
    {
        $membros = $this->membrosService->allMembers();

        return View::view('membros', $membros);
    }

    public function alteraStatusMembro()
    {
        $request = Request::toArray();
        $this->membrosService->updateStatusMember($request);

        return Redirect::to('arealogada');
    }

    public function alteraCanalStream()
    {
        $request = Request::new();
        $id      = (int) $_SESSION['id_sessao'];

        $response = $this->streamChannelService->updateStream(
            $id,
            UpdateStreamChannelDTO::make($request)
        );

        return Redirect::to(classMethod: 'AreaLogadaController.index', errors: $response);
    }

    public function limpaCanalStream()
    {
        $id = (int) $_SESSION['id_sessao'];

        $data = (object) [
            'plataforma'  => null,
            'link_canal'  => null,
            'nick_stream' => null,
        ];

        $response = $this->streamChannelService->limpaStream(
            $id,
            UpdateStreamChannelDTO::make($data)
        );

        return Redirect::to(classMethod: 'AreaLogadaController.index', errors: $response);
    }

    public function excluiCanalStream()
    {
        $id       = (int) $_SESSION['id_sessao'];
        $response = $this->streamChannelService->deleteStream($id);

        return Redirect::to(classMethod: 'AreaLogadaController.index', errors: $response);
    }

    public function alteraNick()
    {
        $Request = Request::new();
        $id      = (int) $_SESSION['id_sessao'];

        $response = $this->membrosService->updateNick(
            UpdateNickDTO::make($Request),
            $id
        );

        return Redirect::to(classMethod: 'AreaLogadaController.index', errors: $response);
    }

    public function alteraSenha()
    {
        $Request = Request::new();
        $id      = (int) $_SESSION['id_sessao'];

        $response = $this->membrosService->updatePassword(
            UpdatePasswordDTO::make($Request),
            $id
        );

        return Redirect::to(classMethod: 'AreaLogadaController.index', errors: $response);
    }

    public function delete()
    {
        $request = Request::toArray();
        $this->membrosService->delete($request);

        return Redirect::to('arealogada');
    }
}
