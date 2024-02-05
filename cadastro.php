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
    <title>Cadastro</title>

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
        <div class="bg_home container" id="home">
            <header>
                <nav class="navbar">
                    <div class="navbar_logo">
                        <div class="coin"></div>
                        <h1>FinTechGuard</h1>
                    </div>
                </nav>
            </header>
        </div>
    </header>

    <div class="tela_cadastro">
        <h1>Cadastre sua conta</h1><br>
        <div class="form_cadastro">
            <form action="cadastrar.php" method="POST">
                <?php
                if (isset($_SESSION['msg_cadastro'])) {
                    echo $_SESSION['msg_cadastro'];
                    unset($_SESSION['msg_cadastro']);
                }
                ?>

                <div class="input_container_cadastro">
                    <input type="text" maxlength="60" minlength="10" name="nome" class="inputCadastro" placeholder="" required>
                    <label class="labelCadastro">
                        Digite seu nome
                    </label>
                </div>
                <div class="input_container_cadastro">
                    <input type="number" name="cpf_cadastro" class="inputCadastro" placeholder="" required>
                    <label class="labelCadastro">
                        Cpf
                    </label>
                </div>
                <div class="input_container_cadastro">
                    <input type="text" oninput="maxLengthCheck(this)" maxlength="8" name="cep" class="inputCadastro" placeholder="" required>
                    <label class="labelCadastro">
                        Cep
                    </label>
                    <script>
                        function maxLengthCheck(object) {
                            if (object.value.length > object.maxLength)
                                object.value = object.value.slice(8, 8)
                        }
                    </script>
                </div>
                <div class="input_container_cadastro">
                    <input type="date" name="data_nascimento" class="inputCadastro" placeholder="" required>
                    <label class="labelCadastro">
                        Data de Nascimento
                    </label>
                </div>
                <div class="input_container_cadastro">
                    <input type="text" name="senha" class="inputCadastro" placeholder="" required>
                    <label class="labelCadastro">
                        Senha
                    </label>
                </div>
                <div class="botao_cadastro">
                    <button type="submit" value="cadastrar">Cadastrar</button>
                </div>
                <div class="cadastro">
                    Já tem uma conta?
                    <a href="index.php">
                        Logar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        <?php
        if (isset($_GET['error']) && $_GET['error'] === 'cpf') {
            echo "alert('CPF inválido. O CPF deve conter exatamente 11 números.');";
        }
        ?>
    </script>

    <script type="text/javascript" src="src/js/funcoes.js"></script>
</body>

</html>