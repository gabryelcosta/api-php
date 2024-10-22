<?php

require_once __DIR__ . '/../../../infrastructure/PlayerSQliteRepository.php';
require_once __DIR__ . '/../../PlayerRepositoryInterface.php';

class GetPlayerByIdUseCase {
  private $playerInterface;

  public function __construct(){
    $this->playerInterface = new PlayerSQliteRepository();
  }

  public function execute($id){
    $player = $this->playerInterface->getById($id);
    if(empty($player)){
      header("HTTP/1.1 404 Not Found");
      echo json_encode(['statusCode' => '404', 'message' => 'Nenhum jogador encontrado com este ID.']);
      return;
    }
    echo $player->toJson();
  }
}