<?php

class PlayerEntity {
  private $playerName;
  private $class;
  private $iLvL;

  public function __construct($playerName, $class, $iLvL) {
    $allowedClasses = [
        'Demon Hunter', 'Death Knight', 'Evoker', 'Druid', 'Hunter',
        'Mage', 'Warrior', 'Warlock', 'Rogue', 'Monk', 'Paladin',
        'Priest', 'Shaman'
    ];

    if (!in_array($class, $allowedClasses)) {
        throw new InvalidArgumentException("Classe inválida. As classes permitidas são: " . implode(', ', $allowedClasses));
    }

    if ($iLvL < 620) {
      throw new InvalidArgumentException("O jogador deve ter um iLvL mínimo de 620 para ser apto.");
  }

    $this->playerName = $playerName;
    $this->class = $class;
    $this->iLvL = $iLvL;
  }

  public function increaseILvL($amount) {
      $newILvL = $this->getILvL() + $amount;
      $this->setILvL($newILvL);
  }

  public function isEligibleForActivity($requiredILvL) {
    return $this->iLvL >= $requiredILvL;
  }

  public function getPlayerName() {
    return $this->playerName;
  }

  public function getClass() {
    return $this->class;
  }

  public function getILvL() {
    return $this->iLvL;
  }

  public function setPlayerName($playerName) {
    $this->playerName = $playerName;
  }

  public function setClass($class) {
    $allowedClasses = [
        'Demon Hunter', 'Death Knight', 'Evoker', 'Druid', 'Hunter',
        'Mage', 'Warrior', 'Warlock', 'Rogue', 'Monk', 'Paladin',
        'Priest', 'Shaman'
    ];

    if (!in_array($class, $allowedClasses)) {
        throw new InvalidArgumentException("Classe inválida. As classes permitidas são: " . implode(', ', $allowedClasses));
    }

    $this->class = $class;
  }

  public function setILvL($iLvL) {
    if ($iLvL < 620) {
      throw new InvalidArgumentException("O jogador deve ter um iLvL mínimo de 620 para ser apto.");
    }
    $this->iLvL = $iLvL;
  }

  public function toJson(){
    return json_encode(['playerName' => $this->playerName, 'class' => $this->class, 'iLvL' => $this->iLvL]);
  }
}