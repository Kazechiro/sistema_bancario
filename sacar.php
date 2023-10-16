<?php
if (!isset($_SESSION)) {
    session_start();
}
include('protect.php');
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valor_sacado = floatval($_POST['valor_sacado']);

    if ($valor_sacado <= 0) {
        $_SESSION['msg_sacar'] = "<p class='error'>O valor do saque deve ser maior que zero.</p>";
        header("Location: principal.php");
        exit();
    } else if ($valor_sacado > $_SESSION['saldo']) {
        $_SESSION['msg_sacar'] = "<p class='error'>Saldo insuficiente para realizar o saque.</p>";
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



    $_SESSION['msg_deposito'] = "<p class='success'>Depósito de R$ $valor_sacado realizado com sucesso.</p>";
    header("Location: principal.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sacar</title>
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
          <a href="principal.php"> <button id="butao_selecionado">Início</button></a>
          <a href="transferir.php"> <button class="butao">Transferir</button></a>
          <a href="extrato.php"> <button class="butao">Extrato</button></a>
          <a href="perfil.php"> <button class="butao">Perfil</button></a>
          <a href="javascript:void(0);" onclick="confirmarSaida();"> <button class="butao">Sair</button></a>
        </ul>
      </div>
    </nav>
  </header>

    <div class="tela_sacar">
        <h1>Faça o Saque</h1><br>
        <div class="form_sacar">
            <form action="sacar.php" method="POST" id="form_login">
                <div class="input_container_sacar">
                    <input type="number" name="valor_sacado" class="inputSacar" placeholder="" required>
                    <label class="labelSacar">
                        Valor:
                    </label>
                </div>
                <div class="button_sacar">
                    <button type="submit">Sacar</button>
                </div>
            </form>
        </div>
    </div>

    <?php
    if (isset($_SESSION['msg_sacar'])) {
        echo $_SESSION['msg_sacar'];
        unset($_SESSION['msg_sacar']);
    }
    ?>
</body>

</html>