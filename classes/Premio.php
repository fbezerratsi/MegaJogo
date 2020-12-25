<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Premio
 *
 * @author Felipe
 */
class Premio {
    
    private $idpremio;
    private $nome;
    private $descricao;
    private $rodada;
    
    function __construct($idpremio, $nome, $descricao, $rodada) {
        $this->idpremio = $idpremio;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->rodada = $rodada;
    }


    /**
     * Insere o Premio
     */
    public function inserirPremio(){
        $con = new Conexao();
        $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);

        if (!$link) {
            return false;
        }

        $sql = "insert into premio(nome,descricao,rodada_idrodada) values('". $this->getNome() ."','". $this->getDescricao() ."', ". $this->getRodada()->getIdrodada() .")";

        $res = mysqli_query($link, $sql);

        if (!$res) {
            return false;
        }

        return true;

        mysqli_close($link);
    }


    public function getIdpremio() {
        return $this->idpremio;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getRodada() {
        return $this->rodada;
    }

    public function setIdpremio($idpremio) {
        $this->idpremio = $idpremio;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setRodada($rodada) {
        $this->rodada = $rodada;
    }


    
}
