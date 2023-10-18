function mostrarOcultarSenha() {
    var senhaInput = document.getElementById("senha");
    if (senhaInput.type === "password") {
        senhaInput.type = "text";
    } else {
        senhaInput.type = "password";
    }
}


document.addEventListener("DOMContentLoaded", function() {
    const transferButton = document.querySelector('button[type="submit"][value="depositar"]');
    const updateLimitButton = document.querySelector('button[type="submit"][value="sacar"]');
    const valorDepositado = document.querySelector('input[name="valor_deposito"]');
    const valorSacado = document.querySelector('input[name="valor_sacado"]');

    if (transferButton) {
        transferButton.addEventListener("click", function(event) {
            if (valorDepositado.value.trim() === "") {
                event.preventDefault();
                alert("Por favor, preencha o campo antes de realizar o Depósito.");
            }
        });
    }

    if (updateLimitButton) {
        updateLimitButton.addEventListener("click", function(event) {
            if (valorSacado.value.trim() === "") {
                event.preventDefault();
                alert("Por favor, preencha o campo antes de realizar o Saque.");
            }
        });
    }
});


document.addEventListener("DOMContentLoaded", function() {
    const transferButton = document.querySelector('button[type="submit"][value="Realizar Transferência"]');
    const updateLimitButton = document.querySelector('button[type="submit"][value="Atualizar Limite"]');
    const valorInput = document.querySelector('input[name="valor"]');
    const destinatarioInput = document.querySelector('input[name="destinatario_id"]');
    const newLimitInput = document.querySelector('input[name="novo_limite"]');

    if (transferButton) {
        transferButton.addEventListener("click", function(event) {
            if (valorInput.value.trim() === "" || destinatarioInput.value.trim() === "") {
                event.preventDefault();
                alert("Por favor, preencha todos os campos antes de realizar a transferência.");
            }
        });
    }

    if (updateLimitButton) {
        updateLimitButton.addEventListener("click", function(event) {
            if (newLimitInput.value.trim() === "") {
                event.preventDefault();
                alert("Por favor, insira o novo limite antes de atualizar.");
            }
        });
    }
});
    

function scrollToTop() {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  }
  
  var scrollToTopButton = document.getElementById('scrollToTopButton');
  if (scrollToTopButton) {
    scrollToTopButton.addEventListener('click', scrollToTop);
  }
  

function confirmarSaida() {
    var confirmacao = confirm("Deseja realmente sair do sistema?");
    if (confirmacao) {
        window.location.href = "sair.php";
    }
}
