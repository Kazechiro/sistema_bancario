<?php
include('conexao.php');
session_start();

$cpf_cadastro = isset($_POST['cpf_cadastro']) ? $_POST['cpf_cadastro'] : '';
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : '';
$cep = isset($_POST['cep']) ? $_POST['cep'] : '';
$data_nascimento = isset($_POST['data_nascimento']) ? $_POST['data_nascimento'] : '';

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
                VALUES ('$nome', '$cpf_cadastro', '$cep', '$data_nascimento', '$senha', 0)";
    $query_incluir = mysqli_query($conexao, $incluir);

    if ($query_incluir) {
        echo "<script>alert('Cadastro realizado com sucesso.'); window.location.href='index.php';</script>";
        exit();
    } else {
        die("Erro ao inserir dados: " . mysqli_error($conexao));
    }
} else {
    // O CPF já existe na tabela
    $_SESSION['msg_cadastro'] = "<p class='error'>CPF já existe</p>";
    header("location: cadastro.php");
    exit();
}
?>
