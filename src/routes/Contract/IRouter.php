<?php

namespace App\Routes\Contract;

use App\Routes\Contract\IRequest;

interface IRouter
{
  function dispatch(IRequest $request): bool;
}