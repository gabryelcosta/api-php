<?php

require_once __DIR__ . '/../../../infrastructure/PlayerSQliteRepository.php';
require_once __DIR__ . '/../../PlayerRepositoryInterface.php';

class DeletePlayerUseCase {
  private $playerInterface;

  public function __construct(){
    $this->playerInterface = new PlayerSQliteRepository();
  }

  public function execute(){
    try {
      $this->playerInterface->delete($_GET['id']);
      header("HTTP/1.1 204 Deleted");
      echo json_encode(['statusCode' => '204', 'message' => 'Jogador excluído com sucesso.']);
    } catch (InvalidArgumentException $e) {
      header("HTTP/1.1 400 Bad Request");
      echo json_encode(['statusCode' => '400', 'message' => $e->getMessage()]);
    }
  }
}