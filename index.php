<?php
session_start();
include('conexao.php');


if (isset($_POST['cpf']) && isset($_POST['senha'])) {
    $cpf = $conexao->real_escape_string($_POST['cpf']);
    $senha = $conexao->real_escape_string($_POST['senha']);

    if (empty($cpf)) {
        $_SESSION['msg_login'] = "<p class='error'>Preencha seu cpf</p>";
        header("Location: index.php");
        exit();
    } elseif (empty($senha)) {
        $_SESSION['msg_login'] = "<p class='error'>Preencha sua senha</p>";
        header("Location: index.php");
        exit();
    } else {
        $sql_code = "SELECT * FROM usuarios WHERE cpf = '$cpf'";
        $sql_query = $conexao->query($sql_code) or die("Falha na execução do código SQL: " . $conexao->error);

        $quantidade = $sql_query->num_rows;

        if ($quantidade == 1) {
            $usuario = $sql_query->fetch_assoc();

            if (password_verify($senha, $usuario['senha'])) {
                $_SESSION['id'] = $usuario['id'];
                $_SESSION['nome'] = $usuario['nome'];
                $_SESSION['cpf'] = $usuario['cpf'];
                $_SESSION['cep'] = $usuario['cep'];
                $_SESSION['data_nascimento'] = $usuario['data_nascimento'];
                $_SESSION['senha'] = $usuario['senha'];
                $_SESSION['saldo'] = $usuario['saldo'];

                header("Location: loading.php");
                exit();
            } else {
                $_SESSION['msg_login'] = "<p class='error'>Falha ao logar! CPF ou senha incorretos</p>";
                header("Location: index.php");
                exit();
            }
        } else {
            $_SESSION['msg_login'] = "<p class='error'>Falha ao logar! CPF ou senha incorretos</p>";
            header("Location: index.php");
            exit();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

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

    <div class="tela_login">
        <h1>Acesse sua conta</h1><br>
        <div class="form_login">
            <form action="" method="POST">
                <?php
                if (isset($_SESSION['msg_login'])) {
                    echo $_SESSION['msg_login'];
                    unset($_SESSION['msg_login']);
                }
                ?>

                <div class="input_container_login">
                    <input type="text" name="cpf" id="cpf" class="inputLogin" placeholder="" required>
                    <label class="labelLogin">
                        CPF
                    </label>
                </div>

                <div class="input_container_login">
                    <input type="password" name="senha" class="inputLogin" id="senha" placeholder="" required>
                    <label class="labelLogin">
                        Senha
                    </label>
                    <span>Mostrar Senha:

                    <label class="checkbox-container">
                        <input class="custom-checkbox" type="checkbox" onclick="mostrarOcultarSenha()"> 
                        <span class="checkmark"></span>
                    </label></span>
                    
                    <a id="esqueci_senha" href="esqueci_senha.php">Esqueceu a senha?</a>
                </div>

                <div class="botao_login">
                    <button type="submit">Entrar</button>
                </div>

                <div class="login_cadastro">
                    Não possui uma conta? <a href="cadastro.php">Cadastre-se</a>
                </div>
            </form>
        </div>
    </div>

    <footer class="footer">
        <p>Copyright© 2024 | Projeto da Faculdade FPB - Todos os direitos reservados.</p>
    </footer>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
</body>

</html>