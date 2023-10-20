<?php

include('conexao.php');
include('protect.php');

$usuario_id = $_SESSION['id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Extrato</title>
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
        <h2>Conta: <?php echo $_SESSION['nome']; ?></h2>
      </div>
      <div class="botao_nav">
        <ul>
          <a href="principal.php"> <button class="butao">Início</button></a>
          <a href="transferir.php"> <button class="butao">Transferir</button></a>
          <a href="extrato.php"> <button id="butao_selecionado">Extrato</button></a>
          <a href="perfil.php"> <button class="butao">Perfil</button></a>
          <a href="javascript:void(0);" onclick="confirmarSaida();"> <button class="butao">Sair</button></a>
        </ul>
      </div>
    </nav>
  </header>

  <div class="caixa_dados_extrato">
    <h2>Extrato de <?php echo $_SESSION['nome'] ?></h2><br>
    <div class="informacoes_extrato">
      
        <?php
        $sql_transacoes = "SELECT * FROM transacoes WHERE usuario_id = :usuario_id";
        $stmt_transacoes = $conn->prepare($sql_transacoes);
        $stmt_transacoes->bindParam(':usuario_id', $usuario_id);
        $stmt_transacoes->execute();

        while ($row_transacoes = $stmt_transacoes->fetch(PDO::FETCH_ASSOC)) {
          echo "<div class='transacoes'>";
          echo "<li class='lista'>";


          if ($row_transacoes['tipo_transacao'] == 'Depósito') {
            $tipo = 'Depósito:'.' +';
        } else if($row_transacoes['tipo_transacao'] == 'Saque'){
            $tipo = 'Saque: '.' -';
        } else if($row_transacoes['tipo_transacao'] == 'Transferência enviada') {
          $tipo = 'Transferência enviada'.' -';
        } else {
          $tipo = 'Transferência recebida'.' +';
        }

          echo "<span>" . $tipo . $row_transacoes['valor'] . "</span>";
          echo "<br>";
          echo "<span>Data: " . $row_transacoes['data_hora'] . "</span>";
          echo "</li>";
          echo "</div>";
        }

        ?>
        <h3>Seu saldo: R$<?php echo $_SESSION['saldo'] ?></h3><br>
        <div class="botao_voltar_extrato">
          <button id="scrollToTopButton">Voltar ao Topo</button>
        </div>
        
    </div>
  </div>

  <script type="text/javascript" src="js/funcoes.js"></script>
</body>

</html>