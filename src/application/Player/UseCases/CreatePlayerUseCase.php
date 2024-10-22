<?php

require_once __DIR__ . '/../../../infrastructure/PlayerSQliteRepository.php';
require_once __DIR__ . '/../../PlayerRepositoryInterface.php';

class CreatePlayerUseCase{
  private $playerInterface;

  public function __construct(){
    $this->playerInterface = new PlayerSQliteRepository();
  }

  public function execute($player){
    try {
      $this->playerInterface->insert($player);
      header("HTTP/1.1 201 Created");
      echo $player->toJson();
    } catch (InvalidArgumentException $e) {
      header("HTTP/1.1 400 Bad Request");
      echo json_encode(['statusCode' => '400', 'message' => $e->getMessage()]);
    }
  }
}