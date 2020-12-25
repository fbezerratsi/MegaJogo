<?php

    include_once 'Conexao.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rodada
 *
 * @author Felipe
 */
class Rodada {
    
    private $idrodada;
    private $dataInicio;
    private $horaInicio;
    private $dataTermino;
    private $horaTermino;
    
    function __construct($idrodada, $dataInicio, $horaInicio, $dataTermino, $horaTermino) {
        $this->idrodada = $idrodada;
        $this->dataInicio = $dataInicio;
        $this->horaInicio = $horaInicio;
        $this->dataTermino = $dataTermino;
        $this->horaTermino = $horaTermino;
    }
    
    public function ChecarRodadaFechada() {
        $con = new Conexao();
        $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);
        
        if (!$link) {
            return false;
        }
        
        $sql = "select count(*) as contador from rodada where datatermino is NULL";
        
        $res = mysqli_query($link, $sql);

        if (!$res) {
            return false;
        }
        
        while ($row = mysqli_fetch_array($res)) {
            return $row["contador"];
        }
        
        mysqli_close($link);
    }
    
    /**
     * Insere uma rodada
     * @return boolean
     */
    public function inserirRodada() {
        $con = new Conexao();
        $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);

        if (!$link) {
            return false;
        }

        $sql = "insert into rodada(datainicio,horainicio) values('". $this->getDataInicio() ."','". $this->getHoraInicio() ."')";

        $res = mysqli_query($link, $sql);

        if (!$res) {
            return false;
        }

        return true;

        mysqli_close($link);
    }
    
    /**
     * Busca a rodada pela data
     * @param type $data
     * return id da rodada buscada
     */
    public function buscarIdRodada() {
        $con = new Conexao();
        $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);

        if (!$link) {
            return false;
        }

        
        $sql = "SELECT idrodada as id FROM rodada where datatermino is NULL";
        //$sql = "select idrodada from rodada where datainicio = '$data'";

        $res = mysqli_query($link, $sql);

        if (!$res) {
            return false;
        }
        
        while ($row = mysqli_fetch_array($res)) {
            return $row['id'];
        }

        return true;

        mysqli_close($link);
    }
    
    /**
     * 
     * @return um array com o id, nome e descrção da rodada
     */
    public function mostrarRodadaDescricao() {
        $con = new Conexao();
        $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);

        if (!$link) {
            return false;
        }

        $sql = "select r.idrodada as id, nome, descricao, r.dataFechamentoInscricao as dataFechamentoInscricao from premio as p inner join rodada as r 
on p.rodada_idrodada = r.idrodada where r.datatermino is null";

        $res = mysqli_query($link, $sql);

        if (!$res) {
            return false;
        }
        
        while ($row = mysqli_fetch_array($res)) {
            return $row;
        }

        return true;

        mysqli_close($link);
    }

    /**
     * Mostra as rodadas que estão disponíveis para que o jogador faça seu jogo em uma determinada jogada...
     * @param type $idrodada
     * @return um select com todas as rodadas que ainda estão em aberto...
     */
    public function mostrarRodadas() {
        $con = new Conexao();
        $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);

        if (!$link) {
            return false;
        }

        $sql = "select r.idrodada as id, nome, descricao from premio as p inner join rodada as r 
on p.rodada_idrodada = r.idrodada where r.datatermino is null";

        $res = mysqli_query($link, $sql);

        if (!$res) {
            return false;
        }
        print "<select name='selRodada'>";
        print "<option value=''></option>";
        while ($row = mysqli_fetch_array($res)) {
            print "<option value='". $row['id'] ."'> ". $row['nome'] ." </option>";
        }
        print '</select>';

        return true;

        mysqli_close($link);
    }
    
    public function getIdrodada() {
        return $this->idrodada;
    }

    public function getDataInicio() {
        return $this->dataInicio;
    }

    public function getHoraInicio() {
        return $this->horaInicio;
    }

    public function getDataTermino() {
        return $this->dataTermino;
    }

    public function getHoraTermino() {
        return $this->horaTermino;
    }

    public function setIdrodada($idrodada) {
        $this->idrodada = $idrodada;
    }

    public function setDataInicio($dataInicio) {
        $this->dataInicio = $dataInicio;
    }

    public function setHoraInicio($horaInicio) {
        $this->horaInicio = $horaInicio;
    }

    public function setDataTermino($dataTermino) {
        $this->dataTermino = $dataTermino;
    }

    public function setHoraTermino($horaTermino) {
        $this->horaTermino = $horaTermino;
    }



    
}
