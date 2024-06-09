<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Login;

class LoginController
{
    
    public function __construct(
        protected Login $loginModel,
    ) {
        //
    }

    public function login($usuarioLogin, $senhaLogin): array
    {
        return $this->auth($usuarioLogin, $senhaLogin);
    }

    private function auth(string $nick, string $password): array
    {
        $membro = $this->loginModel->loginPasswordMember($nick);

        if (!$membro) {
            return [
                'message' => "Usuário não encontrado!",
            ];
        }

        if ($membro->status_solicit === 0) {
            return [
                'message' => "Aguardando aprovação! entre em contato com um dos administradores ou aguarde.",
            ];
        }

        if (
            $membro->status_solicit === 2
            || $membro->status_solicit === 3
        ) {
            return [
                'message' => "Acesso negado!",
            ];
        }

        if (!password_verify($password, $membro->senha)) {
            return [
                'message' => "Senha incorreta! tente novamente ou use o esqueci senha.",
            ];
        }

        if (
            $nick === $membro->nick
            && password_verify($password, $membro->senha)
            && ($membro->status_solicit === 1
                || $membro->status_solicit === 4)
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

        return [
            'message' => "Não foi possível validar suas credenciais, tente novamente ou entre em contato com a administração!",
        ];
    }
}
