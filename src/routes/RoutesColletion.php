<?php

namespace App\Routes;

class RoutesColletion {

  /**
   * @var array
   */
  protected $routes = [];

  protected $verbs = ['GET', 'POST', 'PUT', 'DELETE'];


  public function add(Route $route) {
    $verb     = $route->getVerb();
    $resource = $route->getUri();

    $this->routes[$verb][$resource] = $route;

    return $route;
  }

  public function matchRoute(Request $request) {
    $routes = $this->getRoutes($request->getVerb());

    $route = $this->filterRoute($routes, $request);
    
    if(is_null($route)) {
      return null;
    }

    return $route;
  }

  public function filterRoute(Array $routes, Request $request) {
    $route = array_filter($routes, function($route) use($request) {
      return $route->getUri() === $request->getUri();
    });
    
    return array_shift($route);
  }

  protected function getRoutes(String $verb = null) {
    return is_null($verb) ? $this->routes : $this->routes[$verb];
  }
}