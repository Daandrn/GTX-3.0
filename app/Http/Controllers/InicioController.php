<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Requests\Request;
use App\Services\MembroService;
use Redirect;

class InicioController
{
    public function __construct(
        protected MembroService $membroService,
    ) {
        //
    }

    public function index()
    {
        return view('inicio');
    }

    public function inicioLogin(LoginRequest $loginRequest, LoginController $loginController)
    {
        $response = $loginController->login($loginRequest);
        
        if (isset($response['status_login']) && $response['status_login'] === true) {
            
            return redirect()
            ->route('arealogada');
        }
            
        return redirect()
                ->route('inicio')
                ->withErrors($response['message']);
    }

    public function inicioRecruit()
    {
        $request = Request::new();
        
        if (
            isset($_SERVER['REQUEST_METHOD'])
            && $_SERVER['REQUEST_METHOD'] === 'POST'
            && $request->formInicio === 'form_recrut'
        ) {
            $response = $this->membroService->newMember($request);

            return view('inicio', $response);
        }
    }
}
