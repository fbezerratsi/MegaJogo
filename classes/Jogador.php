<?php
    
    include_once 'Conexao.php';

    class Jogador {
        private $id;
        private $nome;
        private $endereco;
        private $cpf;
        private $telefone;
        private $jogada;
        private $email;
        private $login;
        private $senha;
        
        public function Jogador($id, $nome, $endereco, $cpf, $telefone, $jogada, $email, $login, $senha) {
            $this->id = $id;
            $this->nome = $nome;
            $this->endereco = $endereco;
            $this->cpf = $cpf;
            $this->telefone = $telefone;
            $this->jogada = $jogada;
            $this->email = $email;
            $this->login = $login;
            $this->senha = $senha;
        }
        
        public function buscarSenha($senha) {
            $con = new Conexao();
            $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);
            
            if (!$link) {
                return false;
            }
            
            $sql = "select nome,login from jogador where senha = '". md5($senha) ."'";
            
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
         * Lista todos os jogadores
         * @return boolean
         */
        public function listarJogadores() {
            $con = new Conexao();
            $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);
            
            if (!$link) {
                return false;
            }
            
            $sql = "select * from jogador";
            
            $res = mysqli_query($link, $sql);
            if (!$res) {
                return false;
            }
            
            print '<table style="border: 0px">';
            print '<th>Nome</th> <th>Cidade</th> <th>Estado</th> <th>Telefone</th> <th>E-mail</th>';
            $cor = 'green';
            while ($row = mysqli_fetch_array($res)) {
                if ($cor === 'green') {
                    $cor = "silver";
                } else {
                    $cor = "green";
                }
                print '<tr style="background:'.$cor.';border:0px">';
                print '<td style="color:white;padding:5px;color:white;border:0px">'. $row['nome'] .'</td>';
                print '<td style="color:white;padding:5px;color:white;border:0px">'. $row['cidade'] .'</td>';
                print '<td style="color:white;padding:5px;color:white;border:0px">'. $row['estado'] .'</td>';
                print '<td style="color:white;padding:5px;color:white;border:0px">'. $row['telefone'] .'</td>';
                print '<td style="color:white;padding:5px;color:white;border:0px">'. $row['email'] .'</td>';
                print '</tr>';
            }
            print '</table>';
            
            mysqli_close($link);
        }
        
        /**
         * Atualiza um determinado jogador
         * @param type $id do jogador
         * @return boolean
         */
        public function atualizarJogador($id,$nome,$cpf,$rua,$numero,$bairro,$cidade,$estado,$cep,$telefone,$login,$email) {
            $con = new Conexao();
            $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);
            
            if (!$link) {
                return false;
            }
            
            $sql = "update jogador set nome = '$nome',cpf = '$cpf',"
                    . "rua='$rua',numero=$numero,bairro='$bairro',"
                    . "cidade='$cidade',estado='$estado',cep='$cep',"
                    . "telefone='$telefone',login = '$login',"
                    . "email='$email' where idjogador = $id";
            
            $res = mysqli_query($link, $sql);
            if (!$res) {
                return false;
            }
            
            return true;
            
            
            mysqli_close($link);
        }

                /**
         * Listar Um só jogador para ser alterado
         * @param type $id
         * @return um array com todos os campos do jogador no banco de dados
         */
        public function listarJogador($id) {
            $con = new Conexao();
            $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);
            
            if (!$link) {
                return false;
            }
            
            $sql = "select * from jogador where idjogador = $id";
            
            $res = mysqli_query($link, $sql);
            if (!$res) {
                return false;
            }
            
            while ($row = mysqli_fetch_array($res)) {
                return $row;
            }
            
            
            mysqli_close($link);
        }

         /**
         * Verifica se existe login e senha correspondente
         * @param type $login
         * @param type $senha
         * @return boolean
         */
        public function autenticar($login, $senha) {
            $con = new Conexao();
            $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);
            
            if (!$link) {
                return false;
            }
            
            $sql = "select * from jogador where login = '".$login."' and senha = '".md5($senha)."'";
            
            $res = mysqli_query($link, $sql);
            if (mysqli_num_rows($res)) {
                return true;
            } else {
                return false;
            }
            
            
            mysqli_close($link);
        }
        
        /**
         * Buscar o nome do Jogador para aparecer no Bem vindo, 'nome do jogado'
         * @param type $login
         * @param type $senha
         * @return boolean
         */
        public function buscarNome($login, $senha) {
            $con = new Conexao();
            $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);
            
            if (!$link) {
                return false;
            }
            
            $sql = "select * from jogador where login = '".$login."' and senha = '".md5($senha)."'";
            
            $res = mysqli_query($link, $sql);
            if ($row = mysqli_fetch_array($res)) {
                return $row;
            }
            
            
            mysqli_close($link);
        }
        
        public function buscarId($login) {
            $con = new Conexao();
            $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);
            
            if (!$link) {
                return 0;
            }
            
            $sql = "select idjogador from jogador where login = '".$login."'";
            
            $res = mysqli_query($link, $sql);
            while ($nome = mysqli_fetch_array($res)) {
                return $nome['idjogador'];
            }
            
            mysqli_close($link);
        }

        /**
         * Cadastra um jogador no banco de dados
         * @return boolean
         */
        public function inserirJogador() {
            $con = new Conexao();
            $link = mysqli_connect($con::LOCAL, $con::USUARIO, $con::SENHA, $con::BANCO);
            
            if (!$link) {
                return false;
            }
            
            $sql = "insert into jogador(nome,cpf,rua,numero,bairro,cidade,estado,cep,telefone,login,senha,email)"
                    . " values('$this->nome', '$this->cpf', '".$this->endereco->getRua()."', ".$this->endereco->getNumero().", '".$this->endereco->getBairro()."', '".$this->endereco->getCidade()."', '".$this->endereco->getEstado()."', '".$this->endereco->getCep()."', '$this->telefone', '$this->login', '". md5($this->senha) ."', '$this->email')";
            
            $res = mysqli_query($link, $sql);
            
            if (!$res) {
                return false;
            }
            
            return true;
            
            mysqli_close($link);
        }
                
        function mostrar() {
            echo '<table style="border-style: solid;">';
            echo '<tr>';
            echo '<td>Nome: </td><td>'.$this->nome . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Rua: </td><td>'.$this->endereco->getRua() . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Número: </td><td>'.$this->endereco->getNumero() . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Bairro: </td><td>'.$this->endereco->getBairro() . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Cidade: </td><td>'.$this->endereco->getCidade() . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Estado: </td><td>'.$this->endereco->getEstado() . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Cep: </td><td>'.$this->endereco->getCep() . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Telefone: </td><td>' . $this->telefone . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>CPF.: </td><td>'.$this->cpf . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Jogada: </td><td>'. $this->jogada->getNum01() . '-' 
                    . $this->jogada->getNum02() 
                    . '-' . $this->jogada->getNum03() 
                    . '-' . $this->jogada->getNum04() 
                    . '-' . $this->jogada->getNum05() 
                    . '-' . $this->jogada->getNum06() . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>E-mail: </td><td>'.$this->email . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Login: </td><td>'.$this->login . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Senha: </td><td>'.$this->senha . '</td>';
            echo '</tr>';
            echo '</table>';
        }
        
        /**
         * Valida cpf
         * @param type $cpf
         * @return boolean
         */
        function validaCPF($cpf){	
            // Verifiva se o nÃºmero digitado contÃ©m todos os digitos
            $cpf = str_pad(ereg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);

                // Verifica se nenhuma das sequÃªncias abaixo foi digitada, caso seja, retorna falso
            if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
                {
                return false;
            }
                else
                {   // Calcula os nÃºmeros para verificar se o CPF Ã© verdadeiro
                for ($t = 9; $t < 11; $t++) {
                    for ($d = 0, $c = 0; $c < $t; $c++) {
                        $d += $cpf{$c} * (($t + 1) - $c);
                    }

                    $d = ((10 * $d) % 11) % 10;

                    if ($cpf{$c} != $d) {
                        return false;
                    }
                }

                return true;
            }
        }
        
        public function getId() {
            return $this->id;
        }

        public function getNome() {
            return $this->nome;
        }

        public function getEndereco() {
            return $this->endereco;
        }

        public function getCpf() {
            return $this->cpf;
        }

        public function getTelefone() {
            return $this->telefone;
        }

        public function getJogada() {
            return $this->jogada;
        }

        public function getEmail() {
            return $this->email;
        }

        public function getLogin() {
            return $this->login;
        }

        public function getSenha() {
            return $this->senha;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setNome($nome) {
            $this->nome = $nome;
        }

        public function setEndereco($endereco) {
            $this->endereco = $endereco;
        }

        public function setCpf($cpf) {
            $this->cpf = $cpf;
        }

        public function setTelefone($telefone) {
            $this->telefone = $telefone;
        }

        public function setJogada($jogada) {
            $this->jogada = $jogada;
        }

        public function setEmail($email) {
            $this->email = $email;
        }

        public function setLogin($login) {
            $this->login = $login;
        }

        public function setSenha($senha) {
            $this->senha = $senha;
        }
        
    }

?>
