<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\MembroService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController
{
    
    public function __construct(
        protected MembroService $membroService,
    ) {
        //
    }

    public function login(LoginRequest $loginRequest)
    {
        $response = $this->auth($loginRequest);

        return $response;
    }

    private function auth(LoginRequest $loginRequest): array
    {
        $membro = $this->membroService->validateLogin($loginRequest);

        if (isset($membro['message'])) {
            return [
                'message'      => $membro['message'],
                'status_login' => false,
            ];
        }
        
        if (!Hash::check($loginRequest->senha_login, $membro->senha)) {
            return [
                'message'      => "Senha incorreta!",
                'status_login' => false,
            ];
        }

        if (
            $loginRequest->nick_login === $membro->nick
            && Hash::check($loginRequest->senha_login, $membro->senha)
            && in_array($membro->status_solicit, [1, 4], true)
        ) {
            session([
                "nome"         => $membro->nome,
                "id_sessao"    => $membro->id,
                "nick"         => $membro->nick,
                "statusMembro" => $membro->status_solicit
            ]);

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
