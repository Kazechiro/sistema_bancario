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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir a Senha</title>

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
                    <input type="text" name="nova_senha" class="inputSenha" id="senha" placeholder="" required>
                    <label class="labelSenha" for="nova_senha">
                        Nova Senha:
                    </label>
                </div>

                <div class="botao_senha">
                    <button type="submit" value="Atualizar Senha">Atualizar Senha</button><br><br>
                    <a href="index.php">Voltar</a>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript" src="js/script.js"></script>
</body>

</html>