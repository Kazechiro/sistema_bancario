<?php
session_start();


if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

include('conexao.php');
include('protect.php');


$id = $_SESSION['id'];
$nome = $_SESSION['nome'];
$cpf = $_SESSION['cpf'];
$cep = $_SESSION['cep'];
$data_nascimento = $_SESSION['data_nascimento'];
$senha = $_SESSION['senha'];
$saldo = $_SESSION['saldo'];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Seu Perfil</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="caixa_dados_perfil">
        <legend>Dados do Perfil</legend>
        <hr><br>
        <div class="informacoes_usuario">
            <p><strong>Nome:</strong> <?php echo $nome; ?></p>
            <p><strong>CPF:</strong> <?php echo $cpf; ?></p>
            <p><strong>CEP:</strong> <?php echo $cep; ?></p>
            <p><strong>Data de Nascimento:</strong> <?php echo $data_nascimento; ?></p>
            <p><strong>Seu saldo na conta é de:</strong> R$<?php echo $saldo; ?></p>
        </div>
        <div class="botao_perfil">
            <a href="principal.php"><button>Voltar</button></a>
        </div>
    </div>
</body>

</html>