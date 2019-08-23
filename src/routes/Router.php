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
   * @var array Routes\RoutesColletion
   */
  protected $routes;

  /**
   * The active namespace at class call time
   * 
   * @var string
   */
  protected $namespace;

  /**
   * @var mixed
   */
  protected $error;

  /** @const int Bad Request */
  private const BAD_REQUEST = 400;

  /** @const int Not Found */
  private const NOT_FOUND = 404;

  /** @const int Method Not Exists */
  private const METHOD_NOT_EXISTS = 1;

  public function __construct() {
    $this->routes = new RoutesColletion;
    $this->setNamespace();
  }


  /**
   * Call the action methods that match 
   * 
   * @return bool
   */
  public function dispatch(Request $request): bool {
    return $this->dispatchToRouter($request);
  }

  /**
   * Find the correct route and execute the method assigned
   * 
   * @return bool
   */
  private function dispatchToRouter(Request $request): bool {
    $route = $this->routes->matchRoute($request);
    
    if(is_null($route)) {
      throw new \RuntimeException("Don't exists route to match with this request", self::NOT_FOUND);
    }

    if (!is_array($route->getAction()) && 
        is_callable($route->getAction())) {
          call_user_func($route->getAction());
          return true;
    }
    
    list($controller, $method) = $route->getAction();
    if(class_exists($controller)) {
      $controllerInstance = new $controller();
      if(!method_exists($controllerInstance, $method)) {
        throw new \RuntimeException("The method [{$method}] don't exists into controller [{$controller}]", self::METHOD_NOT_EXISTS);
      }

      if(is_array($request->getData())) {
        $controllerInstance->$method($request->getData());
      } else {
        $controllerInstance->$method();
      }
      
      return true;
    }
    
    throw new \RuntimeException("The class [{$controller}] don't exists", self::BAD_REQUEST);
  }

  /**
   * Add a new route for the colletion of the routes
   * 
   * @return void
   */
  private function add(Route $route): void {
    $this->routes->add($route);
  }

  /**
   * Create a new route object with the users params
   * 
   * @return Route
   */
  private function createRoute(String $uri, $action, String $verb): Route {
    return new Route($uri, $action, $verb, $this->getNamespace());
  }

  /**
   * Add new get routes
   * 
   * @return void
   */
  public function get(String $resource, $method): void {
    $this->add($this->createRoute($resource, $method, 'GET', $this->getNamespace()));
  }

  /**
   * Add new post routes
   * 
   * @return void
   */
  public function post(String $resource, $method): void {
    $this->add($this->createRoute($resource, $method, 'POST', $this->getNamespace()));
  }

  /**
   * Add new put routes
   * 
   * @return void
   */
  public function put(String $resource, $method): void {
    $this->add($this->createRoute($resource, $method, 'PUT', $this->getNamespace()));
  }

  /**
   * Add new delete routes
   * 
   * @return void
   */
  public function delete(String $resource, $method): void {
    $this->add($this->createRoute($resource, $method, 'DELETE', $this->getNamespace()));
  }

  /**
   * Return the current namespace
   * 
   * @return String
   */
  protected function getNamespace(): String {
    return $this->namespace;
  }

  /**
   * Set a namespace
   * 
   * @return void
   */
  private function setNamespace(String $prefix = 'App'): void {
    $this->namespace = "{$prefix}\\Controllers";
  }

  /**
   * Set a namespace
   * 
   * @return void
   */
  public function namespace(String $namespace): void {
    $this->namespace = "{$prefix}\\{$namespace}";
  }
}