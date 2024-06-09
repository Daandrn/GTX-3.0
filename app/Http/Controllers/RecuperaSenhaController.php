<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTO\SolicitUpdatePassword;
use App\Requests\Request;
use App\Services\MembroService;
use App\Services\RecuperaSenhaService;

class RecuperaSenhaController
{
    
    public function __construct(
        protected RecuperaSenhaService $recuperaSenhaService,
        protected MembroService $membroService,

    ) {
        //
    }

    public function recuperarSenha()
    {
        $request = Request::ajax();

        if (!strlen($request->nick) > 0) {
            $response = ['message' => "O campo nick é de preenchimento obrigatório!"];
            echo json_encode($response);
            http_response_code(200);
            return;
        }

        if (!strlen($request->nova_senha) > 0) {
            $response = ['message' => "O campo nova senha é de preenchimento obrigatório!"];
            echo json_encode($response);
            http_response_code(200);
            return;
        }
        
        $memberExists = $this->membroService->memberExists(nick: $request->nick);

        if (!$memberExists) {
            $response = ['message' => "Não existe cadastro com este nick/origin!"];
            echo json_encode($response);
            http_response_code(404);
            return;
        }

        $pendingSolicityExists = $this->recuperaSenhaService->pendingSolicityToMember($memberExists->id);

        if ($pendingSolicityExists) {
            $response = ['message' => "Já existe uma solicitação pendente para este nick/origin. Aguarde ou procure um Administrador!"];
            echo json_encode($response);
            http_response_code(200);
            return;
        }

        if (strlen($request->nova_senha) < 8) {
            $response = ['message' => "Senha inválida. Use uma senha de no mínimo 8 digitos!"];
            echo json_encode($response);
            http_response_code(200);
            return;
        }

        $wasCreated = $this->recuperaSenhaService->newSolicity(
            SolicitUpdatePassword::make($request, $memberExists->id),
        );

        if ($wasCreated) {
            $response = ['message' => "Solicitação realizada com sucesso. Aguarde aprovação de um Administrador!"];
            echo json_encode($response);
            http_response_code(200);
            return;
        }

        $response = ['message' => "Erro durante a solicitação de nova senha. Procure um Administrador!"];
        echo json_encode($response);
        http_response_code(500);
        return;
    }

    public function aprovaSenha()
    {
        $request = Request::new();
        
        $response = $this->recuperaSenhaService->aprovaSenha((int) $request->member_id, (int) $request->id);
        
        return redirect(classMethod: 'AreaLogadaController.index', errors: $response);
    }

    public function reprovaSenha()
    {
        $request = Request::new();
        
        $response = $this->recuperaSenhaService->reprovaSenha((int) $request->member_id, (int) $request->id);

        return redirect(classMethod: 'AreaLogadaController.index', errors: $response);
    }
}
