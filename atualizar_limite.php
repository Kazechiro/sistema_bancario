<?php
if (!isset($_SESSION)) {
    session_start();
}

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

    $_SESSION['msg_limite'] = "<br><p class='success'>Limite atualizado com sucesso!</p>";
    header("Location: transferir.php");
    exit();

    // Feche a conexão com o banco de dados
    mysqli_close($conexao);
}
?>
