<?php

class Carro extends AbastractVeiculo {  

  private $idCarro;
  private $idVeiculo;
  private $qtdPassageiros;
  private $numPortas;

  public function __construct(String $dadosCarro, String $dadosVeiculo) {
    
  }
  
  public function getIdCarro() {
    return $this->idCarro;
  }

  public function getIdVeiculo() {
    return $this->idVeiculo;
  }

  public function getQtdPassageiros() {
    return $this->qtdPassageiros;
  }

  public function getNumPortas() {
    return $this->numPortas;
  }

  public function setIdCarro($idCarro){
    $this->idCarro = $idCarro;
  }

  public function setIdVeiculo($idVeiculo){
    $this->idVeiculo = $idVeiculo;
  }

  public function setQtdPassageiros($qtdPassageiros){
    $this->qtdPassageiros = $qtdPassageiros;
  }

  public function setumPortas($numPortas){
    $this->numPortas = $numPortas;
  }

  public function inserir(): void {

  }

  public function listarUm(): void {

  }

  public function listarTodos(): void {

  }

}