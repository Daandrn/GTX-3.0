<?php declare(strict_types=1);

namespace App\Controllers;

use App\Services\AreaLogadaService;
use App\Services\MembrosService;
use App\Services\RecuperaSenhaService;
use Vendor\Helpers\Redirect;
use Vendor\RenderView\View;

require_once __DIR__.'/../../Vendor/autoload.php';

class AreaLogadaController
{
    protected AreaLogadaService $areaLogadaService;
    protected MembrosService $membrosService;
    protected RecuperaSenhaService $recuperaSenhaService;

    public function __construct()
    {
        $this->areaLogadaService    = new AreaLogadaService;
        $this->membrosService       = new MembrosService;
        $this->recuperaSenhaService = new RecuperaSenhaService;
    }

    public function index(?array $errors = null, ?array $data = null)
    {
        if (!$this->areaLogadaService->sessionExists()) {
            Redirect::to("inicio");
        }

        $nomeSessao = (string) $_SESSION['nome'];
        $idSessao   = (int) $_SESSION['id_sessao'];

        $memberLogged = $this->membrosService->memberWithStream(1);

        $nickPerfil        = $memberLogged->nick;
        $dadoStream        = [
            'nickStream' => $memberLogged->nickstream,
            'linkCanal'  => $memberLogged->link_canal,
            'plataforma' => $memberLogged->plataforma,
        ];
        $plataformasStream = $this->areaLogadaService->getStreamingPlatform();
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
        $response = ['message' => "Beleza!"];
        
        return Redirect::to(classMethod: 'InicioController.index', errors: $response);
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
    $formPerfil = (string) $_POST['formLogado'];
    
    switch ($formPerfil) {
        case 'canalStream':
            $idStream   = (int)    $_SESSION['id_sessao'];
            $nickStream = (string) $_POST['nickStream'];
            $linkStream = (string) $_POST['linkStream'];
            $plataforma = (int)    $_POST['plataforma'];
            
            $responseStream = "Todos os campos devem ser preenchidos!";
            
            if (
                isset($idStream) 
                && !empty($nickStream) 
                && !empty($linkStream) 
                && !empty($plataforma)
            ) {
                $linkStream           = formatLink($linkStream);
                $responseAlteraStream = alteraStream($idStream, $nickStream, $linkStream, $plataforma);

                header("location: /gtx2/control/control.areaLogada.php");
            }
            
            break;            
        case 'excluiCanalStream':
            $idExcluiStream = (int) $_SESSION['id_sessao'];
            $responseStream = excluiStream($idExcluiStream);

            header("location: /gtx2/control/control.areaLogada.php");
            break;
        case 'perfilNick':
            $idSessao   = (int)    $_SESSION['id_sessao'];
            $novoOrigin = (string) $_POST['origin'];

            $responseAlteraNick = "Nick/origin não pode ser vazio!";

            if (!empty($novoOrigin)) {
                $pessoa = new Pessoa;
                $pessoa->alteraNick($idSessao, $novoOrigin);
                $responseAlteraNick = "Nick/origin alterado com sucesso!";

                header("location: /gtx2/control/control.areaLogada.php");
            }

            break;
        case 'perfilSenha':
            $idSessao  = (int) $_SESSION['id_sessao'];
            $novaSenha = (int) $_POST['novaSenha'];

            $responseAlteraSenha = "Falha. Use senha uma numérica de 10 digitos!";

            if (
                !empty($novaSenha) 
                && (strlen($novaSenha) == 10)
            ) {
                $pessoa = new Pessoa;
                $pessoa->atualizaSenha($idSessao, $novaSenha);
                $responseAlteraSenha = "Senha alterada com sucesso!";
            }

            break;
        case 'salvaVersao':
            $versao = (int) $_POST['versao'];

            if ($versao != verificaVersao()){
                alteraVersao($versao);

                header("location: /index.php");
            }

            break;
        case 'form_sair':
            require __DIR__ . "/../funcoes/func.sair.php";

            sair();
            break;
    }
}

if (
    !empty($_SERVER['REQUEST_METHOD']) 
    && $_SERVER['REQUEST_METHOD'] == 'POST' 
    && isset($_POST['acaoMembrosAdm'])
) {
    $formMembrosAdm = (array) $_POST['acaoMembrosAdm'];

    switch ($formMembrosAdm[1]) {
        case 'Salvar' :
            $pessoa = new Pessoa;
            $pessoa->alteraStatus($formMembrosAdm[2], $formMembrosAdm[0]);

            header("location: /gtx2/control/control.areaLogada.php");
            break;
        case 'Excluir' :
            $pessoa = new Pessoa;
            $pessoa->excluiPessoa($formMembrosAdm[2]);

            header("location: /gtx2/control/control.arealogada.php");
            break;
        }
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