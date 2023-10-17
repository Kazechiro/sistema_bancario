<?php
if (!isset($_SESSION)) {
    session_start();
}

// Inclua o arquivo de conexão ao banco de dados
include "conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $novoLimite = isset($_POST['novo_limite']) ? floatval($_POST['novo_limite']) : 0;

    // Atualiza o limite do usuário logado no banco de dados
    $usuario_id = $_SESSION['id']; // Suponha que o ID do usuário logado está na variável de sessão

    $sqlAtualizarLimite = "UPDATE usuarios SET limite = $novoLimite WHERE id = $usuario_id";

    if (mysqli_query($conexao, $sqlAtualizarLimite)) {
        $_SESSION['limite'] = $novoLimite; // Atualiza o limite na variável de sessão
        echo "Limite atualizado com sucesso!";
    } else {
        echo "Erro na atualização do limite. Por favor, tente novamente.";
    }

    // Feche a conexão com o banco de dados
    mysqli_close($conexao);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Limite de Transferência</title>
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
                <h2> Conta: <?php echo $_SESSION['nome']; ?></h2>
            </div>
            <div class="botao_nav">
                <ul>
                    <a href="principal.php"> <button class="butao">Início</button></a>
                    <a href="transferir.php"> <button class="butao">Transferir</button></a>
                    <a href="extrato.php"> <button class="butao">Extrato</button></a>
                    <a href="perfil.php"> <button class="butao">Perfil</button></a>
                    <a href="atualizar_limite.php"> <button class="butao">Atualizar Limite</button></a>
                    <a href="javascript:void(0);" onclick="confirmarSaida();"> <button class="butao">Sair</button></a>
                </ul>
            </div>
        </nav>
    </header>

    <div class="tela_atualizar_limite">
        <h1>Atualizar Limite de Transferência</h1><br>
        <div class="form_atualizar_limite">
            <form action="atualizar_limite.php" method="POST">
                <div class="input_container_limite">
                    <label for="novo_limite">Novo Limite de Transferência:</label>
                    <input type="number" name="novo_limite" step="0.01" class="inputLimite" required><br>
                </div>
                <div class="botao_atualizar_limite">
                    <button type="submit">Atualizar Limite</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
