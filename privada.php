<!DOCTYPE html>
<?php
    
    include './classes/Jogada.php';
    include './classes/Jogador.php';
    include './classes/Rodada.php';
    include './classes/Premio.php';
    include './checklogadoAdmin.php';
    include './classes/Administrador.php';
    
    if (isset($_GET["acao"]) && $_GET["acao"] == '1') {
        $fecharInscricao = new Administrador();
        $fecharInscricao->fecharPeriodoInscricao();
    }
    if (isset($_GET["acao"]) && $_GET["acao"] == '2') {
        $fecharInscricao = new Administrador();
        $fecharInscricao->fecharPeriodoRodada();
    }
    
    if (isset($_POST["btnEnviarRodada"])) {
        if ($_POST["txtNomePremio"] != "" && $_POST["txtDescricaoPremio"] != "") {
            $rodada = new Rodada(0, "", "", "", "");
            $datatermino = $rodada->ChecarRodadaFechada();
            if ($datatermino != 0) {
                // exibe a mensagem se a rodada estiver aberta...
                print '<script>';
                print 'alert("Tem rodada alguma rodada aberta, feche a rodada para cadastrar uma nova!")';
                print '</script>';
            } else {
                // Insere uma rodada ou um prêmio se não tiver nenhuma aberta...
                $nome = $_POST["txtNomePremio"];
                $descricao = $_POST["txtDescricaoPremio"];
                $data = date("Y-m-d");
                $hora = date("H:m:s");
                $rodada2 = new Rodada(0, $data, $hora, "", "");

                if ($rodada2->inserirRodada()) {
                    if ($rodada2->buscarIdRodada()) {
                        $idrodada = $rodada2->buscarIdRodada();
                        $rodada3 = new Rodada($idrodada, $data, $hora, '', '');
                        $premio = new Premio(0, $nome, $descricao, $rodada3);
                        if ($premio->inserirPremio()) {
                            print '<script>';
                            print 'alert("Rodada e Prêmio Inserido com Sucesso!")';
                            print '</script>';
                        }
                    } else {
                        print '<script>';
                        print 'alert("Todas as rodadas fechadas")';
                        print '</script>';
                    }

                }
            }
        } else {
            print '<script>';
            print 'alert("Preencha Todos os campos!")';
            print '</script>';
        }
    }
    
    if (isset($_POST["enviar"])) {
        // Verifica se tem jogador vecendor
        $verJogada = new Administrador();
        if ($verJogada->verificaJogadaGanha()) {
            print '<script>';
            print 'alert("Essa jogada já tem um vencedor!")';
            print '</script>';
            
        } else {
            
            if ($_POST["selRodada"] != '' && $_POST["n1"] != "" && $_POST["n2"] != "" && $_POST["n3"] != "" && $_POST["n4"] != "" && $_POST["n5"] != "" && $_POST["n6"] != "") {
                $jogada1 = new Jogada(0, 0, 0, 0, 0, 0, 0, '');
                $jogada1->inserirPontuacao($_POST["n1"], $_POST["selRodada"]);
                $jogada1->inserirPontuacao($_POST["n2"], $_POST["selRodada"]);
                $jogada1->inserirPontuacao($_POST["n3"], $_POST["selRodada"]);
                $jogada1->inserirPontuacao($_POST["n4"], $_POST["selRodada"]);
                $jogada1->inserirPontuacao($_POST["n5"], $_POST["selRodada"]);
                $jogada1->inserirPontuacao($_POST["n6"], $_POST["selRodada"]);

                $jog = new Jogada(0, $_POST["n1"], $_POST["n2"], $_POST["n3"], $_POST["n4"], $_POST["n5"], $_POST["n6"],
                        '');

                $jog->mostrarOrdenado();

                if ($jogada1->guardarNumerosMega($jog->getNum01(), $jog->getNum02(), $jog->getNum03(), $jog->getNum04(), $jog->getNum05()
                        , $jog->getNum06(), date('Y-m-d'), date('H:m:s'), $_POST["selRodada"])) {
                    print '<script>';
                    print "alert('Inserido com Sucesso!');";
                    print '</script>';
                }

                $_POST["n1"] = "";
                $_POST["n2"] = "";
                $_POST["n3"] = "";
                $_POST["n4"] = "";
                $_POST["n5"] = "";
                $_POST["n6"] = "";

            } else {
                print '<script>';
                print "alert('Campos Vazios');";
                print '</script>';

            }
            
        }
        
    }
    
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/privadacss.css">
        <link rel="stylesheet" href="css/formoid-flat-green.css" type="text/css" />
        <title></title>
        <script src="js/jquery-1.10.2.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        
        <script type="text/javascript">

            function abrir(URL) {
 
                var width = 500;
                var height = 500;

                var left = 400;
                var top = 90;

                window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', left='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');

            }
            
            $(document).ready(function(){
                $('#abrirCadastroRodada').click(function(event){
                    event.preventDefault();
                    $("#cadastroRodada").toggle(1000);
                    $("#rodadaExistente").hide(1000);
                });
                $('#abrirRodadaExistente').click(function(event){
                    event.preventDefault();
                    $("#rodadaExistente").toggle(1000);
                    $("#cadastroRodada").hide(1000);
                });
            });
            //função para limitar os campos para que não passe de 60
            function limite(e){
                    try{var element = e.target		  }catch(er){};
                    try{var element = event.srcElement  }catch(er){};

                    try{var ev = e.which	   }catch(er){};
                    try{var ev = event.keyCode }catch(er){};

                    if((ev!=0) && (ev!=8) &&(ev!=13))
                            if  (! RegExp(/[0-9]/gi).test(String.fromCharCode(ev))) return false;		

                    if(element.value + String.fromCharCode(ev) > 60) return false;

            }
            //função para limitar os campos para que não passe de 60
            window.onload = function(){
                    document.getElementById('n1').onkeypress = limite
                    document.getElementById('n2').onkeypress = limite
                    document.getElementById('n3').onkeypress = limite
                    document.getElementById('n4').onkeypress = limite
                    document.getElementById('n5').onkeypress = limite
                    document.getElementById('n6').onkeypress = limite
            }
        </script>
        
        
    </head>
    <body>
        <div id="corpo">
            <div id="cabecalho">
                <div id="saudacao">
                    <?php
                        echo "Olá, " . $_SESSION["nomeAdmin"];
                    ?>
                </div>
            </div>
            <!-- Div do meio da página que nela tem a div: lado esquerdo e lado direito -->
            <div id="meio">
                <div id="nomeDaRodada">
                    <?php 
                        $rodada = new Rodada(0, '', '', '', '');
                        $vetor = $rodada->mostrarRodadaDescricao();
                    ?>
                    <h1><?php echo "Rodada Aberta " . $vetor["id"] . ": " . $vetor["nome"] . " " . $vetor["descricao"]; ?>
                    </h1><a href="privada.php?acao=1">Fechar Período de Inscrição</a> 
                    | <a href="privada.php?acao=2">Concluir Rodada</a> | <a href="javascript:abrir('jogadores.php');">Exibir Jogador</a>
                    
                </div>
                <div id="direito">
                    
                    <!-- Div para o cadastro de Rodada/Premio -->
                    <div id="formCadastroPremio">
                        <form class="formoid-flat-green" style="background-color:#FFFFFF;font-size:14px;font-family:'Lato', sans-serif;color:#666666;max-width:480px;min-width:150px" method="post"><div class="title"><h2>Cadastrar Prêmio/Rodada</h2></div>
                            <div class="element-input"  title="Digite o nome do prêmio"><label class="title">Nome do prêmio<span class="required">*</span></label><input class="large" type="text" name="txtNomePremio" required="required"/></div>
                            <div class="element-textarea"  title="Digite a descriçao do prêmio"><label class="title">Descriçao do Prêmio<span class="required">*</span></label><textarea class="small" name="txtDescricaoPremio" cols="20" rows="5" required="required"></textarea></div>
                            <div class="submit"><input type="submit" name="btnEnviarRodada" value="Cadastrar"/></div>
                        </form>    
                    </div>
                    
                    <div id="formMega">
                        <table>
                            <form action="privada.php"  method="post">
                                <tr>
                                    <td colspan="2">
                                        <h2>Insira os Números da Mega Sena</h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Números da Mega Sena:</label></td>
                                    <td>
                                        <input type="text" maxlength="2" name="n1" id="n1" class="numeros" />
                                        <input type="text" maxlength="2" name="n2" id="n2" class="numeros" />
                                        <input type="text" maxlength="2" name="n3" id="n3" class="numeros" />
                                        <input type="text" maxlength="2" name="n4" id="n4" class="numeros" />
                                        <input type="text" maxlength="2" name="n5" id="n5" class="numeros" />
                                        <input type="text" maxlength="2" name="n6" id="n6" class="numeros" />

                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Rodadas</label></td>
                                    <td>
                                        <?php   
                                            $rodada1 = new Rodada('', '', '', '', '');
                                            $rodada1->mostrarRodadas();
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <input type="submit" name="enviar" value="Enviar Números" class="botao" />
                                    </td>
                                </tr>

                            </form>
                        </table>
                    </div>
                    
                </div>
                <div id="esquerdo">
                    <div id="lista_jogadores">
                        <h2>Lista de Todos os Jogadores</h2>
                        <?php
                            $jogador3 = new Jogador(0, '', '', '', '', '', '', '', '', '');
                            $jogador3->listarJogadores();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
