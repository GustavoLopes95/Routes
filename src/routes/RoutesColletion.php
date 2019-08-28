<?php

namespace App\Routes;

use App\Routes\Contract\IRoute;
use App\Routes\Contract\IRequest;

class RoutesColletion implements IRoutesColletion {

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
  public function add(IRoute $route): IRoute {
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
  public function matchRoute(IRequest $request): ?IRoute {
    $this->compileRoute($request);

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
  public function filterRoute(Array $routes, IRequest $request) {
    $route = array_filter($routes, function($route) use($request) {
      return ($route->getCompiledURI() ?? $route->getUri()) === $request->getUri();
    });

    return array_shift($route);
  }

  /**
   * Returns an array of routes with all verbs or 
   * returns an array of routes with a chosen verb
   * 
   * @return Route[]
   */
  protected function getRoutes(?string $verb): array {
    return !$verb ? $this->routes : $this->routes[$verb];
  }

  /**
   * Compile the current request params into matches static routes uri
   * 
   * @return void
   */
  private function compileRoute(IRequest $request): void {
    $_routes = $this->getRoutes($request->getVerb());

    foreach ($_routes as $key => $route) {
      if(!$route->isDynamicRoute()) continue;

      list($requestParams, $resources) = $this->getCurrentUriParams($request);

      $compiledURI = $this->getCompiledURI($requestParams, $resources, $route);
      
      $route->setParams($requestParams);
      $route->setCompiledURI($compiledURI);
    }
  }

  /**
   * Get the current uri params and resources
   * 
   * @return array
   */
  private function getCurrentUriParams(Request $request): array {
    $_uri = explode('/', $request->getUri());
    foreach($_uri as $k => $v) {
      $k % 2 != 0 ? 
        $requestParams[] = $v :
        $resources[] = $v;
    };

    return [$requestParams, $resources];
  }

  /**
   * Get the static uri compiled with of the params of the current uri
   * 
   * @return string
   */
  private function getCompiledURI(array $params, array $resources, IRoute $route): string {
    $_compiledURI = '';
    preg_match_all('#\{(!)?(\w+)\}#', $route->getUri(), $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
    foreach ($matches as $key => $match) {
      $routeParams[] = $params[$key];

      //replace in static url
      if(strlen($_compiledURI) > 0) $_compiledURI .= '/';
      $_compiledURI .= $resources[$key] . '/' . $params[$key];
    }

    return $_compiledURI;
  }
}