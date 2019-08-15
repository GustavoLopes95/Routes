<?php

namespace App\Routes;

use App\Routes\Router;

/** Handle with Request */
class Request {
  
  /**
   * @var array
   */
  protected $query;

  /**
   * @var array
   **/
  protected $request;
  
  /**
   * @var array
   **/
  protected $cookies;

  /**
   * @var array
   **/
  protected $files;

  /**
   * @var array
   **/
  protected $server;

  /**
   * @var array
   */
  protected $method;

  /**
   * @var array
   */
  protected $headers;

  /**
   * @var string
   */
  protected $uri;
  
  /**
   * @var App\Routes\Router;
   */
  protected $router;

  protected function __construct(array $query = [], array $request = [], array $cookies = [], array $files = [], array $server = [], Router $router) {
    $this->router = $router;
    $this->initialize($query, $request, $cookies, $files, $server);
  }

  public static function capture($router) {
    self::createRequest($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER, $router);
  }

  private static function createRequest(array $query = [], array $request = [], array $cookies = [], array $files = [], array $server = [], Router $router) {
    return new static($query, $request, $cookies, $files, $server, $router);
  }

  private function initialize(array $query = [], array $request = [], array $cookies = [], array $files = [], array $server = []) {
    $this->query    = $query;
    $this->request  = $request;
    $this->cookies  = $cookies;
    $this->files    = $files;
    $this->server   = $server;
    $this->headers  = $this->setHeaders($this->server);
    $this->uri      = $this->setUri();

    /** 
     * TODO: Improve router injection
     */
    $this->dispatch();
  }

  private function setHeaders($server) {
    $headers = [];
    foreach($server as $key => $value) {
      if(0 === strpos($key, 'HTTP_')) {
        $headers[$key] = $value;
      } else if(0 === strpos($key, 'CONTENT_')) {
        $headers[$key] = $value;
      } else if(0 === strpos($key, 'ACCESS_CONTROL_')) {
        $headers[$key] = $value;
      }
    }

    return $headers;
  }

  public function getUri() {
    return $this->uri;
  }

  private function setUri() {
    $uri = strpos($this->server['REQUEST_URI'], '?') ?
        ltrim(strstr($this->server['REQUEST_URI'], '?', true), '/') :
        ltrim(strstr($this->server['REQUEST_URI'], '/'), '/');
    return $uri;
  }

  public function getMethods() {

    if(null !== $this->method) {
      return $this->method;
    }
  }

  public function getVerb() {
    return $this->server['REQUEST_METHOD'];
  }

  private function dispatch() {
    return $this->router->dispatch($this);
  }
}