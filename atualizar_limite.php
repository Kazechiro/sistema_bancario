<?php
if (!isset($_SESSION)) {
    session_start();
}

include "conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $novoLimite = isset($_POST['novo_limite']) ? floatval($_POST['novo_limite']) : 0;

    if ($novoLimite <= 499) {
        $_SESSION['msg_limite'] = "<br><p class='error'>O valor do limite deve ser maior que R$499.</p>";
        header("Location: atualizar_limite.php");
        exit();
    }

    // Atualiza o limite do usuário logado no banco de dados
    $usuario_id = $_SESSION['id']; // Suponha que o ID do usuário logado está na variável de sessão

    $sqlAtualizarLimite = "UPDATE usuarios SET limite = $novoLimite WHERE id = $usuario_id";

    if (mysqli_query($conexao, $sqlAtualizarLimite)) {
        $_SESSION['limite'] = $novoLimite; // Atualiza o limite na variável de sessão
        $_SESSION['msg_limite'] = "<br><p class='success'>Limite atualizado com sucesso!</p>";
        header("Location: transferir.php");
        exit();
    } else {
        echo "Erro na atualização do limite. Por favor, tente novamente.";
    }

    $_SESSION['msg_limite'] = "<br><p class='success'>Limite atualizado com sucesso!</p>";
    header("Location: transferir.php");
    exit();

    // Feche a conexão com o banco de dados
    mysqli_close($conexao);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transferência de Dinheiro</title>

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
                <a href="atualizar_limite.php" class="nav-link" onclick="changeColor(this)"><button id="butao_selecionado">Atualizar Limite</button></a>
                <a href="extrato.php" class="nav-link" onclick="changeColor(this)"><button>Extrato</button></a>
                <a href="perfil.php" class="nav-link" onclick="changeColor(this)"><button>Perfil</button></a>
                <a href="javascript:void(0);" onclick="confirmarSaida();"><button>Sair</button></a>
            </div>

            <div class="navbar_toggle">
                <button class="toggle_button">&#9776;</button>
            </div>
        </nav>
    </header>

    <div class="tela_atualizar_limite" data-aos="fade-up" data-aos-delay="100">
        <h2>Atualizar Limite de Transferência</h2><br>
        <div class="form_atualizar_limite">
            <form action="atualizar_limite.php" method="POST">
                <div class="input_container_limite">
                    <label for="novo_limite">Novo Limite de Transferência:</label>
                    <input type="number" oninput="maxLengthCheck(this)" maxLenght="9" name="novo_limite" step="0.01" class="inputLimite" required><br>
                    <script>
                        function maxLengthCheck(object) {
                            if (object.value.length > object.maxLength)
                                object.value = object.value.slice(0, 9)
                        }
                    </script>
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

    <script type="text/javascript" src="js/script.js"></script>
</body>

</html>