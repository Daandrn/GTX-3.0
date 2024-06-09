<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTO\Membros\UpdateNickDTO;
use App\DTO\Membros\UpdatePasswordDTO;
use App\DTO\UpdateStreamChannelDTO;
use App\Requests\Request;
use App\Services\AreaLogadaService;
use App\Services\MembroService;
use App\Services\CanalStreamService;


class MembroController
{
    
    public function __construct(
        protected MembroService      $membroService,
        protected CanalStreamService $canalStreamService,
        protected AreaLogadaService  $areaLogadaService,
    ) {
        //
    }

    public function listaMembros()
    {
        $membros = $this->membroService->allMembers();

        return view('membros', compact('membros'));
    }

    public function alteraStatusMembro()
    {
        $request = Request::toArray();
        $this->membroService->updateStatusMember($request);

        return redirect('arealogada');
    }

    public function alteraCanalStream()
    {
        if (!$this->areaLogadaService->sessionExists()) {
            redirect("inicio");
            return;
        }
        
        $request = Request::new();
        $id      = (int) $_SESSION['id_sessao'];

        $response = $this->CanalStreamService->updateStream(
            $id,
            UpdateStreamChannelDTO::make($request)
        );

        return redirect(classMethod: 'AreaLogadaController.index', errors: $response);
    }

    public function limpaCanalStream()
    {
        if (!$this->areaLogadaService->sessionExists()) {
            redirect("inicio");
            return;
        }

        $id = (int) $_SESSION['id_sessao'];

        $data = (object) [
            'plataforma'  => null,
            'link_canal'  => null,
            'nick_stream' => null,
        ];

        $response = $this->CanalStreamService->limpaStream(
            $id,
            UpdateStreamChannelDTO::make($data)
        );

        return redirect(classMethod: 'AreaLogadaController.index', errors: $response);
    }

    public function excluiCanalStream()
    {
        if (!$this->areaLogadaService->sessionExists()) {
            redirect("inicio");
            return;
        }

        $id       = (int) $_SESSION['id_sessao'];
        $response = $this->CanalStreamService->deleteStream($id);

        return redirect(classMethod: 'AreaLogadaController.index', errors: $response);
    }

    public function alteraNick()
    {
        if (!$this->areaLogadaService->sessionExists()) {
            redirect("inicio");
            return;
        }

        $Request = Request::new();
        $id      = (int) $_SESSION['id_sessao'];

        $response = $this->membroService->updateNick(
            UpdateNickDTO::make($Request),
            $id
        );

        return redirect(classMethod: 'AreaLogadaController.index', errors: $response);
    }

    public function alteraSenha()
    {
        if (!$this->areaLogadaService->sessionExists()) {
            redirect("inicio");
            return;
        }

        $Request = Request::new();
        $id      = (int) $_SESSION['id_sessao'];

        $response = $this->membroService->updatePassword(
            UpdatePasswordDTO::make($Request),
            $id
        );

        return redirect(classMethod: 'AreaLogadaController.index', errors: $response);
    }

    public function delete()
    {
        $request = Request::toArray();
        $this->membroService->delete($request);

        return redirect('arealogada');
    }
}
