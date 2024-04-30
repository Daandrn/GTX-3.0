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

    public function __construct(
    ) {
        require_once __DIR__.'/../Repositories/MembrosRepository.php';
        require_once __DIR__.'/../Services/StreamChannelService.php';

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

    public function newMember(array $request): stdClass|null
    {
        $response = $this->membrosRepository->insert(
            CreateMembroDTO::make($request),
        );

        if (! empty($response)) {
            $this->streamChannelService->newChannel($response->id);
        }

        return $response;
    }

    public function update(array $request): bool
    {
        require __DIR__.'/../DTO/Membros/UpdateStatusMembroDTO.php';

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
