<?php

namespace App\Routes\Contract;

use App\Routes\Contract\IRouter;

interface IRequest
{
  static function capture(IRouter $router): void;
  function getUri(): string;
  function getPost(?string $name): array;
  function query(?string $name): array;
  function getVerb(): string;
}