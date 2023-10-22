<?php
include('conexao.php');
session_start();

$cpf_cadastro = isset($_POST['cpf_cadastro']) ? $_POST['cpf_cadastro'] : '';
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : '';
$cep = isset($_POST['cep']) ? $_POST['cep'] : '';
$data_nascimento = isset($_POST['data_nascimento']) ? $_POST['data_nascimento'] : '';
$cpf_error = '';

// Verifique se o CPF possui exatamente 11 caracteres e contém apenas números
$cpf_cadastro = preg_replace("/[^0-9]/", "", $cpf_cadastro); // Remova qualquer caractere que não seja número
if (strlen($cpf_cadastro) !== 11) {
    $cpf_error = "CPF inválido. O CPF deve conter exatamente 11 números.";
    $_SESSION['msg_cadastro'] = "<p class='error'>CPF inválido. O CPF deve conter exatamente 11 números.</p>";
    header('Location:cadastro.php');
    exit();
}

// Validação e limpeza das entradas do usuário
$cpf_cadastro = htmlspecialchars($cpf_cadastro, ENT_QUOTES, 'UTF-8');
$nome = htmlspecialchars($nome, ENT_QUOTES, 'UTF-8');
$cep = htmlspecialchars($cep, ENT_QUOTES, 'UTF-8');
$data_nascimento = htmlspecialchars($data_nascimento, ENT_QUOTES, 'UTF-8');

// Hash da senha com funções modernas de hash
$senha_hashed = password_hash($senha, PASSWORD_ARGON2ID);

if (empty($cpf_error)) {
    // Verifique se o CPF já existe na tabela
    $verificar_cpf = "SELECT cpf FROM usuarios WHERE cpf = '$cpf_cadastro'";
    $query_verificar = mysqli_query($conexao, $verificar_cpf);

    if (!$query_verificar) {
        die("Erro na consulta: " . mysqli_error($conexao));
    }

    $dados = mysqli_fetch_row($query_verificar);

    if (!$dados) {
        // O CPF não existe na tabela, insira os dados
        $incluir = "INSERT INTO usuarios(nome, cpf, cep, data_nascimento, senha, saldo) 
                    VALUES ('$nome', '$cpf_cadastro', '$cep', '$data_nascimento', '$senha_hashed', 0)";
        $query_incluir = mysqli_query($conexao, $incluir);

        if ($query_incluir) {
            echo "<script>alert('Cadastro realizado com sucesso.'); window.location.href='index.php';</script>";
            exit();
        } else {
            die("Erro ao inserir dados: " . mysqli_error($conexao));
        }
    } else {
        // O CPF já existe na tabela
        $cpf_error = "CPF Cadastrado no Sistema";
    }
}
?>
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
        <h2>.ERRO 409.</h2>
        <span>
        <?php echo $cpf_error; ?>
</span>
<br>
       <a href="cadastro.php"> <button class="butao">Voltar</button></a>
</div>

    
    <script type="text/javascript" src="js/funcoes.js"></script>
</body>

</html>
