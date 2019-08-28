<?php

use IRequest;

interface IRouter {

  function dispatch(IRequest $request): bool;
}