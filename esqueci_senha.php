<?php
session_start();
include('conexao.php');

if (isset($_POST['cpf']) && isset($_POST['nova_senha'])) {
    $cpf = $conexao->real_escape_string($_POST['cpf']);
    $nova_senha = $conexao->real_escape_string($_POST['nova_senha']);

    if (empty($cpf) || empty($nova_senha)) {
        $_SESSION['msg_esqueci_senha'] = "<p class='error'>Preencha seu CPF e a nova senha</p>";
        header("Location: esqueci_senha.php");
        exit();
    } else {
        // Verifique se o CPF existe na tabela de usuários
        $sql_code = "SELECT * FROM usuarios WHERE cpf = '$cpf'";
        $sql_query = $conexao->query($sql_code) or die("Falha na execução do código SQL: " . $conexao->error);

        $quantidade = $sql_query->num_rows;

        if ($quantidade == 1) {
            // Atualize a senha na tabela de usuários (usando password_hash)
            $senha_hashed = password_hash($nova_senha, PASSWORD_ARGON2ID);
            $update_sql = "UPDATE usuarios SET senha = '$senha_hashed' WHERE cpf = '$cpf'";
            $conexao->query($update_sql) or die("Falha na execução do código SQL: " . $conexao->error);

            $_SESSION['msg_esqueci_senha'] = "<p class='success'>Senha atualizada com sucesso</p>";
            header("Location: esqueci_senha.php");
            exit();
        } else {
            $_SESSION['msg_esqueci_senha'] = "<p class='error'>CPF não encontrado</p>";
            header("Location: esqueci_senha.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Redefinir a Senha</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <div class="loader"></div>
                <h1 id="titulo">Sistema Bancário PB</h1>
            </div>
        </nav>
    </header>
    <div class="tela_esqueci_senha">
        <h1>Redefinir a Senha</h1><br>
        <div class="form_senha">
            <?php
            if (isset($_SESSION['msg_esqueci_senha'])) {
                echo $_SESSION['msg_esqueci_senha'];
                unset($_SESSION['msg_esqueci_senha']);
            }
            ?>

            <form method="post" action="esqueci_senha.php">

                <div class="input_container_esqueci_senha">
                    <input type="text" name="cpf" id="cpf" class="inputSenha" placeholder="" required>
                    <label class="labelSenha" for="cpf">
                        Digite o seu CPF:
                    </label>
                </div>

                <div class="input_container_esqueci_senha">
                    <input type="password" name="nova_senha" class="inputSenha" id="senha" placeholder="" required>
                    <label class="labelSenha" for="nova_senha">
                        Nova Senha:
                    </label>
                    <span>Mostrar Senha:<input type="checkbox" onclick="mostrarOcultarSenha()"></span>
                </div>

                <div class="botao_senha">
                    <button type="submit" value="Atualizar Senha">Atualizar Senha</button>
                    <a href="index.php">Voltar</a>
                </div>

        </div>
        </form>
    </div>

    <script type="text/javascript" src="js/funcoes.js"></script>
</body>

</html>