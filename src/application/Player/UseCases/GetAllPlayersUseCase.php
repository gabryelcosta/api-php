<?php

require_once __DIR__ . '/../../../infrastructure/PlayerSQliteRepository.php';
require_once __DIR__ . '/../../PlayerRepositoryInterface.php';

class GetAllPlayersUseCase {
  private $playerInterface;

  public function __construct() {
    $this->playerInterface = new PlayerSQliteRepository();
  }

  public function execute() {
    $players = $this->playerInterface->getAll();
    if(empty($players)){
      header("HTTP/1.1 404 Not Found");
      echo json_encode(['statusCode' => '404', 'message' => 'Nenhum jogador encontrado.']);
      return;
    }
    $response = array_map(function($player){
      return $player->toJson();
    }, $players);
    return $response;
  }
}