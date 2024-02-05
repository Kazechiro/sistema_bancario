<?php
if (!isset($_SESSION)) {
    session_start();
}

include('protect.php');
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valor_deposito = floatval($_POST['valor_deposito']);

    if ($valor_deposito <= 0) {
        $_SESSION['msg_deposito'] = "<br><p class='error'>O valor do depósito deve ser maior que zero.</p>";
        header("Location: principal.php");
        exit();
    }

    $usuario_id = $_SESSION['id'];

    //update no banco
    $sql_code = "UPDATE usuarios SET saldo = saldo + $valor_deposito WHERE id = $usuario_id";
    $resultado = $conexao->query($sql_code);

    // atualizando o valor no principal.php
    if (!$resultado) {
        echo "erro ao atualizar o valor";
    } else {

        $_SESSION['saldo'] += $valor_deposito;
    }

    $sql_code = "INSERT INTO transacoes (tipo_transacao, usuario_id, valor, data_hora)
                 VALUES ('Depósito', $usuario_id, $valor_deposito, NOW())";
    $resultado = $conexao->query($sql_code);

    
    $_SESSION['msg_deposito'] = "<p class='success'>Depósito de R$ $valor_deposito realizado com sucesso.</p>";
    header("Location: principal.php");
    exit();
}
?>