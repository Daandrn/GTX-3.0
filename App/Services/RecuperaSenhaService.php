<?php declare(strict_types=1);

namespace App\Services;

use App\DTO\Membros\UpdatePasswordDTO;
use App\DTO\SolicitUpdatePassword;
use App\Enums\StatusNovaSenha;
use App\Repositories\RecuperaSenhaRepository;
use stdClass;

require_once __DIR__ . '/../../Vendor/autoload.php';

class RecuperaSenhaService
{
    protected RecuperaSenhaRepository $recuperaSenhaRepository;
    protected MembrosService          $membrosService;

    public function __construct()
    {
        $this->recuperaSenhaRepository = new RecuperaSenhaRepository;
        $this->membrosService          = new MembrosService;
    }

    public function newSolicity(SolicitUpdatePassword $dto): bool
    {       
        $wasCreated = $this->recuperaSenhaRepository->new($dto);

        return $wasCreated;
    }

    public function pendingSolicities(): array|null
    {
        return $this->recuperaSenhaRepository->getPendingSolicities();
    }

    public function pendingSolicityToMember(int $member_id): stdClass|false
    {
        return $this->recuperaSenhaRepository->getSolicityToMember($member_id);
    }

    public function aprovaSenha(int $member_id, int $id): array|false
    {
        $solicityExists = $this->pendingSolicityToMember($member_id);

        if (!$solicityExists) {
            return ['message' => "Não existe solicitação pendente para o usuário solicitado!"];
        }

        if (password_get_info($solicityExists->nova_senha)['algoName'] !== 'bcrypt') {
            return ['message' => "A criptografia da nova senha está inválida. Verifique!"];
        }

        $data = ['senha' => $solicityExists->nova_senha];

        $response = $this->membrosService->updatePassword(
            UpdatePasswordDTO::make((object) $data),
            $solicityExists->member_id
        );
        
        $status_solicit = StatusNovaSenha::STATUS_APROVADO->value;
        
        $this->recuperaSenhaRepository->updateStatusSolicity($id, $status_solicit);

        return $response;
    }

    public function reprovaSenha(int $member_id, int $id): array|false
    {
        $solicityExists = $this->pendingSolicityToMember($member_id);

        if (!$solicityExists) {
            return ['message' => "Não existe solicitação pendente para o usuário solicitado!"];
        }
        
        $status_solicit = StatusNovaSenha::STATUS_REPROVADO->value;
        
        $wasReproved = $this->recuperaSenhaRepository->updateStatusSolicity($id, $status_solicit);

        if ($wasReproved) {
            return ['message' => "Solicitação reprovada com sucesso!"];
        }

        return ['message' => "Erro ao reprovar solicitação. Verifique!"];
    }
}
