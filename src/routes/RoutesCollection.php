<?php

namespace App\Routes;

use App\Routes\Contract\IRoute;
use App\Routes\Contract\IRequest;
use App\Routes\Contract\IRoutesCollection;

/**
 * RoutesColletion class
 * 
 * @author Luiz Gustavo A. Lopes <https://github.com/GustavoLopes95>
 * @package 
 */
class RoutesCollection implements IRoutesCollection
{

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
  private function getRoutes(?string $verb): array {
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

      $compiledURI = RoutesCompiler::compiler($requestParams, $resources, $route);
      
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
}