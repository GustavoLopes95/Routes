<?php

namespace App\Routes\Contract;

interface IRoute
{
  function getVerb(): string;
  function getUri(): string;
  function getCompiledURI(): string;
  function setParams(): void;
  function setCompiledURI(): void;
}