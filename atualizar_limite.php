<?php
if (!isset($_SESSION)) {
    session_start();
}

include "conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $novoLimite = isset($_POST['novo_limite']) ? floatval($_POST['novo_limite']) : 0;

    if ($novoLimite <= 499) {
        $_SESSION['msg_limite'] = "<br><p class='error'>O valor do limite deve ser maior que R$499.</p>";
        header("Location: atualizar_limite.php");
        exit();
    }

    // Atualiza o limite do usuário logado no banco de dados
    $usuario_id = $_SESSION['id']; // Suponha que o ID do usuário logado está na variável de sessão

    $sqlAtualizarLimite = "UPDATE usuarios SET limite = $novoLimite WHERE id = $usuario_id";

    if (mysqli_query($conexao, $sqlAtualizarLimite)) {
        $_SESSION['limite'] = $novoLimite; // Atualiza o limite na variável de sessão
        $_SESSION['msg_limite'] = "<br><p class='success'>Limite atualizado com sucesso!</p>";
        header("Location: transferir.php");
        exit();
    } else {
        echo "Erro na atualização do limite. Por favor, tente novamente.";
    }

    $_SESSION['msg_limite'] = "<br><p class='success'>Limite atualizado com sucesso!</p>";
    header("Location: transferir.php");
    exit();

    // Feche a conexão com o banco de dados
    mysqli_close($conexao);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transferência de Dinheiro</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <div class="coin"></div>
                <h1 id="titulo">FinTechGuard</h1>
            </div>
            <div class="bem_vindo_nome">
                <h2> Conta: <?php echo $_SESSION['nome']; ?></h2>
            </div>
            <div class="botao_nav">
                <ul>
                    <a href="principal.php"> <button class="butao">Início</button></a>
                    <a href="transferir.php"> <button class="butao">Transferir</button></a>
                    <a href="atualizar_limite.php"> <button id="butao_selecionado">Atualizar Limite</button></a>
                    <a href="extrato.php"> <button class="butao">Extrato</button></a>
                    <a href="perfil.php"> <button class="butao">Perfil</button></a>
                    <a href="javascript:void(0);" onclick="confirmarSaida();"> <button class="butao">Sair</button></a>
                </ul>
            </div>
        </nav>
    </header>

    <div class="tela_atualizar_limite">
        <h2>Atualizar Limite de Transferência</h2><br>
        <div class="form_atualizar_limite">
            <form action="atualizar_limite.php" method="POST">
                <div class="input_container_limite">
                    <label for="novo_limite">Novo Limite de Transferência:</label>
                    <input type="number" name="novo_limite" step="0.01" class="inputLimite" required><br>
                </div>
                <div class="botao_atualizar_limite">
                    <button type="submit" value="Atualizar Limite">Atualizar Limite</button>
                </div>
            </form>
        </div>
        <?php
        if (isset($_SESSION['msg_limite'])) {
            echo $_SESSION['msg_limite'];
            unset($_SESSION['msg_limite']);
        }
        ?>
    </div>

    <script type="text/javascript" src="js/funcoes.js"></script>
</body>

</html>


