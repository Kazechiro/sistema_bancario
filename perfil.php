<?php
session_start();

// Verifique se o usuário está logado, redirecione para a página de login se não estiver
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

include('conexao.php');

// Recupere as informações do usuário a partir da sessão
$id = $_SESSION['id'];
$nome = $_SESSION['nome'];
$cpf = $_SESSION['cpf'];
$cep = $_SESSION['cep'];
$data_nascimento = $_SESSION['data_nascimento'];
$senha = $_SESSION['senha'];
$saldo = $_SESSION['saldo'];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

    <title>Seu Perfil</title>
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
                <a href="extrato.php" class="nav-link" onclick="changeColor(this)"><button>Extrato</button></a>
                <a href="perfil.php" class="nav-link" onclick="changeColor(this)"><button id="butao_selecionado">Perfil</button></a>
                <a href="javascript:void(0);" onclick="confirmarSaida();"><button>Sair</button></a>
            </div>

            <div class="navbar_toggle">
                <button class="toggle_button">&#9776;</button>
            </div>
        </nav>
    </header>

    <div class="caixa_dados_perfil" data-aos="fade-up" data-aos-delay="100">
        <h1>Dados do Perfil</h1>
        <hr>
        <div class="informacoes_usuario_perfil">
            <p><strong>Nome:</strong> <?php echo $nome; ?></p>
            <p><strong>CPF:</strong> <?php echo $cpf; ?></p>
            <p><strong>CEP:</strong> <?php echo $cep; ?></p>
            <p><strong>Data de Nascimento:</strong> <?php echo $data_nascimento; ?></p>
            <p><strong>ID para transferência:</strong> <?php echo $id; ?></p>
        </div>
    </div>

    <script type="text/javascript" src="js/script.js"></script>
</body>

</html>