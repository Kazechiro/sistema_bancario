<?php
session_start();

// Verifique se o usuário está logado, redirecione para a página de login se não estiver
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

include('conexao.php');

// Recupere as informações do usuário a partir da sessão
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
    <header>
        <nav>
            <div class="logo">
                <div class="loader"></div>
                <h1 id="titulo">Sistema Bancário PB</h1>
            </div>
            <div class="bem_vindo_nome">
                <h2>Conta: <?php echo $_SESSION['nome']; ?></h2>
            </div>
            <div class="botao_nav">
                <ul>
                    <a href="principal.php"> <button class="butao">Início</button></a>
                    <a href="transferir.php"> <button class="butao">Transferir</button></a>
                    <a href="extrato.php"> <button class="butao">Extrato</button></a>
                    <a href="perfil.php"> <button id="butao_selecionado">Perfil</button></a>
                    <a href="javascript:void(0);" onclick="confirmarSaida();"> <button class="butao">Sair</button></a>
                </ul>
            </div>
        </nav>
    </header>

    <div class="caixa_dados_perfil">
        <h1>Dados do Perfil</h1>
        <hr><br>
        <div class="informacoes_usuario">
            <p><strong>Nome:</strong> <?php echo $nome; ?></p>
            <p><strong>CPF:</strong> <?php echo $cpf; ?></p>
            <p><strong>CEP:</strong> <?php echo $cep; ?></p>
            <p><strong>Data de Nascimento:</strong> <?php echo $data_nascimento; ?></p>
            <p><strong>Id:</strong> <?php echo $id; ?></p>
            <p><strong>Seu saldo na conta é de:</strong> R$<?php echo $saldo; ?></p>
        </div>
    </div>
    <script type="text/javascript" src="js/funcoes.js"></script>
</body>

</html>