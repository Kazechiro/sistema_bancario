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
                 VALUES ('Depósito', $usuario_id, $valor_deposito, NOW())";
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
    <title>Depositar</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header>
    <nav>
      <div class="logo">
        <div class="loader"></div>
        <h1 id="titulo">Sistema Báncario</h1>
      </div>

      <div class="botao_nav">
        <ul>
        <a href="principal.php"> <button class="butao">Início</button></a>
          <a href="deposito.php"> <button class="butao">Depositar</button></a>
          <a href="sacar.php"> <button class="butao">Sacar</button></a>
          <a href="extrato.php"> <button class="butao">Extrato</button></a>
          <a href="perfil.php"> <button class="butao">Perfil</button></a>
          <a href="javascript:void(0);" onclick="confirmarSaida();"> <button class="butao">Sair</button></a>
        </ul>
      </div>
    </nav>
  </header>
  
    <div class="tela_depositar">
        <h1>Faça o Deposito</h1><br>
        <div class="form_depositar">
            <form action="deposito.php" method="POST">
                <div class="input_container_depositar">
                    <input type="number" name="valor_deposito" id="valor" class="inputDepositar" placeholder="" required>
                    <label class="labelDepositar"  for="valor">
                        Valor:
                    </label> 
                </div>
                <div class="button_depositar">
                    <button type="submit">Depositar</button>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="js/funcoes.js"></script>
</body>

</html>