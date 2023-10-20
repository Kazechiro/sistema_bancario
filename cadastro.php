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
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <div class="coin"></div>
                <h1 id="titulo">FinTechGuard</h1>
            </div>
        </nav>
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
                    <input type="text" name="nome" class="inputCadastro" placeholder="" required>
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
                    <input type="text" name="cep" class="inputCadastro" placeholder="" required>
                    <label class="labelCadastro">
                        Cep
                    </label>
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

    <script type="text/javascript" src="js/funcoes.js"></script>
</body>

</html>