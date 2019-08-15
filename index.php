<?php

  require __DIR__. "/vendor/autoload.php";
  //require __DIR__. "/boostrap/autoload.php";

  //use CoffeeCode\Router\Router;
  use App\Routes\Router;
  use App\Routes\Request;


  $router = new Router();

  $router->get('carro', 'CarroController@index');

  Request::capture($router);

  
  /*var_dump($router);exit;

  $router->group(null);
  $router->get("/", function() {
    echo 'Hello World';
  });

  $router->group("error");
  $router->get("/{errcode}", function ($data) {
    echo "<h1>Erro {$data['errcode']}</h1>";
    var_dump($data);
    exit;
  });


  $router->dispatch();

  if($router->error()) {
    $router->redirect("/error/{$router->error()}");
  }*/