<?php declare(strict_types=1);

namespace App\Repositories;

use App\DTO\UpdateStreamChannelDTO;
use App\Models\StreamChannel;
use stdClass;

require_once __DIR__ . '/../../Vendor/autoload.php';

class StreamChannelRepository
{
    protected StreamChannel $streamChannelModel;

    public function __construct()
    {
        $this->streamChannelModel = StreamChannel::newInstance();
    }

    /**
     * Carrega canal de stream
     * @param int $id id do membro
     * @return stdClass|null Dados do canal de stream
     */
    public function getStream(int $id): stdClass|null
    {
        $streamChannel = $this->streamChannelModel->select(
            where: ['id', '=', $id, 'limit 1'],
        );
        
        return !empty($streamChannel) 
                ? (object) $streamChannel[0]
                : null;
    }

    public function new(int $id): bool
    {
        $data = [
            'id'         => $id,
            'plataforma' => null,
            'link_canal' => null,
            'nick_stream' => null,
        ];
        
        return $this->streamChannelModel->insert($data);
    }

    public function update(UpdateStreamChannelDTO $dto, ?int $id = null): stdClass|false
    {
        $wasUpdated = $this->streamChannelModel->update(data: $dto->toArray(), id: $id, );

        if ($wasUpdated) {
            $streamUpdated = $this->streamChannelModel->select(
                where: ['id', '=', $id, ''],
            );
        }

        return !empty($wasUpdated)
                ? (object) $streamUpdated[0]
                : false;
    }

    public function delete(int $id): bool
    {
        return $this->streamChannelModel->deleteOne($id);
    }
}
