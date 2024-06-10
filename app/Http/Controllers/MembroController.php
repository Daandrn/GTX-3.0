<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTO\Membros\UpdateNickDTO;
use App\DTO\Membros\UpdatePasswordDTO;
use App\DTO\Membros\UpdateStatusMembroDTO;
use App\DTO\UpdateCanalStreamDTO;
use App\Http\Requests\Request;
use App\Http\Requests\UpdateCanalStreamRequest;
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

    public function alteraStatusMembro(Request $request)
    {
        $this->membroService->updateStatusMember(
            UpdateStatusMembroDTO::make($request['acaoMembrosAdm'])
        );

        return redirect()
                ->route('arealogada');
    }

    public function alteraCanalStream(UpdateCanalStreamRequest $updateStreamRequest)
    {
        if (!$this->areaLogadaService->sessionExists()) {
            return redirect()
                    ->route('inicio', status:401);
        }
        
        $updateStreamRequest->membro_id = session()->get('id_sessao');

        $response = $this->canalStreamService->updateStream(
            UpdateCanalStreamDTO::make($updateStreamRequest)
        );

        return redirect()
                ->route('arealogada')
                ->withErrors($response);
    }

    public function limpaCanalStream()
    {
        if (!$this->areaLogadaService->sessionExists()) {
            return redirect()
                    ->route('inicio', status:401);
            
        }

        $data = (object) [
            'membro_id'   => session()->get('id_sessao'),
            'plataforma'  => null,
            'link_canal'  => null,
            'nick_stream' => null,
        ];

        $response = $this->canalStreamService->limpaStream(
            UpdateCanalStreamDTO::make($data)
        );

        return redirect()
                ->route('arealogada')
                ->withErrors($response);
    }

    public function excluiCanalStream()
    {
        if (!$this->areaLogadaService->sessionExists()) {
            return redirect()
                    ->route('inicio', status:401);
        }

        $id       = session('id_sessao');
        $response = $this->canalStreamService->deleteStream($id);

        return redirect()
                ->route('arealogada')
                ->withErrors($response);
    }

    public function alteraNick(Request $request)
    {
        if (!$this->areaLogadaService->sessionExists()) {
            redirect("inicio");
            return;
        }

        $request->id = session()->get('id_sessao');

        $response = $this->membroService->updateNick(
            UpdateNickDTO::make($request)
        );

        return redirect()
                ->route('arealogada')
                ->withErrors($response);
    }

    public function alteraSenha(Request $request)
    {
        if (!$this->areaLogadaService->sessionExists()) {
            return redirect()
                    ->route('inicio');
        }

        $request->id = session()->get('id_sessao');

        $response = $this->membroService->updatePassword(
            UpdatePasswordDTO::make($request)
        );

        return redirect()
                ->route('arealogada')
                ->withErrors($response);
    }

    public function delete(Request $request)
    {
        $this->membroService->delete($request);

        return redirect()
                ->route('arealogada');
    }
}
