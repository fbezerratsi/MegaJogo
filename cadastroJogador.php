<!DOCTYPE html>
<?php
    include './classes/Endereco.php';
    include './classes/Jogador.php';
    
    
    
    if (isset($_POST["btnEnviar"])) {
        
        $jogador = new Jogador(0, '', '', '', '', '', '', '','','');
        $cpf_enviado = $jogador->validaCPF($_POST["txtCpf"]);
	// Verifica a resposta da funÃ§Ã£o e exibe na tela
	if($cpf_enviado == true) {
            $end = new Endereco(0, $_POST["txtRua"], $_POST["txtNumero"], $_POST["txtBairro"], $_POST["txtCidade"], $_POST["selEstado"], $_POST["txtCep"]);
            
            $jogador2 = new Jogador(0, $_POST["txtNome"], $end, $_POST["txtCpf"], $_POST["txtTelefone"], 0, $_POST["email"], $_POST["txtLogin"], $_POST["senha"]);
            if ($teste = $jogador2->inserirJogador()) {
                echo '<script>';
                echo 'alert("Cadastro Enviado!")';
                echo '</script>';
            } else {
                print $teste;
                echo '<script>';
                echo 'alert("ERRO no Cadastro!!!!!!!!!!!!!!")';
                echo '</script>';
            }
        }elseif($cpf_enviado == false) {
            print '<script>';
            print 'alert("cpf inválido");';
            print '</script>';
            //print "<script>window.alert(\"CPF inválido\");</script>";
//            echo '<script>';
//            echo 'alert("CPF Inválido")';
//            echo '</script>';
	}
    }
    
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        
        <link rel="stylesheet" href="css/formoid-flat-green.css" type="text/css" /> 
        
        <link rel="stylesheet" href="css/jquery-ui.css" />
        
        
<!--        <link rel="stylesheet" type="text/css" href="css/cadastrarJogadorCss.css">-->
        <script type="text/javascript" src="js/jquery.validate.js"></script>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/formoid-flat-green.js"></script>
        <script type="text/javascript" src="js/jquery.maskedinput.js"></script>
