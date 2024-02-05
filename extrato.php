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

  <!-- Biblioteca fontes -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400;500;600;700&family=Roboto:wght@300;400;500;700;900&family=Sora:wght@300;400;500;600&display=swap" rel="stylesheet">

  <!-- Biblioteca icones -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Animações -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <link rel="stylesheet" href="style.css">

</head>

<body>
  <header>
    <nav class="navbar">
      <div class="navbar_logo">
        <div class="coin"></div>
        <h1>FinTechGuard</h1>
      </div>

      <div class="navbar_links">
        <a href="principal.php" class="nav-link" onclick="changeColor(this)"><button>Início</button></a>
        <a href="transferir.php" class="nav-link" onclick="changeColor(this)"><button>Transferir</button></a>
        <a href="extrato.php" class="nav-link" onclick="changeColor(this)"><button id="butao_selecionado">Extrato</button></a>
        <a href="perfil.php" class="nav-link" onclick="changeColor(this)"><button>Perfil</button></a>
        <a href="javascript:void(0);" onclick="confirmarSaida();"><button>Sair</button></a>
      </div>

      <div class="navbar_toggle">
        <button class="toggle_button">&#9776;</button>
      </div>
    </nav>
  </header>

  <div class="caixa_dados_extrato" data-aos="fade-up" data-aos-delay="100">
    <h2>Extrato de <?php echo $_SESSION['nome'] ?></h2><br>
    <div class="informacoes_extrato">
      <div class="todos_os_extratos"></div>

      <?php
      $sql_transacoes = "
      SELECT t.*, u.nome as nome_destinatario
      FROM transacoes t
      LEFT JOIN usuarios u ON t.usuario_destinatario = u.id
      WHERE t.usuario_id = :usuario_id AND t.tipo_transacao IN ('Depósito', 'Saque')
      UNION
      SELECT t.*, u.nome as nome_destinatario
      FROM transacoes t
      LEFT JOIN usuarios u ON t.usuario_id = u.id
      WHERE t.usuario_destinatario = :usuario_id AND t.tipo_transacao IN ('Transferência enviada', 'Transferência recebida')
      ORDER BY data_hora DESC";

      $stmt_transacoes = $conn->prepare($sql_transacoes);
      $stmt_transacoes->bindParam(':usuario_id', $usuario_id);
      $stmt_transacoes->execute();

      while ($row_transacoes = $stmt_transacoes->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class='transacoes'>";
        echo "<li class='lista'>";
        $tipo = '';

        if ($row_transacoes['tipo_transacao'] == 'Depósito') {
          $tipo = 'Depósito: +';
        } elseif ($row_transacoes['tipo_transacao'] == 'Saque') {
          $tipo = 'Saque: -';
        } elseif ($row_transacoes['tipo_transacao'] == 'Transferência enviada') {
          $tipo = 'Transferência de ' . $row_transacoes['nome_destinatario'] . ': +';
        } else {
          $tipo = 'Transferência para ' . $row_transacoes['nome_destinatario'] . ': -';
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
        <button onclick="scrollToTop()">Voltar ao Topo</button>
      </div>

    </div>
  </div>
  
  <script type="text/javascript" src="js/script.js"></script>
</body>

</html>