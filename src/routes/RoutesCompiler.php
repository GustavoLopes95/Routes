<?php

namespace App\Routes;

use App\Routes\Contract\IRoute;
use App\Routes\Contract\IRoutesCompiler;

/**
 * RoutesCompiler class
 * 
 * @author Luiz Gustavo A. Lopes <https://github.com/GustavoLopes95>
 * @package 
 */
class RoutesCompiler implements IRoutesCompiler
{

  /**
   * Get the static uri compiled with of the params of the current uri
   * 
   * @return string
   */
  public static function compiler(Array $requestParams, Array $resources, IRoute $route): String {
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