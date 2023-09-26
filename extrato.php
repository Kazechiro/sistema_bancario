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
  <title>Document</title>
</head>
<body>
  <center>
    Extrato de <?php echo $_SESSION['nome'] ?><br>
    =========================================================
    <?php
    $sql_transacoes = "SELECT * FROM transacoes WHERE usuario_id = :usuario_id";
    $stmt_transacoes = $conn->prepare($sql_transacoes);
        $stmt_transacoes->bindParam(':usuario_id', $usuario_id);
        $stmt_transacoes->execute();

        while ($row_transacoes = $stmt_transacoes->fetch(PDO::FETCH_ASSOC)) {
          echo "<div class='transacoes'>";
          echo "<li class='lista'>";
          echo "<span>" .$row_transacoes['tipo_transacao'] . ":</span>";
          echo "<span> Valor:" .$row_transacoes['valor'] . "</span>";
          echo "</li><br><br>";
          echo "</div>";
        }
    
    ?>
    <a href="principal.php">Voltar</a>
  </center>
</body>
</html>