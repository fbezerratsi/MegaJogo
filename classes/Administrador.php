<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once './classes/Conexao.php';
/**
 * Description of Administrador
 *
 * @author Felipe
 */
class Administrador {
    
    
    
    
    /**
     * Fecha as inscrições para que um jogador não possa mais jogar...
     * @return boolean
     */
    public function fecharPeriodoInscricao() {
        $con = new Conexao();
        $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);

        if (!$link) {
            return false;
        }

        $data = date("Y-m-d");
        $hora = date('H:m:s');

        $sql = "update rodada set dataFechamentoInscricao = '".$data."', horaFechamentoInscricao = '".$hora."' "
                . "where datatermino is null";

        $res = mysqli_query($link, $sql);

        if (!$res) {
            return false;
        }

        return true;

        mysqli_close($link);
    }
    
    public function fecharPeriodoRodada(){
        $con = new Conexao();
        $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);

        if (!$link) {
            return false;
        }

        $data = date("Y-m-d");
        $hora = date('H:m:s');

        $sql = "update rodada set datatermino = '".$data."', horatermino = '".$hora."' "
                . "where datatermino is null";

        $res = mysqli_query($link, $sql);

        if (!$res) {
            return false;
        }

        return true;

        mysqli_close($link);
    }
    
    /**
     * Exclui a conta do usuário logado
     * @param type $id do jogador logado
     * @return boolean
     */
    public function excluirConta($id){
        $con = new Conexao();
        $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);

        if (!$link) {
            return false;
        }

        $sql = "delete from jogador where idjogador=$id";

        $res = mysqli_query($link, $sql);

        if (!$res) {
            return false;
        }

        return true;

        mysqli_close($link);
    }
    
    public function rodadasAnteriores(){
        $con = new Conexao();
        $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);

        if (!$link) {
            return false;
        }

        $sql = "select rod.idrodada as rodada,p.nome as premio,jogador.nome as vencedor, jogador.cidade as cidade from jogada as jog 
                    inner join rodada as rod on rod.idrodada=jog.rodada_idrodada
                    inner join premio as p on p.idpremio=rod.idrodada
                    inner join jogador on jog.jogador_idjogador=jogador.idjogador 
                    where jog.pontuacao=6 order by rod.idrodada";

        $res = mysqli_query($link, $sql);

        if (!$res) {
            return false;
        }

        print '<table style="border:1px solid white;padding:5px;">';
        print '<th style="border:1px solid white;padding:5px;">Rodadas</th> <th style="border:1px solid white;padding:5px;">Prêmios</th> <th>Vencedores</th> <th style="border:1px solid white;padding:5px;">Localidades</th>';
        while ($row=  mysqli_fetch_array($res)) {
            print '<tr style="padding:5px;margin:5px;">';
            print '<td style="text-align:center;border:1px solid white;padding:5px;">'.$row["rodada"].'</td>';
            print '<td style="width:400px;border:1px solid white;padding:5px;">'.$row["premio"].'</td>';
            print '<td style="width:700px;border:1px solid white;padding:5px;">'.$row["vencedor"].'</td>';
            print '<td style="width:400px;border:1px solid white;padding:5px;">'.$row["cidade"].'</td>';
            print '</tr>';
        }
        print '</table>';
        
        return true;

        mysqli_close($link);
    }
    
    /**
     * para verificar antes de inserir os números da mega se existe algum ganhador
     * Se sim o sistema não deixará mais inserir números da mega sena...
     * @return boolean
     */
    public function verificaJogadaGanha() {
        $con = new Conexao();
        $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);

        if (!$link) {
            return false;
        }

        $sql = "select count(*) as contador from jogada as jog 
            inner join rodada as rod on jog.rodada_idrodada=rod.idrodada 
            where jog.pontuacao=6 and rod.datatermino is NULL";

        $res = mysqli_query($link, $sql);

        if (!$res) {
            return false;
        }
        
        while($row=  mysqli_fetch_array($res)){
            if ($row["contador"] == 0) {
                return false;
            } else {
                return true;
            }
        }

        return true;

        mysqli_close($link);
    }
    
    public function pegarUltimaRodada(){
        $con = new Conexao();
        $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);

        if (!$link) {
            return false;
        }

        $sql = "select max(data) as data from nmega;";

        $res = mysqli_query($link, $sql);

        if (!$res) {
            return false;
        }

        while($row=  mysqli_fetch_array($res)){
            return $row["data"];
        }
        
        return true;

        mysqli_close($link);
    }
    
    public function tirarRanking() {
        $data = $this->pegarUltimaRodada();
        
        $array = explode("-", $data);
        //print $array[1];
        
        $dataSub1 = date('Y-m-d', strtotime("-1 days"));
        $array2 = explode("-", $dataSub1);
        //print $array2[1];
        
        if ($array[1] == $array2[1] && $array[2] == $array2[2]) {
            $this->fecharPeriodoRodada();
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Lista jogadores daquela jogada aberta...
     */
    public function listarJogadoresRodada() {
        
        $con = new Conexao();
        $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);

        if (!$link) {
            return false;
        }

        $sql = "select joga.nome as nome, jog.n1 as n1,jog.n2 as n2,jog.n3 as n3,jog.n4 as n4,jog.n5 as n5,jog.n6 as n6 from jogada as jog
inner join rodada as rod on rod.idrodada=jog.rodada_idrodada
inner join premio as p on rod.idrodada=p.rodada_idrodada
inner join jogador as joga on jog.jogador_idjogador=joga.idjogador
where rod.datatermino is NULL order by joga.nome asc";

        $res = mysqli_query($link, $sql);

        if (!$res) {
            return false;
        }

        print '<table style="border:1px solid white;padding:5px;font-size:10px;">';
//        print '<th style="border:1px solid silver;padding:5px;">Nomes</th> <th style="border:1px solid silver;padding:5px;">Prêmios</th> <th>Vencedores</th> <th style="border:1px solid silver;padding:5px;">Localidades</th>';
        while ($row=  mysqli_fetch_array($res)) {
            print '<tr style="padding:5px;margin:5px;">';
            print '<td style="width:100px;text-align:center;border:1px solid silver;padding:5px;">'.$row["nome"].'</td>';
            print '<td style="width:20px;text-align:center;border:1px solid silver;padding:5px;">'.$row["n1"].'</td>';
            print '<td style="width:20px;text-align:center;border:1px solid silver;padding:5px;">'.$row["n2"].'</td>';
            print '<td style="width:20px;text-align:center;border:1px solid silver;padding:5px;">'.$row["n3"].'</td>';
            print '<td style="width:20px;text-align:center;border:1px solid silver;padding:5px;">'.$row["n4"].'</td>';
            print '<td style="width:20px;text-align:center;border:1px solid silver;padding:5px;">'.$row["n5"].'</td>';
            print '<td style="width:20px;text-align:center;border:1px solid silver;padding:5px;">'.$row["n6"].'</td>';
            print '</tr>';
        }
        print '</table>';
        
        return true;

        mysqli_close($link);
        
    }
    
    public function pegarRodadaAberta() {
        $con = new Conexao();
        $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);

        if (!$link) {
            return false;
        }

        $sql = "select p.nome as premio, roda.idrodada as rodada from jogador as jodor 
inner join jogada as joda on jodor.idjogador=joda.jogador_idjogador 
inner join rodada as roda on roda.idrodada=joda.rodada_idrodada
inner join premio as p on p.rodada_idrodada=roda.idrodada
where roda.datatermino is NULL";

        $res = mysqli_query($link, $sql);

        if (!$res) {
            return false;
        }

        $row=  mysqli_fetch_array($res);
        print "Rodada: " . $row["rodada"] . "<br />";
        print "Prêmio: " . $row["premio"];
        
        
        return true;

        mysqli_close($link);
    }
    
}
