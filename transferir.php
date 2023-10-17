<?php
if (!isset($_SESSION)) {
    session_start();
}

// Inclua o arquivo de conexão ao banco de dados
include "conexao.php";


// Obtém o limite de transferência do usuário logado
$limiteTransferencia = isset($_SESSION['limite']) ? $_SESSION['limite'] : 500;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $valorTransferencia = isset($_POST['valor']) ? floatval($_POST['valor']) : 0;

    if ($valorTransferencia > $limiteTransferencia) {
        echo "A transferência não pode exceder R$ " . $limiteTransferencia . ".";
    } else {
        // Prossiga com a lógica de transferência

        // Obtém os IDs do remetente e destinatário da transferência
        $remetente_id = $_SESSION['id']; // Suponha que o ID do remetente está na variável de sessão
        $destinatario_id = $_POST['destinatario_id']; // Suponha que o ID do destinatário foi enviado via formulário

        // Atualiza o saldo do remetente (subtrai o valor da transferência)
        $sqlRemetente = "UPDATE usuarios SET saldo = saldo - $valorTransferencia WHERE id = $remetente_id";

        // Atualiza o saldo do destinatário (soma o valor da transferência)
        $sqlDestinatario = "UPDATE usuarios SET saldo = saldo + $valorTransferencia WHERE id = $destinatario_id";

        // Execute as consultas SQL para atualizar os saldos no banco de dados
        if (mysqli_query($conexao, $sqlRemetente) && mysqli_query($conexao, $sqlDestinatario)) {
            // Atualize a variável de sessão com o novo saldo
            $_SESSION['saldo'] -= $valorTransferencia;

            // Exiba a mensagem de sucesso
            echo "Transferência realizada com sucesso!";
        } else {
            echo "Erro na transferência. Por favor, tente novamente.";
        }

        $_SESSION['msg_saldo'] = "<br><p class='success'>Transferência realizada com sucesso!</p>";
        header("Location: transferir.php");
        exit();

        // Feche a conexão com o banco de dados
        mysqli_close($conexao);
    }
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
                <div class="coin"></div>
                <h1 id="titulo">FinTechGuard</h1>
            </div>
            <div class="bem_vindo_nome">
                <h2> Conta: <?php echo $_SESSION['nome']; ?></h2>
            </div>
            <div class="botao_nav">
                <ul>
                    <a href="principal.php"> <button class="butao">Início</button></a>
<<<<<<< HEAD
                    <a href="transferir.php"> <button id="butao_selecionado">Transferir</button></a>
=======
                    <a href="transferir.php"> <button class="butao">Transferir</button></a>
>>>>>>> c836c5c61ded0b0761caed5f6029321f74bd92d7
                    <a href="extrato.php"> <button class="butao">Extrato</button></a>
                    <a href="perfil.php"> <button class="butao">Perfil</button></a>
                    <a href="javascript:void(0);" onclick="confirmarSaida();"> <button class="butao">Sair</button></a>
                </ul>
            </div>
        </nav>
    </header>

    <div class="tela_transferir">
        <h2>Transferência de Dinheiro</h2><br>
        <div class="form_transferir">
            <form action="transferir.php" method="POST">
                <div class="input_container_transferir">
                    <label for="destinatario_id">ID do Destinatário:</label>
                    <input type="text" name="destinatario_id" class="inputTransferir" required>
                </div>
                <div class="input_container_transferir">
                    <label for="valor">Valor a Transferir (limite de R$ <?php echo $limiteTransferencia; ?>):</label>
                    <input type="number" name="valor" step="0.01" class="inputTransferir" required><br>
                </div>
                <div class="botao_transferir">
<<<<<<< HEAD
                    <button type="submit" value="Realizar Transferência">Realizar Transferência</button>
                </div>
=======
                    <button type="submit">Realizar Transferência</button>
>>>>>>> c836c5c61ded0b0761caed5f6029321f74bd92d7
            </form>
        </div>
        <?php
        if (isset($_SESSION['msg_saldo'])) {
            echo $_SESSION['msg_saldo'];
            unset($_SESSION['msg_saldo']);
        }
        ?>
    </div>

    <div class="tela_atualizar_limite">
        <h2>Atualizar Limite de Transferência</h2><br>
        <div class="form_atualizar_limite">
            <form action="atualizar_limite.php" method="POST">
                <div class="input_container_limite">
                    <label for="novo_limite">Novo Limite de Transferência:</label>
                    <input type="number" name="novo_limite" step="0.01" class="inputLimite" required><br>
                </div>
                <div class="botao_atualizar_limite">
                    <button type="submit" value="Atualizar Limite">Atualizar Limite</button>
                </div>
            </form>
        </div>
        <?php
        if (isset($_SESSION['msg_limite'])) {
            echo $_SESSION['msg_limite'];
            unset($_SESSION['msg_limite']);
        }
        ?>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const transferButton = document.querySelector('button[type="submit"][value="Realizar Transferência"]');
            const updateLimitButton = document.querySelector('button[type="submit"][value="Atualizar Limite"]');
            const valorInput = document.querySelector('input[name="valor"]');
            const destinatarioInput = document.querySelector('input[name="destinatario_id"]');
            const newLimitInput = document.querySelector('input[name="novo_limite"]');

            if (transferButton) {
                transferButton.addEventListener("click", function(event) {
                    if (valorInput.value.trim() === "" || destinatarioInput.value.trim() === "") {
                        event.preventDefault();
                        alert("Por favor, preencha todos os campos antes de realizar a transferência.");
                    }
                });
            }

            if (updateLimitButton) {
                updateLimitButton.addEventListener("click", function(event) {
                    if (newLimitInput.value.trim() === "") {
                        event.preventDefault();
                        alert("Por favor, insira o novo limite antes de atualizar.");
                    }
                });
            }
        });
    </script>


    <script type="text/javascript" src="js/funcoes.js"></script>
</body>

</html>