<?php

interface PlayerRepositoryInterface {
  public function insert($player);
  public function update($id, $player);
  public function delete($id);
  public function getAll();
  public function getById($id);
}