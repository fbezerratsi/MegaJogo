<!doctype html>
<?php
    session_start();
    include 'classes/Jogador.php';
    include 'classes/Endereco.php';
    include 'classes/Jogada.php';
    include './classes/Rodada.php';
    include './classes/Administrador.php';
    
    $fecharRodada = new Administrador();
    // Verifica se tem alguma rodada aberta e se algum jogador acertou os 6 números
    // Se sim a rodada será fechada em um dia;
    if ($fecharRodada->verificaJogadaGanha() == true) {
        $fecharRodada->tirarRanking();
    }
    
    if (isset($_POST["entrar"])) {
        $login = $_POST["login"];
        $senha = $_POST["senha"];
        if ($login == 'admin' && $senha == 'admin') {
            $_SESSION['nomeAdmin'] = 'admin';
            header("Location: privada.php");
            exit(0);
        }
        
        $j1 = new Jogador(0, '', '', '', '', '', '', '', '', '');
        if ($j1->autenticar($login, $senha)) {
            $jog = $j1->buscarNome($login, $senha);
            $_SESSION['idjogador'] = $jog["idjogador"];
            $_SESSION['nome'] = $jog["nome"];
            $_SESSION['cpf'] = $jog["cpf"];
            $_SESSION['rua'] = $jog["rua"];
            $_SESSION['numero'] = $jog["numero"];
            $_SESSION['bairro'] = $jog["bairro"];
            $_SESSION['cidade'] = $jog["cidade"];
            $_SESSION['estado'] = $jog["estado"];
            $_SESSION['cep'] = $jog["cep"];
            $_SESSION['ddd'] = $jog["ddd"];
            $_SESSION['telefone'] = $jog["telefone"];
            $_SESSION["login"] = $login;
            header("Location: privadajogador.php");
            exit(0);
        } else {
            echo '<script>';
            echo "alert('Login ou Senha Inválidos');";
            echo '</script>';
        }
    } else {
        echo '<script>';
        echo "//alert('Preencha todos os campos');";
        echo '</script>';
    }
    
?>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Mega Jogo ONLINE"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <title>Mega Jogo ONLINE</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.css">
        <link rel="stylesheet" href="bootstrap/css/estilo.css">
        <link rel="shortcut icon" href="img/favicon.ico">

        <script type="text/javascript">
            
        </script>

    </head>
    <body>
        <!--MENU-->
        <nav class="navbar navbar-fixed-top ">
            <div class="navbar-inner">
                <div class="container">
                    <!-- .btn-navbar esta classe é usada como alternador para o conteudo colapsável-->
                    <button class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!--formulario acesso-->
                    <div>
                        <div id="formulario">
                            <form action="index.php" method="POST" class="form-inline navbar-form pull-right">

                                <div class="controls input-prepend .controls-row">
                                    <span class="add-on">
                                        <i class="icon-user"></i>
                                    </span>


                                    <input type="text" class="span2 input-small" name="login" placeholder="Usuário">
                                </div>
                                <div class="controls input-prepend .controls-row">

                                    <span class="add-on"><i class="icon-lock"></i></span>
                                    <input type="password" class="span2 input-small" name="senha" placeholder="Senha">

                                    <input type="submit" value="Entrar" name="entrar" class="btn " />
                                    <!--<button class="btn btn-inverse" name="cadastrar">Entrar</button>-->
                                </div>


                            </form>
                        </div>
                        <!-- FIM DO FORMULARIO -->

                        <!--INICIO DO MENU FIXO-->
                        <a href="#" class="brand">Mega Jogo Online</a>
                        <div class="nav-collapse">
                            <ul class="nav">
                                <li class="active"><a href="">Ínicio</a></li>
                                <li><a href="">O Jogo</a></li>
                                <li><a href="">Ranking</a></li>
                                <li class="dropdown"><a href="rodadasanteriores.php" class="dropdown-toggle" data-toggle="dropdown">Rodadas Anteriores</a></li>
                                <li><a href="cadastroJogador.php">Cadastre-se</a></li>

                            </ul>

                        </div>
                        <!--FIM DO MENU FIXO-->

                    </div>
                </div>
        </nav>

    </div>
    <!--BANNER-->
    <header class="jumbotron subhead">
        <div class="container">
            <h1>Mega Jogo ONLINE</h1>
            <p>Mude de vida ainda hoje</p>
        </div>
    </header>
    <!--FIM BANNER-->

    <!--INICIO BLOCOS-->
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span6 bloco1">

                <div id="myCarousel" class="carousel slide">
                    <!-- Mostra Vencedores -->
                    <h2>Rodadas Anteriores</h2>
                    <?php
                        $exibirRodadas = new Administrador();
                        $exibirRodadas->rodadasAnteriores();
                    ?>
                </div>
                
            </div>
            <!--BLOCO 2-->
            <div class="span4 offset2 bloco2">
                <p>Bloco 02</p>
            </div>
        </div>
    </div>


    <footer class="footer">
      <div class="container">
        <p class="pull-right"><a href="#">Voltar ao topo</a></p>
        <p>Desenhado e construído por <a href="">Internet Solutions</a>. </p>
        <p>Este projeto é uma versão do Mega Jogo Online Mantido por Alunos do IFRN - Campus Currais Novos.</p>
        <p>Código licenciado sob <a href="http://www.apache.org/licenses/LICENSE-2.0" target="_blank">Apache License v2.0</a>, documentação sob <a href="http://creativecommons.org/licenses/by/3.0/">CC 3.0</a>.</p>
        <p><a href="http://glyphicons.com">Glyphicons grátis</a> licenciado sob <a href="http://creativecommons.org/licenses/by/3.0/">CC 3.0</a>.</p>
        <ul class="footer-links">
          <li><a href="http://blog.getbootstrap.com">Blog</a></li>
          <li class="muted">·</li>
          <li><a href="https://github.com/twitter/bootstrap/issues?state=open">Issues</a></li>
          <li class="muted">·</li>
          <li><a href="https://github.com/twitter/bootstrap/wiki">Roadmap e changelog</a></li>
        </ul>
      </div>
    </footer>
    <script type="text/javascript" src="js/jquery-2.1.0.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="js/jquery.cycle.all.js"></script>
    <script type="text/javascript" src="js/bootstrap-carousel.js"></script>
</body>
</html>