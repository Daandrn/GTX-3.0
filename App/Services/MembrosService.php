<?php declare(strict_types=1);

namespace App\Services;

use App\DTO\Membros\CreateMembroDTO;
use App\DTO\Membros\UpdateStatusMembroDTO;
use App\Repositories\MembrosRepository;
use stdClass;

class MembrosService
{
    protected MembrosRepository $membrosRepository;
    protected StreamChannelService $streamChannelService;

    public function __construct()
    {
        require_once __DIR__ . '/../Repositories/MembrosRepository.php';
        require_once __DIR__ . '/../Services/StreamChannelService.php';

        $this->membrosRepository = new MembrosRepository;
        $this->streamChannelService = new StreamChannelService;
    }

    public function allMembers(): array|null
    {
        $membros = $this->membrosRepository->getAllMembers();

        return $membros;
    }

    public function allRecruits(): array|null
    {
        $recruits = $this->membrosRepository->getAllRecruits();

        return $recruits;
    }

    public function allRejected(): array|null
    {
        $rejected = $this->membrosRepository->getAllrejected();

        return $rejected;
    }

    public function memberWithStream(int $id): stdClass|null
    {
        return $this->membrosRepository->memberWithStream($id);
    }

    public function newMember(object $request): array
    {
        $nome = preg_replace("/[^A-Za-z\s'ãáâéêíõôóúÃÁÂÉÊÍÕÔÓÚ]/", '', $request->nome_recrut);

        if (strlen($nome) < 3) {
            return ['message' => "Nome inválido!"];
        }

        if (
            strlen($request->nick_recrut) < 5
            || preg_match('/[^a-zA-Z0-9\s]/', $request->nick_recrut)
        ) {
            return ['message' => "Nick inválido!"];
        }

        $memberExists = $this->membrosRepository->memberExists($request->nick_recrut);

        if ($memberExists) {
            return ['message' => "O nick {$request->nick_recrut} já está sendo utilizado! Utilize o recuperar senha ou procure um administrador."];
        }

        require __DIR__ . '/../DTO/Membros/CreateMembroDTO.php';

        $response = $this->membrosRepository->insert(
            CreateMembroDTO::make((array) $request),
        );

        if ($response) {
            $this->streamChannelService->newChannel($response->id);
        }

        return ['message' => "Solicitação realizada com sucesso, aguarde que seja aprovada por um dos administradores!"];
    }

    public function update(array $request): bool
    {
        require __DIR__ . '/../DTO/Membros/UpdateStatusMembroDTO.php';

        return $this->membrosRepository->update(
            UpdateStatusMembroDTO::make($request['acaoMembrosAdm'])
        );
    }

    public function delete(array $request): bool
    {
        $id = (int) $request['acaoMembrosAdm'][1];

        return $this->membrosRepository->delete($id);
    }
}
