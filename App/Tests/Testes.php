<?php declare(strict_types=1);

namespace App\tests;

use App\DTO\Membros\UpdatePasswordDTO;
use App\Repositories\StreamChannelRepository;
use App\Requests\Request;
use App\Services\MembrosService;

require_once __DIR__ . '/../../Vendor/autoload.php';

class Testes
{
    /**
     * Chama os metodos que contém os cenários de testes criados.
     */
    public function init()
    {
        //$this->novoCanalStream(999);
        //$this->verificaConteudoRequisicao();
        //$this->verificaSessao();
        //$this->alterarSenha('12345678', 1);
    }

    private function novoCanalStream(int $id)
    {
        (new StreamChannelRepository())->new($id);
    }

    private function verificaConteudoRequisicao()
    {
        var_dump(Request::new());
        echo "<br>";
        var_dump(Request::toArray());
        echo "<br>";
    }

    private function verificaSessao()
    {
        session_start();
        var_dump($_SESSION);
        echo "<br>";
    }

    private function alterarSenha(string $password, int $id): void
    {
        $dto = UpdatePasswordDTO::make((object) ['senha' => $password]);
        (new MembrosService())->updatePassword($dto, $id);
        var_dump('Senha alterada com sucesso!');
        echo "<br>";
    }

    public static function run()
    {
        $tests = new Testes;
        $tests->init();
        exit;
    }
}
