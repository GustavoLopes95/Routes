<?php

namespace App\Routes;

class RoutesColletion {

  /**
   * Collection of routes registered in the application
   * 
   * @var Routes[] 
   */
  protected $routes = [];

  /**
   * Add a new route for the Route Colletion and return it
   * 
   * @return Route
   */
  public function add(Route $route): Route {
    $verb     = $route->getVerb();
    $resource = $route->getUri();

    $this->routes[$verb][$resource] = $route;

    return $route;
  }


  /**
   * Search through of the Route Collection for the route
   * that match to request
   * 
   * @return Route/null
   */
  public function matchRoute(Request $request) {
    $routes = $this->getRoutes($request->getVerb());
    $route = $this->filterRoute($routes, $request);
    
    if(is_null($route)) {
      return null;
    }

    return $route;
  }

  /**
   * Return the filtered route that match to request
   * 
   * @return Route/array
   */
  public function filterRoute(Array $routes, Request $request) {
    $route = array_filter($routes, function($route) use($request) {
      return $route->getUri() === $request->getUri();
    });

    return array_shift($route);
  }

  /**
   * Returns an array of routes with all verbs or 
   * returns an array of routes with a chosen verb
   * 
   * @return Route[]
   */
  protected function getRoutes(String $verb = null) {
    return is_null($verb) ? $this->routes : $this->routes[$verb];
  }
}