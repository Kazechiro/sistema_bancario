<?php
if (!isset($_SESSION)) {
  session_start();
}

include('protect.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="3;url=principal.php">
    <title>Carregando...</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="loading-container">
        <div class="loader">Carregando
            <span></span>
        </div>
    </div>
</body>

</html>