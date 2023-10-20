<?php
if (!isset($_SESSION)) {
    session_start();
}

include "conexao.php";

$limiteTransferencia = isset($_SESSION['limite']) ? $_SESSION['limite'] : 500;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['destinatario_id']) && !empty($_POST['destinatario_id'])) {
        $valorTransferencia = isset($_POST['valor']) ? floatval($_POST['valor']) : 0;
        $destinatario_id = $_POST['destinatario_id'];

        // Verifique se o destinatário com o ID fornecido existe no banco de dados
        $sql_verificar_destinatario = "SELECT id FROM usuarios WHERE id = $destinatario_id";
        $resultado_verificacao = mysqli_query($conexao, $sql_verificar_destinatario);

        if (mysqli_num_rows($resultado_verificacao) == 0) {
            $_SESSION['msg_transferencia'] = "<br><p class='error'>Destinatário não encontrado. A transferência não pode ser realizada.</p>";
            header("Location: transferir.php");
            exit();
        } elseif ($valorTransferencia > $limiteTransferencia) {
            $_SESSION['msg_transferencia'] = "<br><p class='error'>A transferência não pode exceder R$ $limiteTransferencia </p>";
            header("Location: transferir.php");
            exit();
        } elseif ($valorTransferencia > $_SESSION['saldo']) {
            $_SESSION['msg_transferencia'] = "<br><p class='error'>A transferência não pode exceder R$ {$_SESSION['saldo']}</p>";
            header("Location: transferir.php");
            exit();
        } else {

            // Obtém os IDs do remetente e destinatário da transferência
            $remetente_id = $_SESSION['id'];

            // Atualiza o saldo do remetente (subtrai o valor da transferência)
            $sqlRemetente = "UPDATE usuarios SET saldo = saldo - $valorTransferencia WHERE id = $remetente_id";

            // Atualiza o saldo do destinatário (soma o valor da transferência)
            $sqlDestinatario = "UPDATE usuarios SET saldo = saldo + $valorTransferencia WHERE id = $destinatario_id";

            // Execute as consultas SQL para atualizar os saldos no banco de dados
            if (mysqli_query($conexao, $sqlRemetente) && mysqli_query($conexao, $sqlDestinatario)) {
                // Atualize a variável de sessão com o novo saldo
                $_SESSION['saldo'] -= $valorTransferencia;

                // Exiba a mensagem de sucesso
                $_SESSION['msg_transferencia'] = "<br><p class='success'>Transferência realizada com sucesso!</p>";
                header("Location: transferir.php");
                exit();
            } else {
                $_SESSION['msg_transferencia'] = "<p class='error'>Erro na transferência. Por favor, tente novamente.</p>";
                header("Location: transferir.php");
                exit();
            }

            // Feche a conexão com o banco de dados
            mysqli_close($conexao);
        }
    } else {
        $_SESSION['msg_transferencia'] = "<p class='error'>ID do destinatário não foi fornecido. A transferência não pode ser realizada.</p>";
        header("Location: transferir.php");
        exit();
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
                <div class="coin"></div>
                <h1 id="titulo">FinTechGuard</h1>
            </div>
            <div class="bem_vindo_nome">
                <h2> Conta: <?php echo $_SESSION['nome']; ?></h2>
            </div>
            <div class="botao_nav">
                <ul>
                    <a href="principal.php"> <button class="butao">Início</button></a>
                    <a href="transferir.php"> <button id="butao_selecionado">Transferir</button></a>
                    <a href="extrato.php"> <button class="butao">Extrato</button></a>
                    <a href="perfil.php"> <button class="butao">Perfil</button></a>
                    <a href="javascript:void(0);" onclick="confirmarSaida();"> <button class="butao">Sair</button></a>
                </ul>
            </div>
        </nav>
    </header>

    <div class="tela_transferir">
        <h2>Transferência de Dinheiro</h2><br>
        <div class="form_transferir">
            <form action="transferir.php" method="POST">
                <div class="input_container_transferir">
                    <label for="destinatario_id">ID do Destinatário:</label>
                    <input type="text" name="destinatario_id" class="inputTransferir" required>
                </div>
                <div class="input_container_transferir">
                    <label for="valor">Valor a Transferir (limite de R$ <?php echo $limiteTransferencia; ?>):</label>
                    <input type="number" name="valor" step="0.01" class="inputTransferir" required><br>
                </div>
                <div class="botao_transferir">
                    <button type="submit" value="Realizar Transferência">Realizar Transferência</button>
                </div>
            </form>
        </div>
        <?php
        if (isset($_SESSION['msg_transferencia'])) {
            echo $_SESSION['msg_transferencia'];
            unset($_SESSION['msg_transferencia']);
        }
        ?>
    </div>

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