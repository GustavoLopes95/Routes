<?php

namespace App\Routes;

use App\Routes\Route;
use App\Routes\Request;
use App\Routes\RoutesColletion;

class Router {

  /**
   * Registered routes
   * 
   * 
   * @var array App\Routes\RoutesColletion
   */
  protected $routes;

  /**
   * The resourcer that the user wanted
   * 
   * @var string
   */
  protected $resource;

  /**
   * The arguments of the request
   * 
   * @var array
   */
  protected $arguments;
  

  /**
   * The verbs of the request
   * 
   * @var string
   */
  protected $verb;

  private const BAD_REQUEST = 400;

  protected static $METHOD_NOT_EXISTS = 1;

  public function __construct() {
    $this->routes = new RoutesColletion;
  }

  public function dispatch(Request $request) {
    return $this->dispatchToRouter($request);
  }

  private function dispatchToRouter(Request $request) {
    $route = $this->routes->matchRoute($request);

    if(is_null($route)) {
      $this->redirectError(404);
    }

    
    list($controller, $method) = $route->getAction();
    if(class_exists($controller)) {
      $controllerInstance = new $controller();
      if(!method_exists($controllerInstance, $method)) {
        throw new Exception("The method $method don't exists into controller $controller", self::$METHOD_NOT_EXISTS);
      }

      $controllerInstance->$method();
    }
    
    throw new \Exception("The class $controller don't exists", self::BAD_REQUEST);    
  }

  protected function findRoute(Request $request) {
    //$route = 
  }

  private function add(Route $route) {
    $this->routes->add($route);
  }

  private function createRoute(String $uri, String $action, String $verb) {
    return new Route($uri, $action, $verb);
  }

  public function get(String $resource, $method) {
    $this->add($this->createRoute($resource, $method, 'GET'));
  }

  public function post(String $resource, $method) {
    $this->add($this->createRoute($resource, $method, 'POST'));
  }

  public function put(String $resource, $method) {
    $this->add($this->createRoute($resource, $method, 'PUT'));
  }

  public function delete(String $resource, $method) {
    $this->add($this->createRoute($resource, $method, 'DELETE'));
  }
}