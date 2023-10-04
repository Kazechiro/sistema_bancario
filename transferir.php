<?php
if (!isset($_SESSION)) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transferência de Dinheiro</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <div class="loader"></div>
                <h1 id="titulo">Sistema Báncario PB</h1>
            </div>
            <div class="bem_vindo_nome">
                <h2> Conta: <?php echo $_SESSION['nome']; ?></h2>
            </div>
            <div class="botao_nav">
                <ul>
                    <a href="principal.php"> <button class="butao">Início</button></a>
                    <a href="transferir.php"> <button id="butao_selecionado">Transferir</button></a>
                    <a href="extrato.php"> <button class="butao">Extrato</button></a>
                    <a href="perfil.php"> <button class="butao">Perfil</button></a>
                    <a href="javascript:void(0);" onclick="confirmarSaida();"> <button class="butao">Sair</button></a>
                </ul>
            </div>
        </nav>
    </header>

    <div class="tela_trasferir">
        <h1>Transferência de Dinheiro</h1><br>
        <div class="form_trasferir">

            <form action="processar_transferencia.php" method="POST">

                <div class="input_container_transferir">
                    <label for="destinatario_id">ID do Destinatário:</label>
                    <input type="text" name="destinatario_id" class="inputTransferir" required><br>
                </div>

                <div class="input_container_transferir">
                    <label for="valor">Valor a Transferir:</label>
                    <input type="number" name="valor" step="0.01" class="inputTransferir" required><br>
                </div>

                <div class="botao_trasferir">
                <button type="submit">Realizar Transferência</button>
                </div>
            </form>
            
        </div>
    </div>
</body>

</html>