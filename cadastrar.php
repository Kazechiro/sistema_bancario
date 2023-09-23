<?php
include('conexao.php');
session_start();
//INCLUIR
$cpf_cadastro = isset($_POST['cpf_cadastro'])? $_POST['cpf_cadastro'] : '';
$nome = isset($_POST['nome'])? $_POST['nome'] : '';
$senha = isset($_POST['senha'])? $_POST['senha'] : '';

$verificar_cpf ="SELECT cpf FROM usuarios WHERE cpf  = '$cpf_cadastro'"; //Percorre todo a coluna matricula e ver se a matricula que o usuário informou já existe
$query_verificar = mysqli_query($conexao, $verificar_cpf);
$dados = mysqli_fetch_row($query_verificar);
if ($dados[0] != $cpf_cadastro) { 

  $incluir = "INSERT INTO usuarios(nome, cpf, senha, saldo) 
  VALUES ('$nome', '$cpf_cadastro', '$senha',0)";
  $query_incluir = mysqli_query($conexao, $incluir);

  $_SESSION['msg_cadastro'] = "<h3 class='success'>Email cadastrado com sucesso.</h3>";
header('location: index.php');
exit();
} else {

$_SESSION['msg_cadastro'] = "<p class='error'>Email já existe</p>";
header("location: cadastro.php");
exit();

}

?>