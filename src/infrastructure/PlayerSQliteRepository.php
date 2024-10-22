<?php

require_once __DIR__ . '/../application/PlayerRepositoryInterface.php';
require_once __DIR__ . '/../domain/PlayerEntity.php';

class PlayerSQliteRepository implements PlayerRepositoryInterface {
  private $pdo;
  private $databaseFile = __DIR__ . '/../infrastructure/database/attendanceBank.db';

  public function __construct(){
    $this->pdo = new PDO('sqlite:' . $this->databaseFile);
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  public function insert($player) {
    try {
        $stmt = $this->pdo->prepare('INSERT INTO Player (PlayerName, Class, iLvL) VALUES (:PlayerName, :Class, :iLvL)');
        $stmt->bindParam(':PlayerName', $player->getPlayerName());
        $stmt->bindParam(':Class', $player->getClass());
        $stmt->bindParam(':iLvL', $player->getILvL());
        $stmt->execute();

        $id = $this->pdo->lastInsertId();

        return new PlayerEntity($player->getPlayerName(), $player->getClass(), $player->getILvL(), $id);
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            throw new InvalidArgumentException("O nome do jogador já existe. Por favor, escolha um nome diferente.");
        } else {
            throw $e;
        }
      }
  }

public function update($id, $player) {
  try {
  $stmt = $this->pdo->prepare('UPDATE Player SET PlayerName = :PlayerName, Class = :Class, iLvL = :iLvL WHERE id = :id');
  $stmt->bindParam(':PlayerName', $player->getPlayerName());
  $stmt->bindParam(':Class', $player->getClass());
  $stmt->bindParam(':iLvL', $player->getILvL());
  $stmt->bindParam(':id', $id);
  $stmt->execute();

  return new PlayerEntity($player->getPlayerName(), $player->getClass(), $player->getILvL(), $id);
  } catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        throw new InvalidArgumentException("O nome do jogador já existe. Por favor, escolha um nome diferente.");
    } else {
        throw $e;
    }
    }
  }

  public function delete($id) {
    $stmt = $this->pdo->prepare('DELETE FROM Player WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        throw new InvalidArgumentException("ID não encontrado. Nenhum registro foi deletado.");
    }
  }

  public function getAll() {
    $stmt = $this->pdo->query('SELECT * FROM Player');
    $players = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return array_map(function($player) {
      return new PlayerEntity($player['PlayerName'], $player['Class'], $player['iLvL']);
    }, $players);
  }

  public function getById($id) {
    $stmt = $this->pdo->prepare('SELECT * FROM Player WHERE ID = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $player = $stmt->fetch(PDO::FETCH_ASSOC);
    if($player){
      return new PlayerEntity($player['PlayerName'], $player['Class'], $player['iLvL']);
    }
    return;
  }
}