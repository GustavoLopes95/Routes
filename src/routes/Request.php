<?php

namespace App\Routes;

use App\Routes\Contract\IRouter;

/** Handle with Request */
class Request {
  
  /**
   * The get params
   * 
   * @var array
   */
  protected $query;

  /**
   * The post data
   * 
   * @var array
   **/
  protected $data;
  
  /**
   * The session cookies
   * 
   * @var array
   **/
  protected $cookies;

  /**
   * The files data
   * 
   * @var array
   **/
  protected $files;

  /**
   * Global variavel $_SERVER
   * 
   * @var array
   **/
  protected $server;

  /**
   * The request header
   * 
   * @var array
   */
  protected $headers;

  /**
   * The request uri
   * 
   * @var string
   */
  protected $uri;
  
  /**
   * The router with all configured routes
   * 
   * @var App\Routes\Router;
   */
  protected $router;

  protected function __construct(array $query = [], array $data = [], array $cookies = [], array $files = [], array $server = [], IRouter $router) {
    $this->router = $router;
    $this->initialize($query, $data, $cookies, $files, $server);
  }

  /**
   * Method for capture and handler with the current request
   * 
   * @return void
   */
  public static function capture(IRouter $router): void {
    self::createRequest($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER, $router);
  }

  /**
   * Create a new Request object with the date of current request
   * 
   * @return self
   */
  private static function createRequest(array $query = [], array $data = [], array $cookies = [], array $files = [], array $server = [], IRouter $router): self {
    return new static($query, $data, $cookies, $files, $server, $router);
  }

  /**
   * Mapping all data the current request and process it
   * 
   * @return void
   */
  private function initialize(array $query = [], array $data = [], array $cookies = [], array $files = [], array $server = []): void {
    $this->query    = $query;
    $this->data     = $data;
    $this->cookies  = $cookies;
    $this->files    = $files;
    $this->server   = $server;

    $this->setHeaders($this->server);
    $this->setUri();

    $this->dispatch();
  }

  /**
   * Return an array with all header data
   * 
   * @return void
   */
  private function setHeaders($server): void {
    $_headers = [];
    foreach($server as $key => $value) {
      if(0 === strpos($key, 'HTTP_')) {
        $_headers[$key] = $value;
      } else if(0 === strpos($key, 'CONTENT_')) {
        $_headers[$key] = $value;
      } else if(0 === strpos($key, 'ACCESS_CONTROL_')) {
        $_headers[$key] = $value;
      }
    }

    $this->headers = $_headers;
  }

  /**
   * Get current request uri
   * 
   * @return string
   */
  public function getUri(): string {
    return $this->uri;
  }

  /**
   * Set current request uri
   * 
   * @return void
   */
  private function setUri(): void {
    $_uri = strpos($this->server['REQUEST_URI'], '?') ?
        ltrim(strstr($this->server['REQUEST_URI'], '?', true), '/') :
        ltrim(strstr($this->server['REQUEST_URI'], '/'), '/');
    $this->uri = $_uri;
  }

  /**
   * Get current request post data 
   * 
   * @return array
   */
  public function getPost(?string $name): array {
    if(count($this->data) === 0) return [];

    return !$name ? $this->data: $this->data[$name];
  }

  /**
   * Get current request get data 
   * 
   * @return array
   */
  public function query(?string $name): array {
    if(count($this->query) === 0) return [];
    
    return !$name ? $this->query: $this->query[$name];
  }

  /**
   * Get current request verb
   * 
   * @return String
   */
  public function getVerb(): string {
    return $this->server['REQUEST_METHOD'];
  }

  /**
   * Process the current request
   * 
   * @return bool
   */
  private function dispatch(): bool {
    return $this->router->dispatch($this);
  }
}