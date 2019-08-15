<?php

namespace App\Routes;

class Route {

  /**
   * @var string
   */
  protected $uri;

  /**
   * @var string
   */
  protected $verb;

  /**
   * @var array;
   */
  protected $action;

  /**
   * 
   * @var mixed
   */
  protected $controller;

  private static $MISSING_ACTION = 1;
  private static $MALFORMED_ACTION = 2;

  public function __construct(String $uri, String $action, String $verb) {
    $this->uri = $uri;
    $this->verb = $verb;
    $this->action = $this->valideAction($action);
  }

  
  public function getUri() {
    return $this->uri;
  }

  public function getVerb() {
    return $this->verb;
  }

  public function getAction() {
    return $this->action;
  }

  private function valideAction($action) {

    if(is_null($action)) {
      throw new Exception("The resource $uri missing the action, please inform it", SELF::MISSING_ACTION);
      
    }

    if(!strpos($action, '@')) {
      throw new Exception("Malformed action to resource $uri, use the pattern <controller>@<method>", SELF::MALFORMED_ACTION);
    }

    return $this->makeCallable($action);
  }

  private function makeCallable(String $action) {
    list($controller, $method) = explode('@', $action);
    return [$controller, $method];
  }
}