<?php

require_once __DIR__ . '/../controller/playerController.php';

class Router {
  private $endpoint;
  private $method;

  public function __construct(){
    $this->endpoint = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $this->method = $_SERVER['REQUEST_METHOD'];
    switch($this->endpoint){
      case '/player':
        new PlayerController($this->method);
        break;
    }
  }
}