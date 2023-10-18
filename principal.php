<?php
if (!isset($_SESSION)) {
  session_start();
}

include('protect.php');
include('conexao.php');

include('deposito.php');
include('sacar.php');

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Início</title>
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
        <h2> Bem vindo (a): <?php echo $_SESSION['nome']; ?></h2>
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

  <div class="detalhes_conta clearfix">
    <h1>Detalhes da Conta</h1><br>
    <h3>Nome do Cliente: <?php echo $_SESSION['nome']; ?></h3>
    <h3>Seu saldo na conta é de: R$<?php echo $_SESSION['saldo']; ?></h3><br>
    <hr>

    <div class="informacoes_conta">

      <div class="form_depositar">
        <h2>Faça o Depósito</h2><br>
        <form action="deposito.php" method="POST">
          <div class="input_container_depositar">
            <input type="number" name="valor_deposito" id="valor" class="inputDepositar" placeholder="" required>
            <label class="labelDepositar" for="valor">
              Valor:
            </label>
          </div>
          <div class="botao_conta">
            <button type="submit" value="depositar">Depositar</button>
          </div>
          <?php
          if (isset($_SESSION['msg_deposito'])) {
            echo $_SESSION['msg_deposito'];
            unset($_SESSION['msg_deposito']);
          }
          ?>
        </form>
      </div>

      <div class="form_sacar">
        <h2>Faça o Saque</h2><br>
        <form action="sacar.php" method="POST" id="form_login">
          <div class="input_container_sacar">
            <input type="number" name="valor_sacado" class="inputSacar" placeholder="" required>
            <label class="labelSacar">
              Valor:
            </label>
          </div>
          <div class="botao_conta">
            <button type="submit" value="sacar">Sacar</button>
          </div>
          <?php
          if (isset($_SESSION['msg_sacar'])) {
            echo $_SESSION['msg_sacar'];
            unset($_SESSION['msg_sacar']);
          }
          ?>
        </form>
      </div>

    </div>
  </div>

  <script type="text/javascript" src="js/funcoes.js"></script>
</body>

</html>