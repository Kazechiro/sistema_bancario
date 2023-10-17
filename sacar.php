<?php
if (!isset($_SESSION)) {
    session_start();
}

include('protect.php');
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valor_sacado = floatval($_POST['valor_sacado']);

    if ($valor_sacado <= 0) {
        $_SESSION['msg_sacar'] = "<br><p class='error'>O valor do saque deve ser maior que zero.</p>";
        header("Location: principal.php");
        exit();
    } else if ($valor_sacado > $_SESSION['saldo']) {
        $_SESSION['msg_sacar'] = "<br><p class='error'>Saldo insuficiente para realizar o saque.</p>";
        header("Location: principal.php");
        exit();
    }

    $usuario_id = $_SESSION['id'];

    //update no banco
    $sql_code = "UPDATE usuarios SET saldo = saldo - $valor_sacado WHERE id = $usuario_id";
    $resultado = $conexao->query($sql_code);

    // atualizando o valor no principal.php
    if (!$resultado) {
        echo "erro ao atualizar o valor";
    } else {

        $_SESSION['saldo'] -= $valor_sacado;
    }

    //insert nas transações - para ficarem salvas todas as transações
    $sql_code = "INSERT INTO transacoes (tipo_transacao, usuario_id, valor, data_hora)
                 VALUES ('Saque', $usuario_id, $valor_sacado, NOW())";
    $resultado = $conexao->query($sql_code);



    $_SESSION['msg_sacar'] = "<br><p class='success'>Saque de R$ $valor_sacado realizado com sucesso.</p>";
    header("Location: principal.php");
    exit();
}
?>