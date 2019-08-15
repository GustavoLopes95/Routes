<?php

abstract class AbstractVeiculo {

  protected $idVeiculo;
  protected $placa;
  protected $numChassi;
  protected $cor;
  protected $ano;
  protected $marca;
  protected $modelo;
  protected $pesoMaximo;
  protected $preco;
  protected $numRoda;

  abstract function inserir(): void;
  abstract function listarUm(): void;
  abstract function listarTodos(): void;
}