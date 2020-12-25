<?php

    include_once 'Conexao.php';
    
    
    class Jogada {
        private $id;
        private $num01;
        private $num02;
        private $num03;
        private $num04;
        private $num05;
        private $num06;
        private $premio;        
        
        public function jogada($id, $num01, $num02, $num03, $num04, $num05, $num06, $premio) {
            $this->id = $id;
            $this->num01 = $num01;
            $this->num02 = $num02;
            $this->num03 = $num03;
            $this->num04 = $num04;
            $this->num05 = $num05;
            $this->num06 = $num06;
            $this->premio = $premio;
        }
        
        /**
         * Mostra os números ordenados
         */
        public function mostrarOrdenado() {
            $arrei = array($this->num01, $this->num02, $this->num03, $this->num04, $this->num05, $this->num06);
            sort($arrei);

            $this->setNum01($arrei[0]);
            $this->setNum02($arrei[1]);
            $this->setNum03($arrei[2]);
            $this->setNum04($arrei[3]);
            $this->setNum05($arrei[4]);
            $this->setNum06($arrei[5]);
            
        }
        
        /**
         * 
         */
        public function ranking() {
            $con = new Conexao();
            $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);
            
            if (!$link) {
                return false;
            }
            
            $sql = "select jodor.nome as nome, joda.pontuacao as pontuacao from jogador as jodor 
inner join jogada as joda on jodor.idjogador=joda.jogador_idjogador 
inner join rodada as roda on roda.idrodada=joda.rodada_idrodada
where roda.datatermino is NULL order by pontuacao desc";
            //$sql = "select jodor.nome as nome, joda.pontuacao as pontuacao from jogador as jodor inner join jogada as joda on jodor.idjogador=joda.jogador_idjogador 
//order by pontuacao desc";
            
            $res = mysqli_query($link, $sql);
            
            if (!$res) {
                return false;
            }
            print '<table class="table table-bordered table-hover table-condensed">';
            
            print '<thead>';
            print '<tr>';
            print '<th></th><th>Nome</th><th>Acertos</th>';
            print '</tr>';
            print '</thead>';
            $cont = 1;
            
            while ($row = mysqli_fetch_array($res)) {
                if ($cont == 11) {
                    break;
                }
                print '<tbody>';
                print '<tr class="success">';
                print '<td>'.$cont.'º</td>';
                print '<td>'.$row['nome'].'</td>';
                if ($row['pontuacao'] == 6) {
                    print '<td>'.$row['pontuacao'].'</td>';
                    print '<td>GANHADOR</td>';
                } else {
                    print '<td>'.$row['pontuacao'].'</td>';
                }
                print '</tr>';
                print '</tbody>';
                $cont = $cont + 1;
            }
            print '</table>';
            
            return true;
            
            mysqli_close($link);
        }

                /**
         * Insere número da mega no banco de dados
         * @param type $n1
         * @param type $n2
         * @param type $n3
         * @param type $n4
         * @param type $n5
         * @param type $n6
         * @param type $data
         * @param type $hora
         * @param type $rodada
         * @return boolean
         */
        public function guardarNumerosMega($n1,$n2,$n3,$n4,$n5,$n6,$data,$hora,$rodada) {
            $con = new Conexao();
            $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);
            
            if (!$link) {
                return false;
            }
            
            $sql = "insert into nmega(n1,n2,n3,n4,n5,n6,data,hora,rodada_idrodada)"
                    . " values($n1,$n2,$n3,$n4,$n5,$n6,'$data','$hora',$rodada)";
            
            $res = mysqli_query($link, $sql);
            
            if (!$res) {
                return false;
            }
            
            return true;
            
            mysqli_close($link);
        }
        
        
        public function inserirJogada($n1,$n2,$n3,$n4,$n5,$n6,$pontuacao,$data,$hora,$jogador,$rodada) {
            $con = new Conexao();
            $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);
            
            if (!$link) {
                return false;
            }
            
            $sql = "insert into jogada(n1,n2,n3,n4,n5,n6,pontuacao,data,hora,jogador_idjogador,rodada_idrodada)"
                    . " values($n1,$n2,$n3,$n4,$n5,$n6,$pontuacao,'$data','$hora',$jogador,$rodada)";
            
            $res = mysqli_query($link, $sql);
            
            if (!$res) {
                return false;
            }
            
            return true;
            
            mysqli_close($link);
        }

        /**
         * Insere a pontuação de acordo com o número da megasena inserido
         */
        public function inserirPontuacao($n1, $rodada) {
            $con = new Conexao();
            $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);
            
            if (!$link) {
                return false;
            }
            
            // Se o n1 for encontrado na tabela nmega que são todos os número da mega sena inserido no banco, aí sim 
            // ele irá procurar nas jogadas dos jogadores.
            $sql1 = "call procurar_numero_mega(".$rodada.",".$n1.",@saida)";
            $res10 = mysqli_query($link, $sql1);
            //$sql3 = "select @ret as r";
            $res3 = mysqli_query($link, "select @saida as s");
            //$row1 = mysql_fetch_row($res3);
            while ($row1 = mysqli_fetch_array($res3)) {
                
                if ($row1['s'] != 0) {
                    $comando = "set @saida = 0";
                    mysqli_query($link, $comando);
                    $sql = "SELECT idjogada FROM jogada where $n1 in (n1,n2,n3,n4,n5,n6) and rodada_idrodada=$rodada";
                    $res = mysqli_query($link, $sql);

                    if (!$res) {
                        return false;
                    }

                    while ($row = mysqli_fetch_array($res)) {
                        //echo $row['idjogada'].'<br/>';
                        $sql2 = "call inserir_pontuacao(".$row['idjogada'].")";
                        $res2 = mysqli_query($link, $sql2);
                        if (!$res2) {
                            return false;
                        }
                    }
                    return true;
                } else {
                    return false;
                }
            }
            
                    
            return true;
            
            mysqli_close($link);
        }
        
        
        public function pegarRodada(){
            $con = new Conexao();
            $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);
            
            if (!$link) {
                return false;
            }
            
            $sql = "select idrodada from rodada where datatermino <> ''";
            
            $res = mysqli_query($link, $sql);
            
            if (!$res) {
                return false;
            }
            
            return true;
            
            mysqli_close($link);
        }


        public function getNum01() {
            return $this->num01;
        }
        public function getNum02() {
            return $this->num02;
        }
        public function getNum03() {
            return $this->num03;
        }
        public function getNum04() {
            return $this->num04;
        }
        public function getNum05() {
            return $this->num05;
        }
        public function getNum06() {
            return $this->num06;
        }
        
        public function setNum01($num) {
            $this->num01 = $num;
        }
        public function setNum02($num) {
            $this->num02 = $num;
        }
        public function setNum03($num) {
            $this->num03 = $num;
        }
        public function setNum04($num) {
            $this->num04 = $num;
        }
        public function setNum05($num) {
            $this->num05 = $num;
        }
        public function setNum06($num) {
            $this->num06 = $num;
        }
        
    }

?>
