<?php
if (!isset($_SESSION)) {
  session_start();
}
include('protect.php');
include('conexao.php');

?>
<center>
<legend> Bem vindo ao seu Sistema Bancário, <?php echo $_SESSION['nome']; ?>. </legend><br>
<div>Seu saldo na conta é de: R$<?php echo $_SESSION['saldo']; ?>.</div><br><br>


<a href="perfil.php"> <button class="butao">Perfil</button></a> <br><br>
<a href="deposito.php"> <button class="butao">Depositar</button> </a> <br><br>
<a href="sacar.php"> <button class="butao">Sacar</button></a> <br><br>
<a href="transferir.php"> <button class="butao">Transferir</button></a> <br><br>
<a href="extrato.php"> <button class="butao">Extrato</button></a> <br><br>
<a href="sair.php"> <button class="butao">Sair</button></a> <br><br>

</center>
