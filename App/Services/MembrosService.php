<?php declare(strict_types=1);

namespace App\Services;

use App\DTO\Membros\CreateMembroDTO;
use App\DTO\Membros\UpdateNickDTO;
use App\DTO\Membros\UpdatePasswordDTO;
use App\DTO\Membros\UpdateStatusMembroDTO;
use App\Repositories\MembrosRepository;
use stdClass;
use Vendor\Helpers\SanitizeInput;

require_once __DIR__ . '/../../Vendor/autoload.php';

class MembrosService
{
    protected MembrosRepository $membrosRepository;
    protected StreamChannelService $streamChannelService;

    public function __construct()
    {
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

        $response = $this->membrosRepository->insert(
            CreateMembroDTO::make((array) $request),
        );

        if ($response->id) {
            $this->streamChannelService->newStream($response->id);
        }

        return ['message' => "Solicitação realizada com sucesso, aguarde que seja aprovada por um dos administradores!"];
    }

    public function updateNick(UpdateNickDTO $dto, int $id): array
    {
        if (preg_match('[\'"<>&;/\|]', $dto->nick)) {
            return ['message' => "O campo nick não pode conter caracteres especiais!"];
        }

        $dto->nick = SanitizeInput::make($dto->nick);

        if (!strlen($dto->nick) > 0) {
            return ['message' => "O nick é obrigatório!"];
        }

        if (strlen($dto->nick) < 3 || strlen($dto->nick) > 20) {
            return ['message' => "O nick deve ter no mínimo 3 e no maximo 20 caracteres!"];
        }

        $memberExists = $this->membrosRepository->memberExists(id: $id);

        if (!$memberExists) {
            return ['message' => "Membro informado não existe. Verifique!"];
        }

        $nickUpdated = $this->membrosRepository->updateNick($dto, $id);

        $_SESSION['nick'] = $nickUpdated->nick;

        return ['message' => "Nick alterado com sucesso!"];
    }

    public function updatePassword(UpdatePasswordDTO $dto, int $id): array
    {
        $dto->senha = SanitizeInput::make($dto->senha);

        if (!strlen($dto->senha) > 0) {
            return ['message' => "A senha é obrigatória!"];
        }

        if (strlen($dto->senha) < 8) {
            return ['message' => "A senha deve conter no mínimo 8 caracteres!"];
        }

        $memberExists = $this->membrosRepository->memberExists(id: $id);

        if (!$memberExists) {
            return ['message' => "Membro informado não existe. Verifique!"];
        }

        $dto->senha = password_hash($dto->senha, PASSWORD_BCRYPT);

        $wasUpdated = $this->membrosRepository->updatePassword($dto, $id);

        if ($wasUpdated) {
            return ['message' => "Senha alterada com sucesso!"];
        }

        return ['message' => "Erro ao alterar senha. verifique!"];
    }

    public function updateStatusMember(array $request): bool
    {
        return $this->membrosRepository->updateStatusMember(
            UpdateStatusMembroDTO::make($request['acaoMembrosAdm'])
        );
    }

    public function delete(array $request): bool
    {
        $id = (int) $request['acaoMembrosAdm'][1];
        $this->streamChannelService->deleteStream($id);

        return $this->membrosRepository->delete($id);
    }
}
