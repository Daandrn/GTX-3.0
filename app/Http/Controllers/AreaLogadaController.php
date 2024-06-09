<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AreaLogadaService;
use App\Services\MembroService;
use App\Services\RecuperaSenhaService;
use Illuminate\Support\Facades\View;

class AreaLogadaController
{
    public function __construct(
        protected AreaLogadaService    $areaLogadaService,
        protected MembroService        $membroService,
        protected RecuperaSenhaService $recuperaSenhaService,
    ) {
        //
    }

    public function index(?array $errors = null, ?array $data = null)
    {   
        if (!session()->isStarted() || !session()->has('nick')) {
            return redirect('/');
        }
        
        $nomeSessao = session('nome');
        $idSessao   = session('id_sessao');

        $memberLogged = $this->membroService->memberWithStream($idSessao);

        $nickPerfil        = $memberLogged->nick;
        $dadoStream        = [
            'nickStream' => $memberLogged->nick_stream,
            'linkCanal'  => $memberLogged->link_canal,
            'plataforma' => $memberLogged->plataforma,
        ];
        $plataformasStream = $this->areaLogadaService->getPlataformaStreams();
        $listaMembros      = $this->membroService->allMembers();
        $listaRecrut       = $this->membroService->allRecruits();
        $listaRejeitados   = $this->membroService->allRejected();
        $listaNovaSenha    = $this->recuperaSenhaService->pendingSolicities();
        $message           = $errors['message'] ?? 0;

        $data = compact('nomeSessao', 'idSessao', 'nickPerfil', 'dadoStream', 'plataformasStream', 'listaMembros', 'listaRecrut', 'listaRejeitados', 'listaNovaSenha', 'message');

        return view('areaLogada', $data);
    }

    public function exit()
    {
        session()->invalidate();
        session()->flush();
        session()->regenerateToken();

        return redirect()->route('inicio');
    }
}