<!--        <script src="js/jquery-1.10.2.js"></script>
        <script src="js/jquery-ui.js"></script>-->
        
        <script type="text/javascript">
            
            function validarCPF(cpf) {	
                cpf = cpf.replace(/[^\d]+/g,'');	
                if(cpf == '') 
                    return false;	// Elimina CPFs invalidos conhecidos	
                if (cpf.length != 11 || cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999")		
                    return false;		// Valida 1o digito	
                add = 0;	
                for (i=0; i < 9; i ++)		
                    add += parseInt(cpf.charAt(i)) * (10 - i);	
                rev = 11 - (add % 11);	
                if (rev == 10 || rev == 11)		
                    rev = 0;	
                if (rev != parseInt(cpf.charAt(9)))		
                    return false;		// Valida 2o digito	
                add = 0;	
                for (i = 0; i < 10; i ++)		
                    add += parseInt(cpf.charAt(i)) * (11 - i);	
                rev = 11 - (add % 11);	
                if (rev == 10 || rev == 11)		
                    rev = 0;	
                if (rev != parseInt(cpf.charAt(10)))		
                    return false;			
                return true;   
            }
            
            $(document).ready(function(){
                
                $("#cep").mask("99.999-999");
                $("#cpf").mask("999.999.999-99");
                $("#telefone").mask("(99)9999-9999");
                
                
                $('#formulario').validate({
                    rules: {
                        confirmarSenha: {
                            equalTo: "#senha"
                        }
                    },
                    messages: {
                        confirmarSenha: {
                            equalTo: "O campo confirmação de senha deve ser identico ao campo senha."
                        }
                    }
                });
            });
            
//            $(document).ready(function(){
//                $('#formulario').validate({
//                    rules: {
//                        nome: {
//                            required: true,
//                            minlength: 3
//                        },
//                        txtCpf: {
//                            required: true,
//                            minlength: 11
//                        },
//                        txtDDD: {
//                            required: true,
//                            minlength: 2
//                        },
//                        txtTelefone: {
//                            required: true,
//                            minlength: 8
//                        },
//                        txtLogin: {
//                            required: true,
//                            minlength: 6
//                        },
//                        email: {
//                            required: true,
//                            email: true
//                        },
//                        senha: {
//                            required: true
//                        },
//                        confirmar_senha: {
//                            required: true,
//                            equalTo: "#senha"
//                        },
//                        termos: "required"
//                    },
//                    messages: {
//                        nome: {
//                            required: "O campo nome é obrigatório.",
//                            minlength: "O campo nome deve conter no mínimo 3 caracteres."
//                        },
//                        txtCpf: {
//                            required: "O campo cpf é obrigatório.",
//                            minlength: "O campo cpf deve conter 11 caracteres."
//                        },
//                        txtDDD: {
//                            required: "O campo DDD é obrigatório.",
//                            minlength: "O campo DDD deve conter 2 caracteres."
//                        },
//                        txtTelefone: {
//                            required: "O campo Telefone é obrigatório.",
//                            minlength: "O campo Telefone deve conter 8 caracteres."
//                        },
//                        txtLogin: {
//                            required: "O campo Login é obrigatório.",
//                            minlength: "O campo Login deve conter no mínimo 6 caracteres."
//                        },
//                        email: {
//                            required: "O campo email é obrigatório.",
//                            email: "O campo email deve conter um email válido."
//                        },
//                        senha: {
//                            required: "O campo senha é obrigatório."
//                        },
//                        confirmar_senha: {
//                            required: "O campo confirmação de senha é obrigatório.",
//                            equalTo: "O campo confirmação de senha deve ser identico ao campo senha."
//                        },
//                        termos: "Para se cadastrar você deve aceitar os termos de contrato."
//                    }
//
//                });
//            });
        </script>
        
        
    </head>
    <body style="background-color: #EBEBEB;">
        
        <!--Caixa de diálogo-->
<!--        <div id="dialog-message" title="CPF Inválido!">
            <p>
                <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
            </p>
            <p>
                Informe um cpf <b>VÁLIDO!</b>
            </p>
        </div>-->
        
        <div id="formularioCadastrar">
        
            <form class="formoid-flat-green" id="formulario" style="background-color:#FFFFFF;font-size:14px;font-family:'Lato', sans-serif;color:#666666;max-width:480px;min-width:150px" method="post"><div class="title"><h2>Cadastro de Usuário</h2></div>
	<div class="element-input"  title="Digite seu nome"><label class="title">Nome<span class="required">*</span></label><input class="large" type="text" name="txtNome" required="required"/></div>
        <div class="element-input"  title="Digite seu CPF"><label class="title">CPF<span class="required">*</span></label><input class="medium" type="text" id="cpf" name="txtCpf" required="required"/></div>
	<div class="element-input"  title="Digite a rua em que você mora"><label class="title">Rua<span class="required">*</span></label><input class="large" type="text" name="txtRua" required="required"/></div>
	<div class="element-number"  title="Digite o número de sua casa"><label class="title">Número<span class="required">*</span></label><input class="small" type="text" min="0" max="10000000" name="txtNumero" required="required" value=""/></div>
	<div class="element-input"  title="Difite o bairro em que você reside"><label class="title">Bairro<span class="required">*</span></label><input class="medium" type="text" name="txtBairro" required="required"/></div>
	<div class="element-input"  title="Digite a cidade em que você reside"><label class="title">Cidade<span class="required">*</span></label><input class="large" type="text" name="txtCidade" required="required"/></div>
	<div class="element-select"  title="Digite o estado em que você reside"><label class="title">Estado<span class="required">*</span></label><div class="small"><span><select name="selEstado" required="required">
        <option value="UF">UF</option><br/>
        <?php
            $endereco = new Endereco(0, '', '', '', '', '', '');
            $vetorEst = $endereco->mostrarEstados();
            for ($i = 0; $i < count($vetorEst); $i++) {
                print '<option value="'.$vetorEst[$i].'">'.$vetorEst[$i].'</option><br/>';
            }
        ?>
		</select><i></i></span></div></div>
        <div class="element-input"  title="Digite o CEP da sua cidade"><label class="title">Cep<span class="required">*</span></label><input class="medium" id="cep" type="text" name="txtCep" required="required"/></div>
        <div class="element-input"  title="Digite seu telefone"><label class="title">Telefone<span class="required">*</span></label><input class="medium" type="text" id="telefone" name="txtTelefone" required="required"/></div>
        <div class="element-input"  title="Digite seu login"><label class="title">Login<span class="required">*</span></label><input class="medium" type="text" name="txtLogin" required="required"/></div>
        <div class="element-password"  title="Digite sua senha"><label class="title">Senha<span class="required">*</span></label><input class="medium" type="password" id="senha" name="senha" value="" required="required"/></div>
        <div class="element-password"  title="Confirme a sua senha"><label class="title">Confirmar Senha<span class="required">*</span></label><input class="medium" type="password" id="confirmarSenha" name="confirmarSenha" value="" required="required"/></div>
	<div class="element-email"  title="Digite seu email para que possamos melhor entrar em contato"><label class="title">Email</label><input class="large" type="email" name="email" value="" /></div>

        <div class="submit"><input type="submit" value="Enviar" name="btnEnviar" /></div></form>
            
        </div>
    </body>
</html>
