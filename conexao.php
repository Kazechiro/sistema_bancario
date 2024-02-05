<?php

$usuario = 'root';
$senha = '';
$database = 'sb';
$host = 'localhost';

$conexao = new mysqli($host, $usuario, $senha, $database);

if($conexao->error) {
    die("Falha ao conectar ao banco de dados: " . $conexao->error);
}

try {

$conn = new PDO("mysql:host=$host;dbname=" . $database, $usuario, $senha);

} catch(PDOException $err) {
    echo "Erro: conexão com o banco de dados não estabelecida." . $err->getMessage();
} 

?>
