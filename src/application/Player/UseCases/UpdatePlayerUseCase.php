<?php

require_once __DIR__ . '/../../../infrastructure/PlayerSQliteRepository.php';
require_once __DIR__ . '/../../PlayerRepositoryInterface.php';

class UpdatePlayerUseCase {
  private $playerInterface;

  public function __construct(){
    $this->playerInterface = new PlayerSQliteRepository();
  }

  public function execute($id, $player){
    try {
      $updatedPlayer = $this->playerInterface->update($id, $player);
      header("HTTP/1.1 200 Updated");
      return $updatedPlayer->toJson();
    } catch (InvalidArgumentException $e) {
      header("HTTP/1.1 400 Bad Request");
      echo json_encode(['statusCode' => '400', 'message' => $e->getMessage()]);
    }
  }
}