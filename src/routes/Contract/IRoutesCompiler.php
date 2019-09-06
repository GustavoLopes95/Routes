<?php

namespace App\Routes\Contract;

use App\Routes\Contract\IRoute;

interface IRoutesCompiler
{
  static function compiler(Array $requestParams, Array $resources, IRoute $route): String;
}