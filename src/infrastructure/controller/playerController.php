<?php

require_once __DIR__ . '/../../application/Player/UseCases/GetAllPlayersUseCase.php';
require_once __DIR__ . '/../../application/Player/UseCases/GetPlayerByIdUseCase.php';
require_once __DIR__ . '/../../application/Player/UseCases/CreatePlayerUseCase.php';
require_once __DIR__ . '/../../application/Player/UseCases/UpdatePlayerUseCase.php';
require_once __DIR__ . '/../../application/Player/UseCases/DeletePlayerUseCase.php';

class PlayerController {
  private $getAllPlayerUseCase;
  private $getPlayerByIdUseCase;
  private $createPlayerUseCase;
  private $updatePlayerUseCase;
  private $deletePlayerUseCase;

  public function __construct($method){
    switch($method){
      case 'GET':
        if (isset($_GET['id'])) {
          $id = $_GET['id'];
          $this->getPlayerByIdUseCase = new GetPlayerByIdUseCase();
          $response = $this->getPlayerByIdUseCase->execute($id);
          echo $response;
        } else {
          $this->getAllPlayerUseCase = new GetAllPlayersUseCase();
          $response = $this->getAllPlayerUseCase->execute();
          echo '[' . implode(',', $response) . ']';
        }
        break;
      case 'POST':
        try {
          $data = json_decode(file_get_contents('php://input'), true);
          $repository = new PlayerSQliteRepository();
          $player = new PlayerEntity($data['PlayerName'], $data['Class'], $data['iLvL'], $repository);
          $this->createPlayerUseCase = new CreatePlayerUseCase();
          $response = $this->createPlayerUseCase->execute($player);
          echo $response;
        } catch (InvalidArgumentException $e) {
          header("HTTP/1.1 400 Bad Request");
          echo json_encode(['statusCode' => '400', 'message' => $e->getMessage()]);
        }
        break;
      case 'PUT':
        try {
          $data = json_decode(file_get_contents('php://input'), true);
          $id = $_GET['id'];
          $repository = new PlayerSQliteRepository();
          $player = new PlayerEntity($data['PlayerName'], $data['Class'], $data['iLvL'], $repository);
          $this->updatePlayerUseCase = new UpdatePlayerUseCase();
          $response = $this->updatePlayerUseCase->execute($id, $player);
          echo $response;
        } catch (InvalidArgumentException $e) {
          header("HTTP/1.1 400 Bad Request");
          echo json_encode(['statusCode' => '400', 'message' => $e->getMessage()]);
        }
        break;
      case 'DELETE':
        $id = $_GET['id'];
        $this->deletePlayerUseCase = new DeletePlayerUseCase();
        $response = $this->deletePlayerUseCase->execute($id);
        echo $response;
        break;
      }
    }
}