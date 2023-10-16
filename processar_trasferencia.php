<?php
include('conexao.php');
include('protect.php');

$remetente_id = $_SESSION['id'];
$destinatario_id = $_POST['destinatario_id'];
$valor = floatval($_POST['valor']);

try {

    $conn->beginTransaction();


    $sql_saldo_remetente = "SELECT saldo FROM usuarios WHERE id = :remetente_id";
    $stmt_saldo_remetente = $conn->prepare($sql_saldo_remetente);
    $stmt_saldo_remetente->bindParam(':remetente_id', $remetente_id);
    $stmt_saldo_remetente->execute();

    $saldo_remetente = $stmt_saldo_remetente->fetchColumn();

    if ($saldo_remetente < $valor) {
        echo "Saldo insuficiente para a transferência.";
        header('Location:transferir.php');
    } else {



    // Atualizar o saldo do usuário que tá fazendo a tranferência
    $sql_atualizar_remetente = "UPDATE usuarios SET saldo = saldo - :valor WHERE id = :remetente_id";
    $stmt_atualizar_remetente = $conn->prepare($sql_atualizar_remetente);
    $stmt_atualizar_remetente->bindParam(':valor', $valor);
    $stmt_atualizar_remetente->bindParam(':remetente_id', $remetente_id);
    $stmt_atualizar_remetente->execute();

    // Atualizar o saldo do usuário que vai receber
    $sql_atualizar_destinatario = "UPDATE usuarios SET saldo = saldo + :valor WHERE id = :destinatario_id";
    $stmt_atualizar_destinatario = $conn->prepare($sql_atualizar_destinatario);
    $stmt_atualizar_destinatario->bindParam(':valor', $valor);
    $stmt_atualizar_destinatario->bindParam(':destinatario_id', $destinatario_id);
    $stmt_atualizar_destinatario->execute();

    // Registrar a transferência no extrato do remetente
    $sql_registrar_remetente = "INSERT INTO transacoes (tipo_transacao, usuario_id, valor, data_hora)
                              VALUES ('Transferência', :remetente_id, :valor, NOW())";
    $stmt_registrar_remetente = $conn->prepare($sql_registrar_remetente);
    $stmt_registrar_remetente->bindParam(':remetente_id', $remetente_id);
    $stmt_registrar_remetente->bindParam(':valor', $valor);
    $stmt_registrar_remetente->execute();

    // Registrar a transferência no extrato do destinatário
    $sql_registrar_destinatario = "INSERT INTO transacoes (tipo_transacao, usuario_id, valor, data_hora)
                                 VALUES ('Depósito', :destinatario_id, :valor, NOW())";
    $stmt_registrar_destinatario = $conn->prepare($sql_registrar_destinatario);
    $stmt_registrar_destinatario->bindParam(':destinatario_id', $destinatario_id);
    $stmt_registrar_destinatario->bindParam(':valor', $valor);
    $stmt_registrar_destinatario->execute();

    //Atualizar o valor antes de mandar de volta para o principal
    $_SESSION['saldo'] -= $valor;
      // Confirmar a transação
    $conn->commit();

    header('Location:Principal.php');
}
} catch (Exception $e) {
    // Reverter a transação em caso de erro
    $conn->rollback();
    echo "Erro ao realizar a transferência: " . $e->getMessage();

}
?>