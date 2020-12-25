<?php
    include './classes/Administrador.php';
?>

<html>
<head>       
   <!--IMPORTAÇÕES NECESSÁRIAS-->
    <link rel="stylesheet" href="css/jquery-ui.css" />
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/jquery-ui.js"></script>         
    
    <script>
        function abrirJanela() {
            $(function() {
                $("#dialog-message").dialog({
                  modal: true,
                  buttons: {
                    Ok: function() {
                      $(this).dialog("close");
                    }
                  }
                });
            });
        }
        
        
    </script>
    
</head>
<body>

    
    <div id="dialog-message" title="CPF Inválido!">
        <p>
            <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
        </p>
        <p>
            Informe um cpf <b>VÁLIDO!</b>
        </p>
    </div>

    <a href="#" onclick="abrirJanela();" style="padding-top:10px;" target="_blank">Clique aqui</a>
    
    <br />
    <br />
    <br />
    <br />
    <?php
    
        $pegar = new Administrador();
        print $pegar->tirarRanking();
        
        
//        $pegar = new Administrador();
//        $data = $pegar->pegarUltimaRodada();
//        $array = explode("-", $data);
//        //print  $array[2] . " | Mes " . $array[1];
//        
//        
//        print "<br />";
//        $dataSub1 = date('Y-m-d', strtotime("-1 days"));
//        $array2 = explode("-", $dataSub1);
//        //$array = explode("-", $dataSoma1);
//        //$dia = $array[0];
//        //$mes = $array[1];
//        //$ano = $array[2];
//        //echo "$dia";
//        print "<br />"; 
//        //print $dataSoma1;
//        
//        if ($array[1] == $array2[1] && $array[2] == $array2[2]) {
//            print "Fechar";
//        } else {
//            print "Felipe";
//        }
        
//        if ((date('d') == '08') && (date('m') == '03')) {
//            print "Fechar";
//        } else {
//            print "continua aberto";
//        }
            
    ?>
    
</body>

</html>