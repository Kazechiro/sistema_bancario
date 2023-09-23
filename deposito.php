<?php
if (!isset($_SESSION)) {
    session_start();
}

include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valor_deposito = floatval($_POST['valor_deposito']);

    if ($valor_deposito <= 0) {
        $_SESSION['msg_deposito'] = "<p class='error'>O valor do depósito deve ser maior que zero.</p>";
        header("Location: deposito.php");
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

    //insert nas transações - para ficarem salvas todas as transações
    $sql_code = "INSERT INTO transacoes (tipo_transacao, usuario_id, valor, data_hora)
                 VALUES ('D', $usuario_id, $valor_deposito, NOW())";
    $resultado = $conexao->query($sql_code);

   

    $_SESSION['msg_deposito'] = "<p class='success'>Depósito de R$ $valor_deposito realizado com sucesso.</p>";
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
                <input type="number" name="valor_deposito" class="input" required>
            </div>

            <div>
                <button type="submit" class="submit-button">
                    Depositar
                </button>
            </div>


            <div>
                <button type="submit" class="submit-button" >
                    <a href="principal.php">Voltar</a>
                </button>
            </div>
            
        </form>
</body>
</html>