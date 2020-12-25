<!DOCTYPE html>

<?php
    include './checklogado.php';
    include './classes/Jogada.php';
    include './classes/Jogador.php';
    include './classes/Rodada.php';
    //date_default_timezone_set("America/ceara");
    $j1 = new Jogador(0, '', '', '', '', '', 0, '', '', '');
    $idjogador = $j1->buscarId($_SESSION["login"]);
    // Envia uma jogada...
    if (isset($_POST["enviar"])) {
        $rodada = new Rodada(0, '', '', '', '');
        $vetor = $rodada->mostrarRodadaDescricao();
        // Verifica se a data de inscrição em uma rodada está vazia, assim poderá se inscrever na rodada existente...
        if ($vetor["dataFechamentoInscricao"] == "") {
            // verifica se todos os campos são diferentes de vazio
            if ($_POST["selRodada"] != '' && $_POST["n1"] != '' 
                && $_POST["n2"] != '' && $_POST["n3"] != '' && $_POST["n4"] != '' && $_POST["n5"] != '' && $_POST["n6"] != '') {

                $jog = new Jogada(0, $_POST["n1"], $_POST["n2"], $_POST["n3"], $_POST["n4"], $_POST["n5"], $_POST["n6"],
                        '');

                $jog->mostrarOrdenado();
                $jogada2 = new Jogada(0, 0, 0, 0, 0, 0, 0, 0);
                if ($jogada2->inserirJogada($jog->getNum01(), $jog->getNum02(), $jog->getNum03(), $jog->getNum04(), $jog->getNum05(), 
                        $jog->getNum06(), 0, date("Y-m-d"), date("H:m:s"), $idjogador, $_POST["selRodada"])) {
                    //Gerar boleto
                    //Gerou o boleto
                    print '<script>';
                    //print 'window.open("teste.php","_self",true);';
                    print "alert('Jogada Inserida com Sucesso!');";
                    //print "alert('$data');";
                    print '</script>';
                } else {
                    print 'Erro ao Inserir!';
                }
    //            print $idjogador . '<br />';
    //            print $_POST["n1"] . '<br />';
    //            print $_POST["n2"] . '<br />';
    //            print $_POST["n3"] . '<br />';
    //            print $_POST["n4"] . '<br />';
    //            print $_POST["n5"] . '<br />';
    //            print $_POST["n6"] . '<br />';
    //            print $_POST["selRodada"];
            } else {
                print '<script>';
                print "alert('Preencha todos os Campos');";
                print '</script>';
            }
            
        } else {
            print '<script>';
            print "alert('Rodada Fechada');";
            print '</script>';
        }
        
    }
    
    
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/privadajogadorcss.css">
        <title></title>
        <script type="text/javascript">
            
            function limite(e){
                    try{var element = e.target		  }catch(er){};
                    try{var element = event.srcElement  }catch(er){};

                    try{var ev = e.which	   }catch(er){};
                    try{var ev = event.keyCode }catch(er){};

                    if((ev!=0) && (ev!=8) &&(ev!=13))
                            if  (! RegExp(/[0-9]/gi).test(String.fromCharCode(ev))) return false;		

                    if(element.value + String.fromCharCode(ev) > 60) return false;

            }

            window.onload = function(){
                    document.getElementById('n1').onkeypress = limite
                    document.getElementById('n2').onkeypress = limite
                    document.getElementById('n3').onkeypress = limite
                    document.getElementById('n4').onkeypress = limite
                    document.getElementById('n5').onkeypress = limite
                    document.getElementById('n6').onkeypress = limite
            }
            
            function retornaValor() {
                function crescente (index1, index2){
                    return index1 - index2;
                }
                function igual(loteria){
                    var a = loteria;
                    for (var i=0;i<loteria.length;i++){
                        for (var j=0;j<loteria.length;j++){
                            if (loteria[i] == a[j] && (i != j)) {
                                return true;
                            }
                        }
                    }
                }
                var n1 = 1 + Math.round(Math.random() * 59);
                var n2 = 1 + Math.round(Math.random() * 59);
                var n3 = 1 + Math.round(Math.random() * 59);
                var n4 = 1 + Math.round(Math.random() * 59);
                var n5 = 1 + Math.round(Math.random() * 59);
                var n6 = 1 + Math.round(Math.random() * 59);
                var loteria = [n1,n2,n3,n4,n5,n6];
                
                if (igual(loteria)) {
                    retornaValor();
                } else {
                    var num = loteria.sort(crescente);
                    document.getElementById("n1").value = num[0];
                    document.getElementById("n2").value = num[1];
                    document.getElementById("n3").value = num[2];
                    document.getElementById("n4").value = num[3];
                    document.getElementById("n5").value = num[4];
                    document.getElementById("n6").value = num[5];
                }
                
            }
            
            function habilita_a()  
            {  
                document.getElementById("n1").disabled = false; //Habilitando  
                document.getElementById("n2").disabled = false; //Habilitando
                document.getElementById("n3").disabled = false; //Habilitando
                document.getElementById("n4").disabled = false; //Habilitando
                document.getElementById("n5").disabled = false; //Habilitando
                document.getElementById("n6").disabled = false; //Habilitando
                document.getElementById("aleatorio").disabled = false; //Habilitando
            }  
//            function desabilita_a()  
//            {  
//                document.getElementById("a").disabled = true; //Desabilitando  
//            }  
        </script>
    </head>
    <body>
        <div id="corpo">
            
            <div id="cabecalho">
                <div id="saudacao">
                    <?php
                        $idjogador1 = $j1->buscarId($_SESSION["login"]);
                        echo 'Bem Vindo(a), ' . $_SESSION["nome"] . '. ' . '<a href="editarperfil.php?id='.$idjogador1.'">Editar Perfil</a>' . ' | ' . '<a href="logout.php">Sair</a>';
                    ?>
                </div>
            </div>
            <div id="meio">
                <div id="esquerdo">
                    <div id="formulario">
                        <table>
                            <form action="privadajogador.php" method="post">  
                                <tr>
                                    <td colspan="2" id="colBotao">
                                        <input type="submit" name="enviar" value="Enviar Jogada" class="botao" />
                                        <input name="habilitar" type="button" class="botao" value="Habilitar os Campos" id="habilitar" onclick="habilita_a();"  />
                                        <input type="button" name="aleatorio" class="botao" value="Jogar Aleatório" onclick="retornaValor();" disabled="true" id="aleatorio" />
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td>
                                        <label>Número de Sua Preferência</label>
                                    </td>
                                    <td>
                                        <input name="n1" id="n1"  type="text" disabled="true" class="inputText" />  
                                        <input name="n2" id="n2"  type="text" disabled="true" class="inputText" />  
                                        <input name="n3" id="n3"  type="text" disabled="true" class="inputText" />
                                        <input name="n4" id="n4"  type="text" disabled="true" class="inputText" />  
                                        <input name="n5" id="n5"  type="text" disabled="true" class="inputText" />  
                                        <input name="n6" id="n6"  type="text" disabled="true" class="inputText" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Rodada:</label>
                                    </td>
                                    <td>
                                        <?php
                                            $rodada1 = new Rodada('', '', '', '', '');
                                            $rodada1->mostrarRodadas();
                                        ?>
                                        
                                    </td>
                                </tr>  
                                <tr>
                                    
                                </tr>
                                
                            </form>
                        </table>
                    </div>
                </div>
                
            </div>
            <div id="rodape">
                
            </div>
            
        </div>
    </body>
</html>
