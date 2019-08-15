<?php

class Caminhao extends AbstractVeiculo {

  
  protected $idCaminhao;
  protected $idVeiculo;
  protected $pesoMaximo;
  protected $quantidadeEixo;

  public function __contruct(String $dadosCaminhao, String $dadosVeiculo) {

  }
  
  public function getIdCaminhao() {
    return $this->idCaminhao;
  }

  public function getIdVeiculo() {
    return $this->idVeiculo;
  }

  public function getPesoMaximo() {
    return $this->pesoMaximo;
  }

  public function getQuantidadeEixo() {
    return $this->quantidadeEixo;
  }

  public function setIdCaminhao($idCaminhao) {
    $this->idCaminhao = $idCaminhao;
  }

  public function setIdVeiculo($idVeiculo) {
    $this->idVeiculo = $idVeiculo;
  }

  public function setPesoMaximo($pesoMaximo) {
    $this->pesoMaximo = $pesoMaximo;
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