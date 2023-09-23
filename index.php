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
        $sql_code = "SELECT * FROM usuarios WHERE cpf = '$cpf' AND senha = '$senha'";
        $sql_query = $conexao->query($sql_code) or die("Falha na execução do código SQL: " . $conexao->error);

        $quantidade = $sql_query->num_rows;

        if ($quantidade == 1) {
            $usuario = $sql_query->fetch_assoc();

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['cpf'] = $usuario['cpf'];
            $_SESSION['senha'] = $usuario['senha'];
            $_SESSION['saldo'] = $usuario['saldo'];

            header("Location: principal.php");
            exit();
        } else {
            $_SESSION['msg_login'] = "<p class='error'>Falha ao logar! cpf ou senha incorretos</p>";
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
</head>

<body class="body-login">
    <div id="login">
        <form action="" method="POST" id="form_login">
            <?php
            if (isset($_SESSION['msg_login'])) {
                echo $_SESSION['msg_login'];
                unset($_SESSION['msg_login']);
            }
            ?>

            <h1>
                Acesse sua conta
            </h1>
            <div class="input-container">
            <input type="text" name="cpf" id="cpf" class="inputLogin" required>
                <label class="labelLogin">
                    cpf
                </label>
            </div>

            <div class="input-container">
                <input type="password" name="senha" class="inputLogin" required>
                <label class="labelLogin">
                    Senha
                </label>
            </div>

            <div>
                <button type="submit" class="submit-button">
                    Entrar
                </button>
            </div>

            <div class="cadastro">
                Não possui uma conta? <a href="cadastro.php">Inscreva-se</a>
            </div>
        </form>
    </div>

    <script src="js/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
   
</body>

</html>
