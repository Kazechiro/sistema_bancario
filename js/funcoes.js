function mostrarOcultarSenha() {
    var senhaInput = document.getElementById("senha");
    if (senhaInput.type === "password") {
        senhaInput.type = "text";
    } else {
        senhaInput.type = "password";
    }
}

function confirmarSaida() {
    var confirmacao = confirm("Deseja realmente sair do sistema?");
    if (confirmacao) {
        // Redirecionar para a página de saída (sair.php) somente se o usuário confirmar
        window.location.href = "sair.php";
    }
}
