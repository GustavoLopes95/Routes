<?php

  function __autoload($class) {
    $filename = dirname(__DIR__) . '/src/'. $class . '.php';
    require_once($filename);
  }