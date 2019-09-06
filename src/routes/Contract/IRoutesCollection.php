<?php

namespace App\Routes\Contract;

use App\Routes\Contract\IRoute;
use App\Routes\Contract\IRequest;

interface IRoutesCollection
{
  function add(IRoute $route): IRoute;
  function matchRoute(IRequest $request): ?IRoute;
  function filterRoute(Array $routes, IRequest $request);
}