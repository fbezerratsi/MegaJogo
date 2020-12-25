<?php
    session_start();
    include './openboleto-master/autoloader.php';
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Página de Testes</title>
</head>
<body>
    <?php
        use OpenBoleto\Banco\BancoDoBrasil;
        use OpenBoleto\Agente;
        
        $sacado = new Agente($_SESSION['nome'], $_SESSION['cpf'], $_SESSION['rua'] . ' ' . $_SESSION['numero'] . ' ' . $_SESSION['bairro'], $_SESSION['cep'], $_SESSION['cidade'], $_SESSION['estado']);
        $cedente = new Agente('Internet Solution LTDA', '078.895.324-90', 'Rua Manoel Justino de Medeiros', '59350-000', 'Santana do Seridó', 'RN');
        $dataV = new DateTime(date('Y-m-d', strtotime("+5 days")));
        $boleto = new BancoDoBrasil(array(
            // Parâmetros obrigatórios
            'dataVencimento' => $dataV,
            'valor' => 3.00,
            'sequencial' => $_SESSION['idjogador'], // Para gerar o nosso número, colocar id
            'sacado' => $sacado,
            'cedente' => $cedente,
            'agencia' => 1106, // Até 4 dígitos
            'carteira' => 51,
            'conta' => 198056, // Até 8 dígitos
            'convenio' => 1234, // 4, 6 ou 7 dígitos
        ));

        echo $boleto->getOutput();
    ?>
</body>
</html>