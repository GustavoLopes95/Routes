<?php

use IRoute;
use IRequest;

interface IRoutesCollection {

  function add(IRoute $route): IRoute;
  function matchRoute(IRequest $request): ?IRoute;
  function filterRoute(Array $routes, IRequest $request);
  function getRoutes(?string $verb): array;
}