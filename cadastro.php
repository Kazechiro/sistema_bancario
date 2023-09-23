
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<form action="cadastrar.php" id="form_cadastro" method="POST">
            
<?php
            if (isset($_SESSION['msg_cadastro'])) {
                echo $_SESSION['msg_cadastro'];
                unset($_SESSION['msg_cadastro']);
            }
            ?>
            <h1>
                Cadastre sua conta
            </h1>

            <div class="input-container">
                <input type="text" name="nome" class="input" required>
                <label class="labelCadastro">
                    Digite seu nome
                </label>
            </div>

            <div class="input-container">
                <input type="number" name="cpf_cadastro" class="input" required>
                <label class="labelCadastro">
                    Digite seu cpf
                </label>
            </div>
          
            <div class="input-container">
                <input type="text" name="senha" class="input" required>
                <label class="labelCadastro">
                    Digite sua senha
                </label>
            </div>
            <div>
                <button type="submit" class="submit-button" value="Cadastrar">
                    Cadastrar
                </button>
            </div>
            <div class="cadastro">
                Já tem uma conta?
                <a href=index.php>
                    Logar
                </a>
            </div>
        </form>
</body>
</html>