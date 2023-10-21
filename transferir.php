<?php
if (!isset($_SESSION)) {
    session_start();
}

include "conexao.php";

$remetente_id = $_SESSION['id'];
$limiteTransferencia = isset($_SESSION['limite']) ? $_SESSION['limite'] : 500;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['destinatario_id']) && isset($_POST['valor'])) {
        $destinatario_id = $_POST['destinatario_id'];
        $valorTransferencia = floatval($_POST['valor']);

        if ($valor_deposito <= 0) {
            $_SESSION['msg_transferencia'] = "<br><p class='error'>O valor da transferência deve ser maior que zero.</p>";
            header("Location: transferir.php");
            exit();
        }

        // Verifique se o destinatário com o ID fornecido existe no banco de dados
        $sql_verificar_destinatario = "SELECT id, nome FROM usuarios WHERE id = :destinatario_id";
        $stmt_verificacao = $conn->prepare($sql_verificar_destinatario);
        $stmt_verificacao->bindParam(':destinatario_id', $destinatario_id);
        $stmt_verificacao->execute();

        $destinatario = $stmt_verificacao->fetch(PDO::FETCH_ASSOC);

        if ($stmt_verificacao->rowCount() == 0) {
            $_SESSION['msg_transferencia'] = "<br><p class='error'>Destinatário não encontrado. A transferência não pode ser realizada.</p>";
            header("Location: transferir.php");
            exit();
        } elseif ($valorTransferencia > $limiteTransferencia) {
            $_SESSION['msg_transferencia'] = "<br><p class='error'>A transferência não pode exceder R$ $limiteTransferencia.</p>";
            header("Location: transferir.php");
            exit();
        } elseif ($valorTransferencia > $_SESSION['saldo']) {
            $_SESSION['msg_transferencia'] = "<br><p class='error'>A transferência não pode exceder seu saldo.</p>";
            header("Location: transferir.php");
            exit();
        } else {
            try {
                $conn->beginTransaction();

                // Atualiza o saldo do remetente (subtrai o valor da transferência)
                $sqlRemetente = "UPDATE usuarios SET saldo = saldo - :valorTransferencia WHERE id = :remetente_id";
                $stmtRemetente = $conn->prepare($sqlRemetente);
                $stmtRemetente->bindParam(':valorTransferencia', $valorTransferencia);
                $stmtRemetente->bindParam(':remetente_id', $remetente_id);
                $stmtRemetente->execute();

                // Atualiza o saldo do destinatário (soma o valor da transferência)
                $sqlDestinatario = "UPDATE usuarios SET saldo = saldo + :valorTransferencia WHERE id = :destinatario_id";
                $stmtDestinatario = $conn->prepare($sqlDestinatario);
                $stmtDestinatario->bindParam(':valorTransferencia', $valorTransferencia);
                $stmtDestinatario->bindParam(':destinatario_id', $destinatario_id);
                $stmtDestinatario->execute();

                // Registrar a transferência no extrato do remetente
                $sql_registrar_remetente = "INSERT INTO transacoes (tipo_transacao, usuario_id, usuario_destinatario, valor, data_hora)
                                          VALUES ('Transferência enviada', :remetente_id, :destinatario_id, :valorTransferencia, NOW())";
                $stmt_registrar_remetente = $conn->prepare($sql_registrar_remetente);
                $stmt_registrar_remetente->bindParam(':remetente_id', $remetente_id);
                $stmt_registrar_remetente->bindParam(':destinatario_id', $destinatario_id);
                $stmt_registrar_remetente->bindParam(':valorTransferencia', $valorTransferencia);
                $stmt_registrar_remetente->execute();

                // Registrar a transferência no extrato do destinatário
                $sql_registrar_destinatario = "INSERT INTO transacoes (tipo_transacao, usuario_id, usuario_destinatario, valor, data_hora)
                                             VALUES ('Transferência recebida', :destinatario_id, :remetente_id, :valorTransferencia, NOW())";
                $stmt_registrar_destinatario = $conn->prepare($sql_registrar_destinatario);
                $stmt_registrar_destinatario->bindParam(':destinatario_id', $destinatario_id);
                $stmt_registrar_destinatario->bindParam(':remetente_id', $remetente_id);
                $stmt_registrar_destinatario->bindParam(':valorTransferencia', $valorTransferencia);
                $stmt_registrar_destinatario->execute();

                // Atualize o valor antes de mandar de volta para a página de transferência
                $_SESSION['saldo'] -= $valorTransferencia;

                // Confirmar a transação
                $conn->commit();

                $_SESSION['msg_transferencia'] = "<br><p class='success'>Transferência realizada com sucesso!</p>";
                header("Location: transferir.php");
                exit();
            } catch (Exception $e) {
                // Reverter a transação em caso de erro
                $conn->rollBack();
                $_SESSION['msg_transferencia'] = "<p class='error'>Erro ao realizar a transferência: " . $e->getMessage() . "</p>";
                header("Location: transferir.php");
                exit();
            }
        }
    } else {
        $_SESSION['msg_transferencia'] = "<p class='error'>Por favor, preencha todos os campos.</p>";
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
                    <a href="atualizar_limite.php"> <button class="butao">Atualizar Limite</button></a>
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
                    <?php
                if (isset($_SESSION['msg_limite'])) {
                    echo $_SESSION['msg_limite'];
                    unset($_SESSION['msg_limite']);
                }
                ?>
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

    <script type="text/javascript" src="js/funcoes.js"></script>
</body>

</html>