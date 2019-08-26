<?php

namespace App\Routes;

class Route {

  /**
   * The route uri
   * 
   * @var string
   */
  protected $uri;

  /**
   * The compiled uri
   * 
   * @var string
   */
  protected $compiledURI;

  /**
   * The route verb
   * 
   * @var string
   */
  protected $verb;

  /**
   * The route action
   * 
   * @var Closure/array;
   */
  protected $action;

  /**
   * The route controller
   * 
   * @var mixed
   */
  protected $controller;

  /**
   * The route params
   * 
   * @var array
   */
  protected $params;
  
  /**
   * The route namespace
   * 
   * @var string
   */
  protected $namespace;

  /**
   * @const integer
   */
  private const MISSING_ACTION = 1;

  /**
   * @const integer
   */
  private const MALFORMED_ACTION = 2;
  /**
   * @const integer
   */
  private const METHOD_UNSUPPORTED = 3;
 
  public function __construct(String $uri, $action, String $verb, String $namespace) {
    $this->uri = !($uri === '/') ? $uri : '';
    $this->verb = $verb;
    $this->namespace = $namespace;
    $this->params = [];
    $this->compiledURI = null;
    $this->action = $this->makeCallable($action, $namespace);        
  }
  
  /**
   * Get the route uri
   * 
   * @return String
   */
  public function getUri(): String {
    return $this->uri;
  }

  /**
   * Get the route verb [GET, POST, PUT, DELETE...]
   * 
   * @return String
   */
  public function getVerb(): String {
    return $this->verb;
  }

  /**
   * Get the route action
   * 
   * @return Closure/String
   */
  public function getAction() {
    return $this->action;
  }

  /**
   * Get the route namespace
   * 
   * @return String
   */
  public function getNamespace(): String {
    return $this->namespace;
  }

  /**
   * Get the route params
   * 
   * @return array/null
   */
  public function getParams(): ?array {
    return $this->params;
  }

  /**
   * Set the route params
   * 
   * @return void
   */
  public function setParams(array $params): void {
    $this->params = $params;
  }

  /**
   * Set the route params
   * 
   * @return bool
   */
  public function isDynamicRoute(): bool {
    $_uri    = $this->uri;
    $_params = null;

    preg_match_all("#\{(!)?(\w+)\}#", $_uri, $_params, PREG_SET_ORDER);
    return isset($_params[0]);
  }

  /**
   * Get compiled route URI
   * 
   * @return string/null
   */
  public function getCompiledURI(): ?string {
    return $this->compiledURI;
  }

  /**
   * Set compiled route URI
   * 
   * @return string
   */
  public function setCompiledURI(String $uri): void {
    $this->compiledURI = $uri;
  }

  /**
   * Valid and format the action to a valid pattern
   * 
   * @return Closure/array
   */
  private function makeCallable($action, String $namespace) {
    if(!$this->valideAction($action)) return false;


    if(is_callable($action)) {
      return $action;
    }

    list($controller, $method) = explode('@', $action);
    return ["{$namespace}\\{$controller}", $method];
  }

  /**
   * Verify if the action value used in the uri is valid
   * 
   * @return Exception/bool
   */
  private function valideAction($action) {

    if(is_null($action)) {
      throw new \LogicException("Missing the action for [{$uri}], please inform it", SELF::MISSING_ACTION);
    }


    if(is_string($action) && strpos($action, '@') === 0) {
      throw new \LogicException("Malformed action for resource [{$uri}], use the pattern <controller>@<method>", SELF::MALFORMED_ACTION);
    } else if (!is_string($action) && !is_callable($action)) {
      throw new \Exception("The method is unsupported", SELF::METHOD_UNSUPPORTED);
    }

    return true;
  }

 
}