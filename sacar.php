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
      header("Location: sacar.php");
      exit();
  } else if ($valor_sacado > $_SESSION['saldo']) {
    $_SESSION['msg_sacar'] = "<p class='error'>Saldo insuficiente para realizar o saque.</p>";
      header("Location: sacar.php");
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
  <title>Document</title>
</head>
<body>
<form action="" method="POST" id="form_login">
           
            <h1>
                Faça o deposito
            </h1>
            <div class="input-container">
            <label class="labelLogin">
                Valor:
                </label>
                <input type="number" name="valor_sacado" class="input" required>
            </div>

            <div>
                <button type="submit" class="submit-button">
                    Sacar
                </button>
            </div>

            <div>
                <button type="submit" class="submit-button" >
                    <a href="principal.php">Voltar</a>
                </button>
            </div>

        </form>
        <?php
if (isset($_SESSION['msg_sacar'])) {
    echo $_SESSION['msg_sacar'];
    unset($_SESSION['msg_sacar']); 
}
?>
</body>
</html>