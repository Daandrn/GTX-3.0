<?php declare(strict_types=1);

namespace App\controllers;

use App\Repository\MembrosRepository;

use function Vendor\Helpers\dd;

class LoginController
{
    protected MembrosRepository $membrosRepository;

    public function __construct()
    {
        require __DIR__.'/../Repositories/MembrosRepository.php';
        
        $this->membrosRepository = $membrosRepository;
    }
    
    public function login($usuarioLogin, $senhaLogin)
    {
        return $this->auth($usuarioLogin, $senhaLogin);;
    }

    private function auth(string $nick, string $password)
    {
        $membro = $this->membrosRepository->loginSenhaMembro($nick);

        if (! $membro) {
            return [
                'message'      => "Usuário não encontrado!",
                'status_login' => false,
            ];
        }

        $membro = $membro[0];

        if ($membro->status_solicit === "0") {
            return [
                'message'      => "Aguardando aprovação! entre em contato com um dos administradores ou aguarde.", 
                'status_login' => false,
            ];
        }

        if (! password_verify($password, $membro->senha)) {
            return [
                'message'      => "Senha incorreta! tente novamente ou use o esqueci senha.", 
                'status_login' => false,
            ];
        }

        if (
            $nick === $membro->nick
            && password_verify($password, $membro->senha) 
            && ($membro->status_solicit === '1'
                || $membro->status_solicit === "4")
        ) {
            session_start();

            $_SESSION = [
                "nome"         => $membro->nome,
                "id_sessao"    => $membro->id,
                "nick"         => $membro->nick,
                "statusMembro" => $membro->status_solicit
            ];
            
            return [
                'message'      => "Login realizado com sucesso!", 
                'status_login' => true,
            ];
        }
    }
}