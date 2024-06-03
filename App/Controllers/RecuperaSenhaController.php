<?php declare(strict_types=1);

namespace App\Controllers;

use App\DTO\SolicitUpdatePassword;
use App\Requests\Request;
use App\Services\MembrosService;
use App\Services\RecuperaSenhaService;
use Vendor\Helpers\Redirect;

require_once __DIR__.'/../../Vendor/autoload.php';

class RecuperaSenhaController
{
    protected RecuperaSenhaService $recuperaSenhaService;
    protected MembrosService $membrosService;
    
    public function __construct()
    {
        $this->recuperaSenhaService = new RecuperaSenhaService();
        $this->membrosService       = new MembrosService();
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
        
        $memberExists = $this->membrosService->memberExists(nick: $request->nick);

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
        
        return Redirect::to(classMethod: 'AreaLogadaController.index', errors: $response);
    }

    public function reprovaSenha()
    {
        $request = Request::new();
        
        $response = $this->recuperaSenhaService->reprovaSenha((int) $request->member_id, (int) $request->id);

        return Redirect::to(classMethod: 'AreaLogadaController.index', errors: $response);
    }
}
