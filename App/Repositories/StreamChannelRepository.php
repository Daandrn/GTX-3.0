<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\StreamChannel;

class StreamChannelRepository
{
    protected StreamChannel $streamChannelModel;

    public function __construct()
    {
        require_once __DIR__.'/../Models/StreamChannel.php';
        
        $this->streamChannelModel = $streamChannelModel;
    }

    public function newChannel(int $id): bool
    {
        return $this->streamChannelModel->new($id);
    }
    
    // public function alteraStream(int $id, string $nickStream, string $linkStream, int $plataforma): string
    // {
    //     try {
    //         $consulta = connection()->prepare("UPDATE canalstream 
    //                                             SET nickstream = :nickStream,
    //                                                 link_canal = :linkCanal, 
    //                                                 plataforma = :plataforma
    //                                             WHERE id = :id");
    //         $consulta->bindParam(':nickStream', $nickStream, PDO::PARAM_STR);
    //         $consulta->bindParam(':linkCanal', $linkStream, PDO::PARAM_STR);
    //         $consulta->bindParam(':plataforma', $plataforma, PDO::PARAM_INT);
    //         $consulta->bindParam(':id', $id, PDO::PARAM_INT);
    //         $consulta->execute();
            
    //         return "Alteração realizada com sucesso!";
    //     } catch (PDOexception $erro) {
    //         return "Erro no banco de dados: " . $erro->getMessage();        
    //     }
    // }

    // public function excluiStream(int $id): string
    // {
    //     try {
    //         $consulta = connection()->prepare("UPDATE canalstream 
    //                                             SET nickstream = null,
    //                                                 link_canal = null, 
    //                                                 plataforma = null
    //                                             WHERE id = :id");
    //         $consulta->bindParam(':id', $id, PDO::PARAM_INT);
    //         $consulta->execute();

    //         return "Exclusão realizada com sucesso!";
    //     } catch (PDOException $erro) {
    //         return "Erro no banco de dados: " . $erro->getMessage();        
    //     }
    // }

    // public function formatLink(string $string) 
    // {
    //     return str_ireplace(["www.", "https://", "http://"], "", $string);
    // }

    // /**
    //  * Carrega canal de stream da pessoa
    //  * @param int $id id da pessoa 
    //  * @return array Dados do canal de stream
    //  */
    // public function carregaStream(int $id): array|string
    // {
    //     try {
    //         $consulta = connection()->prepare("SELECT * FROM canalstream WHERE id = :id");
    //         $consulta->bindParam(':id', $id, PDO::PARAM_INT);
    //         $consulta->execute();

    //         $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

    //         $perfilStream = [
    //             "nickStream" => $resultado['nickstream'],
    //             "linkCanal" => $resultado['link_canal'],
    //             "plataforma" => $resultado['plataforma']
    //         ];
    //         return (array) $perfilStream;
    //     } catch (PDOException $erro) {
    //         return "Erro ao carregar canal stream: " . $erro->getMessage();
    //     }
    // }

    // public function deleteStream(Type $args): void
    // {
    //     // exclui canal stream
    //     $consulta1 = connection()->prepare("DELETE FROM canalstream WHERE id = :id");
    //     $consulta1->bindParam(':id', $idPessoa, PDO::PARAM_INT);
    //     $consulta1->execute();
    // }
}