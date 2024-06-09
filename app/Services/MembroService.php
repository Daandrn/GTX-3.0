<?php declare(strict_types=1);

namespace App\Services;

use App\DTO\Membros\CreateMembroDTO;
use App\DTO\Membros\UpdateNickDTO;
use App\DTO\Membros\UpdatePasswordDTO;
use App\DTO\Membros\UpdateStatusMembroDTO;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RecruitRequest;
use App\Models\Membro;
use App\Repositories\MembroRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Vendor\Helpers\SanitizeInput;

class MembroService
{
    
    public function __construct(
        protected MembroRepository $membroRepository,
        protected CanalStreamService $canalStreamService,

    ) {
        //
    }

    public function allMembers(): Collection
    {
        $membros = $this->membroRepository->getAllMembers();

        return $membros;
    }

    public function allRecruits(): Collection
    {
        $recruits = $this->membroRepository->getAllRecruits();

        return $recruits;
    }

    public function allRejected(): Collection
    {
        $rejected = $this->membroRepository->getAllrejected();

        return $rejected;
    }

    public function memberExists(?string $nick = null, ?int $id = null): Collection
    {
        if ($nick) {
            $memberExists = $this->membroRepository->memberExists(nick: $nick);
        }

        if ($id) {
            $memberExists = $this->membroRepository->memberExists(id: $id);
        }

        return $memberExists;
    }

    public function memberWithStream(int $id): Membro
    {
        return $this->membroRepository->memberWithStream($id);
    }

    protected function loginPasswordMember(string $nick): Membro
    {
        return $this->membroRepository->loginPasswordMember($nick);
    }

    public function validateLogin(LoginRequest $loginRequest): array|Membro
    {
        $membro = $this->loginPasswordMember($loginRequest->nick_login);
        
        if ($membro->status_solicit === 0) {
            return [
                'message' => "Aguardando aprovação! entre em contato com um dos administradores ou aguarde.",
            ];
        }

        if (!Hash::check($loginRequest->senha_login, $membro->senha)) {
            return [
                'message' => "Senha incorreta! tente novamente ou use o esqueci senha.",
            ];
        }

        return $membro;
    }

    public function newMember(RecruitRequest $recruitRequest): array
    {
        $recruitRequest->nome_recrut = preg_replace("/[^A-Za-z\s'ãáâéêíõôóúÃÁÂÉÊÍÕÔÓÚ]/", '', $recruitRequest->nome_recrut);

        if (preg_match('/[^a-zA-Z0-9\s]/', $recruitRequest->nick_recrut)) {
            return ['message' => "Nick inválido!"];
        }

        $memberExists = $this->memberExists(nick: $recruitRequest->nick_recrut);

        if ($memberExists->isNotEmpty()) {
            return ['message' => "O nick {$recruitRequest->nick_recrut} já está sendo utilizado! Utilize o recuperar senha ou procure um administrador."];
        }
        
        $response = $this->membroRepository->insert(
            CreateMembroDTO::make($recruitRequest->toArray()),
        );

        if ($response->id) {
            $this->canalStreamService->newStream($response->id);
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

        $memberExists = $this->memberExists(id: $id);

        if ($memberExists->isEmpty()) {
            return ['message' => "Membro informado não existe. Verifique!"];
        }

        $nickUpdated = $this->membroRepository->updateNick($dto, $id);

        session()->push('nick', $nickUpdated->nick);

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

        $memberExists = $this->memberExists(id: $id);

        if ($memberExists->isEmpty()) {
            return ['message' => "Membro informado não existe. Verifique!"];
        }

        if (password_get_info($dto->senha)['algoName'] !== 'bcrypt') {
            $dto->senha = password_hash($dto->senha, PASSWORD_BCRYPT);
        }

        $wasUpdated = $this->membroRepository->updatePassword($dto, $id);

        if ($wasUpdated) {
            return ['message' => "Senha alterada com sucesso!"];
        }

        return ['message' => "Erro ao alterar senha. verifique!"];
    }

    public function updateStatusMember(array $request): bool
    {
        return $this->membroRepository->updateStatusMember(
            UpdateStatusMembroDTO::make($request['acaoMembrosAdm'])
        );
    }

    public function delete(array $request): bool
    {
        $id = (int) $request['acaoMembrosAdm'][1];
        $this->canalStreamService->deleteStream($id);

        return $this->membroRepository->delete($id);
    }
}
