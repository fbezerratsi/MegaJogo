<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    session_start();

    include './classes/Endereco.php';
    include './classes/Jogador.php';
    include './classes/Administrador.php';
    
    if (isset($_GET["acao"]) && $_GET["acao"] == '0') {
        $excluir = new Administrador();
        $idjogador = $_SESSION['idjogador'];
        print $excluir->excluirConta($idjogador);
        print '<script>';
        print 'alert("Conta Escluída com SUCESSO!")';
        print '</script>';
        session_destroy();
        header("Location: privadajogador.php");
        exit();
    }
    
    if (isset($_GET["id"])) {
        $jogador = new Jogador(0, '', '', '', '', '', '', '', '', '');
        $array = $jogador->listarJogador($_GET["id"]);
    }
    
    if (isset($_POST["btnEnviar"])) {
        $end = new Endereco(0, $_POST["txtRua"], $_POST["txtNumero"], 
                $_POST["txtBairro"], $_POST["txtCidade"], 
                $_POST["selEstado"], $_POST["txtCep"]);
        $jogador1 = new Jogador(0, '', $end, '', '', '', '', '', '', '');
        $nome = $_POST["txtNome"];
        $cpf = $_POST["txtCpf"];
        
        
        
        $rua = $jogador1->getEndereco()->getRua();
        $numero = $jogador1->getEndereco()->getNumero();
        $bairro = $jogador1->getEndereco()->getbairro();
        $cidade = $jogador1->getEndereco()->getCidade();
        $estado = $jogador1->getEndereco()->getEstado();
        $cep = $jogador1->getEndereco()->getCep();
        $ddd = $_POST["txtDDD"];
        $telefone = $_POST["txtTelefone"];
        $login = $_POST["txtLogin"];
        $email = $_POST["txtEmail"];
        
        if ($jogador1->atualizarJogador($_SESSION["idjogador"], $nome, $cpf, $rua, $numero, $bairro, $cidade, $estado, $cep, $ddd, $telefone, $login, $email)) {
            header("Location: privadajogador.php");
        } else {
            print '<script>';
            print 'alert("Não foi Possível alterar!")';
            print '</script>';
        }
        $array["nome"] = '';
        $array["cpf"] = '';
        $array["rua"] = '';
        $array["numero"] = '';
        $array["bairro"] = '';
        $array["cidade"] = '';
        $array["estado"] = '';
        $array["cep"] = '';
        $array["ddd"] = '';
        $array["telefone"] = '';
        $array["login"] = '';
        $array["email"] = '';
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/editarperfilcss.css" type="text/css" />
        <link rel="stylesheet" href="css/editarCadastrarJogadorCss.css" type="text/css" />
        <link rel="stylesheet" href="css/jquery-ui.css" type="text/css">
        
        <title></title>
            
        <script src="js/jquery-1.9.1.js"></script>
        <script src="js/jquery-ui.js"></script>
        
        <script type="text/javascript"> 
            
            $(function() {
                $( "#accordion" ).accordion();
            });
            
            $(document).ready(function(){
                $('#formulario').validate({
                    rules: {
                        nome: {
                            required: true,
                            minlength: 3
                        },
                        txtCpf: {
                            required: true,
                            minlength: 11
                        },
                        txtDDD: {
                            required: true,
                            minlength: 2
                        },
                        txtTelefone: {
                            required: true,
                            minlength: 8
                        },
                        txtLogin: {
                            required: true,
                            minlength: 6
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        senha: {
                            required: true
                        },
                        confirmar_senha: {
                            required: true,
                            equalTo: "#senha"
                        },
                        termos: "required"
                    },
                    messages: {
                        nome: {
                            required: "O campo nome é obrigatório.",
                            minlength: "O campo nome deve conter no mínimo 3 caracteres."
                        },
                        txtCpf: {
                            required: "O campo cpf é obrigatório.",
                            minlength: "O campo cpf deve conter 11 caracteres."
                        },
                        txtDDD: {
                            required: "O campo DDD é obrigatório.",
                            minlength: "O campo DDD deve conter 2 caracteres."
                        },
                        txtTelefone: {
                            required: "O campo Telefone é obrigatório.",
                            minlength: "O campo Telefone deve conter 8 caracteres."
                        },
                        txtLogin: {
                            required: "O campo Login é obrigatório.",
                            minlength: "O campo Login deve conter no mínimo 6 caracteres."
                        },
                        email: {
                            required: "O campo email é obrigatório.",
                            email: "O campo email deve conter um email válido."
                        },
                        senha: {
                            required: "O campo senha é obrigatório."
                        },
                        confirmar_senha: {
                            required: "O campo confirmação de senha é obrigatório.",
                            equalTo: "O campo confirmação de senha deve ser identico ao campo senha."
                        },
                        termos: "Para se cadastrar você deve aceitar os termos de contrato."
                    }

                });
            });
        </script>
        
    </head>
    <body>
        
        <div id="corpo">
            <div id="cabecalho">
                <div id="excluirConta">
                    <a href="editarperfil.php?acao=0" onclick="return confirm('Esta ação irá excluir definitivamente sua conta. Você tem certeza que deseja fazer isso?')">Excluir Conta</a>
                </div>
            </div>
            
            <div id="divAcordion">
                <form action="editarperfil.php" method="POST" id="formulario">
                    <div id="accordion">
                        <h3>Nome: Editar</h3>
                        <div>
                            <label>Nome:</label>
                          <input type="text" name="txtNome" id="nome" value="<?php echo $array["nome"];?>" />
                          <br />
                          <br />
                          <br />
                          <br />
                          <br />
                          <br />
                          <br />
                          <br />

                        </div>
                        <h3>CPF.: Editar</h3>
                        <div>
                            <label>CPF.:</label>
                          <input type="text" name="txtCpf" value="<?php 
                                        if ($array["cpf"] != "") {
                                            echo $array["cpf"]; 
                                        } else {
                                            echo ''; 
                                        }?>" />
                        </div>
                        <h3>Endereço: Editar</h3>
                        <div>
                            <label>Rua:</label>
                          <input type="text" name="txtRua" value="<?php echo $array["rua"];?>"/>
                          <label>Número:</label>
                          <input type="text" name="txtNumero" value="<?php echo $array["numero"];?>"/>
                          <label>Bairro:</label>
                          <input type="text" name="txtBairro" value="<?php echo $array["bairro"];?>" />
                          <label>Cidade:</label>
                          <input type="text" name="txtCidade" value="<?php echo $array["cidade"];?>" />
                          <label>Estado:</label>
                          <input type="text" name="selEstado" value="<?php echo $array["estado"];?>" maxlength="2" />
                          <br/>
                          <label>CEP.:</label>
                          <input type="text" name="txtCep" value="<?php echo $array["cep"];?>" />

                        </div>
                        <h3>Telefone: Editar</h3>
                        <div>
                            <label>Telefone:</label><br />
                          <input type="text" name="txtTelefone" maxlength="8" id="txtTelefone" value="<?php echo $array["telefone"];?>" />
                        </div>
                        <h3>Login: Editar</h3>
                        <div>
                            <label>Login:</label>
                          <input type="text" name="txtLogin" value="<?php echo $array["login"];?>" />
                          <label>E-mail:</label>
                          <input type="text" name="txtEmail" id="email" value="<?php echo $array["email"];?>" />
                        </div>

                      </div>
                    <input type="submit" name="btnEnviar" value="Cadastrar" id="botao" onclick="return confirm('Esta ação irá alterar o registro!')" />
                 </form>
            </div>
            
        </div>
        
</body>
</html>

