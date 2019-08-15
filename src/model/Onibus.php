<?php

class Onibus extends AbstractVeiculo {

  protected $idOnibus;
  protected $idVeiculo;
  protected $qtdPassageiro;
  protected $quantidadeEixo;

  public function __construct(String $dadosOnibus, String $dadosVeiculo) {

  }

  public function getIdOnibus() {
    return $this->idOnibus;
  }

  public function getIdVeiculo() {
    return $this->idVeiculo;
  }

  public function getQtdPassageiro() {
    return $this->qtdPassageiro;
  }

  public function getQuantidadeEixo() {
    return $this->quantidadeEixo;
  }

  public function setIdOnibus($idOnibus) {
    $this->idOnibus = $idOnibus;
  }

  public function setIdVeiculo($idVeiculo) {
    $this->idVeiculo = $idVeiculo;
  }

  public function setQtdPassageiro($qtdPassageiro) {
    $this->qtdPassageiro = $qtdPassageiro;
  }

  public function setQuantidadeEixo($quantidadeEixo) {
    $this->quantidadeEixo = $quantidadeEixo;
  }

  public function inserir(): void {

  }

  public function listarUm(): void {

  }

  public function listarTodos(): void {

  }



}