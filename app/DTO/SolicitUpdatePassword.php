<?php declare(strict_types=1);

namespace App\DTO;

use App\Enums\StatusNovaSenha;

class SolicitUpdatePassword
{
    public int    $member_id;
    public string $nick;
    public string $nova_senha;
    public int    $solicit_senha;
    public string $data_solicit;
    
    protected function __construct(object $data)
    {
        $this->member_id     = $data->member_id;
        $this->nick          = $data->nick;
        $this->nova_senha    = $data->nova_senha;
        $this->solicit_senha = $data->solicit_senha;
        $this->data_solicit  = $data->data_solicit;
    }

    public static function make(object $request, int $member_id): self
    {
        $data = (object) [
            'member_id'     => $member_id,
            'nick'          => $request->nick,
            'nova_senha'    => password_hash($request->nova_senha, PASSWORD_BCRYPT),
            'solicit_senha' => StatusNovaSenha::STATUS_SOLICITADO->value,
            'data_solicit'  => (new \DateTime('now'))->format('d-m-Y'),
        ];

        return new self($data);
    }

    public function toArray(): array
    {
        $array = [
            'member_id'     => $this->member_id,
            'nick'          => $this->nick,
            'nova_senha'    => $this->nova_senha,
            'solicit_senha' => $this->solicit_senha,
            'data_solicit'  => $this->data_solicit,
        ];

        return $array;
    }
}
