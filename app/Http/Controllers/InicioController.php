<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RecruitRequest;
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

    public function inicioRecruit(RecruitRequest $recruitRequest)
    {
        $response = $this->membroService->newMember($recruitRequest);

        return view('inicio', $response);
    }
}
