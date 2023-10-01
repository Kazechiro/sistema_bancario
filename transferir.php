<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transferência de Dinheiro</title>
</head>
<body>
    <h1>Transferência de Dinheiro</h1>
    
    <form action="processar_transferencia.php" method="POST">
        <label for="destinatario_id">ID do Destinatário:</label>
        <input type="text" name="destinatario_id" required><br><br>
        
        <label for="valor">Valor a Transferir:</label>
        <input type="number" name="valor" step="0.01" required><br><br>
        
        <button type="submit">Realizar Transferência</button>
    </form>
    
    <a href="principal.php">Voltar</a>
</body>
</html>
