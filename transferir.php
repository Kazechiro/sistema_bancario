<?php
if (!isset($_SESSION)) {
    session_start();
}

// Inclua o arquivo de conexão ao banco de dados
include "conexao.php";

// Obtém o limite de transferência do usuário logado
$limiteTransferencia = isset($_SESSION['limite']) ? $_SESSION['limite'] : 500;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $valorTransferencia = isset($_POST['valor']) ? floatval($_POST['valor']) : 0;

    if ($valorTransferencia > $limiteTransferencia) {
        echo "A transferência não pode exceder R$ " . $limiteTransferencia . ".";
    } else {
        // Prossiga com a lógica de transferência

        // Obtém os IDs do remetente e destinatário da transferência
        $remetente_id = $_SESSION['id']; // Suponha que o ID do remetente está na variável de sessão
        $destinatario_id = $_POST['destinatario_id']; // Suponha que o ID do destinatário foi enviado via formulário

        // Atualiza o saldo do remetente (subtrai o valor da transferência)
        $sqlRemetente = "UPDATE usuarios SET saldo = saldo - $valorTransferencia WHERE id = $remetente_id";

        // Atualiza o saldo do destinatário (soma o valor da transferência)
        $sqlDestinatario = "UPDATE usuarios SET saldo = saldo + $valorTransferencia WHERE id = $destinatario_id";

        // Execute as consultas SQL para atualizar os saldos no banco de dados
        if (mysqli_query($conexao, $sqlRemetente) && mysqli_query($conexao, $sqlDestinatario)) {
            // Atualize a variável de sessão com o novo saldo
            $_SESSION['saldo'] -= $valorTransferencia;

            // Exiba a mensagem de sucesso
            echo "Transferência realizada com sucesso!";
        } else {
            echo "Erro na transferência. Por favor, tente novamente.";
        }

        // Feche a conexão com o banco de dados
        mysqli_close($conexao);
    }
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

    <div class="tela_transferir">
        <h1>Transferência de Dinheiro</h1><br>
        <div class="form_transferir">
            <form action="transferir.php" method="POST">
                <div class="input_container_transferir">
                    <label for="destinatario_id">ID do Destinatário:</label>
                    <input type="text" name="destinatario_id" class="inputTransferir" required><br>
                </div>
                <div class="input_container_transferir">
                    <label for="valor">Valor a Transferir (limite de R$ <?php echo $limiteTransferencia; ?>):</label>
                    <input type="number" name="valor" step="0.01" class="inputTransferir" required><br>
                </div>
                <div class="botao_transferir">
                    <button type="submit">Realizar Transferência</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Adicione código HTML para exibir informações de saldo e transferências recentes aqui -->
</body>

</html>
