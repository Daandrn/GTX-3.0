<?php declare(strict_types=1);

namespace App\Controllers;

use App\Services\AreaLogadaService;
use App\Services\MembrosService;
use App\Services\RecuperaSenhaService;
use Vendor\Helpers\Redirect;
use Vendor\RenderView\View;

require_once __DIR__ . '/../../Vendor/autoload.php';

class AreaLogadaController
{
    protected AreaLogadaService    $areaLogadaService;
    protected MembrosService       $membrosService;
    protected RecuperaSenhaService $recuperaSenhaService;

    public function __construct()
    {
        $this->areaLogadaService    = new AreaLogadaService;

        if (!$this->areaLogadaService->sessionExists()) {
            Redirect::to("inicio");
            return;
        }

        $this->membrosService       = new MembrosService;
        $this->recuperaSenhaService = new RecuperaSenhaService;
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

    public function exit(): void
    {
        session_start();
        session_regenerate_id(true);
        session_destroy();
        Redirect::to("inicio");

        return;
    }
}
