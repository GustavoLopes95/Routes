<?php

  require __DIR__. "/vendor/autoload.php";

  use App\Routes\Router;
  use App\Routes\Request;
  use App\Routes\RoutesColletion;
  use App\Routes\RoutesCompiler;

  $routeCompiler   = new RoutesCompiler();
  $routesColletion = new RoutesColletion($routeCompiler);
  $router = new Router($routesColletion);

  $router->get('/', function() {
    require_once 'src/Views/form.list.php';
  });

  $router->get('user', 'UserController@index');
  $router->get('user/create', 'UserController@create');
  $router->post('user', 'UserController@store');
  $router->get('user/{id}', 'UserController@show');
  $router->get('user/{id}/edit', 'UserController@edit');
  $router->put('user/{id}', 'UserController@update');
  $router->get('user/{id}', 'UserController@destroy');

  Request::capture($router);

  