<?php declare(strict_types=1);

namespace App\Controllers;

use App\DTO\Membros\UpdateNickDTO;
use App\DTO\Membros\UpdatePasswordDTO;
use App\DTO\UpdateStreamChannelDTO;
use App\Requests\Request;
use App\Services\AreaLogadaService;
use App\Services\MembrosService;
use App\Services\RecuperaSenhaService;
use App\Services\StreamChannelService;
use Vendor\Helpers\Redirect;
use Vendor\RenderView\View;

require_once __DIR__.'/../../Vendor/autoload.php';

class AreaLogadaController
{
    protected AreaLogadaService    $areaLogadaService;
    protected MembrosService       $membrosService;
    protected RecuperaSenhaService $recuperaSenhaService;
    protected StreamChannelService $streamChannelService;

    public function __construct()
    {
        $this->areaLogadaService    = new AreaLogadaService;

        if (!$this->areaLogadaService->sessionExists()) {
            Redirect::to("inicio");
            return;
        }
        
        $this->membrosService       = new MembrosService;
        $this->recuperaSenhaService = new RecuperaSenhaService;
        $this->streamChannelService = new StreamChannelService;
    }

    public function index(?array $errors = null, ?array $data = null)
    {
        $nomeSessao = (string) $_SESSION['nome'];
        $idSessao   = (int) $_SESSION['id_sessao'];

        $memberLogged = $this->membrosService->memberWithStream($idSessao);

        $nickPerfil        = $memberLogged->nick;
        $dadoStream        = [
            'nickStream' => $memberLogged->nick_stream,
            'linkCanal'  => $memberLogged->link_canal,
            'plataforma' => $memberLogged->plataforma,
        ];
        $plataformasStream = $this->areaLogadaService->getStreamingPlatforms();
        $listaMembros      = $this->membrosService->allMembers();
        $listaRecrut       = $this->membrosService->allRecruits();
        $listaRejeitados   = $this->membrosService->allRejected();
        $listaNovaSenha    = $this->recuperaSenhaService->pendingSolicities();
        $message           = $errors['message'] ?? 0;

        $data = compact('nomeSessao', 'idSessao', 'nickPerfil', 'dadoStream', 'plataformasStream', 'listaMembros', 'listaRecrut', 'listaRejeitados', 'listaNovaSenha', 'message');

        return View::view('areaLogada', $data);
    }

    public function alteraCanalStream()
    {
        $request = Request::new();
        $id = (int) $_SESSION['id_sessao'];

        $response = $this->streamChannelService->updateStream(
            $id, UpdateStreamChannelDTO::make($request)
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
            $id, UpdateStreamChannelDTO::make($data)
        );
        
        return Redirect::to(classMethod: 'AreaLogadaController.index', errors: $response);
    }

    public function excluiCanalStream()
    {
        $id = (int) $_SESSION['id_sessao'];
        $response = $this->streamChannelService->deleteStream($id);

        return Redirect::to(classMethod: 'AreaLogadaController.index', errors: $response);
    }

    public function alteraNick()
    {
        $Request = Request::new();
        $id =$_SESSION['id_sessao'];
        
        $response = $this->membrosService->updateNick(
            UpdateNickDTO::make($Request), $id
        );

        return Redirect::to(classMethod: 'AreaLogadaController.index', errors: $response);
    }

    public function alteraSenha()
    {
        $Request = Request::new();
        $id = $_SESSION['id_sessao'];
        
        $response = $this->membrosService->updatePassword(
            UpdatePasswordDTO::make($Request), $id
        );

        return Redirect::to(classMethod: 'AreaLogadaController.index', errors: $response);
    }

    public function exit(): void
    {
        session_start();
        session_regenerate_id(true);
        session_destroy();
        Redirect::to("inicio");

        return;
    }
}

/*

if (
    !empty($_SERVER['REQUEST_METHOD']) 
    && $_SERVER['REQUEST_METHOD'] == 'POST' 
    && isset($_POST['formLogado'])
) {

}

if (
    !empty($_SERVER['REQUEST_METHOD']) 
    && $_SERVER['REQUEST_METHOD'] == 'POST' 
    && isset($_POST['acaoAlteraSenha'])
) {
    $acaoAlteraSenha = (array) $_POST['acaoAlteraSenha'];

    switch ($acaoAlteraSenha[0]) {
        case 'Aprovar' :
            $pessoa = new Pessoa;
            $pessoa->alteraSenha($acaoAlteraSenha[1], $acaoAlteraSenha[2]);

            header("location: /gtx2/control/control.arealogada.php");
            break;
        case 'Reprovar' :
            $pessoa = new Pessoa;
            $pessoa->reprovaNovaSenha($acaoAlteraSenha[2]);

            header("location: /gtx2/control/control.arealogada.php");
            break;
    }
}
*/