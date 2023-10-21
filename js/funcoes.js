function mostrarOcultarSenha() {
    var senhaInput = document.getElementById("senha");
    if (senhaInput.type === "password") {
        senhaInput.type = "text";
    } else {
        senhaInput.type = "password";
    }
}


document.addEventListener("DOMContentLoaded", function() {
    const transferButton = document.querySelector('button[type="submit"][value="cadastrar"]');
    const nome = document.querySelector('input[name="nome"]');
    const cpf_cadastro = document.querySelector('input[name="cpf_cadastro"]');
    const cep = document.querySelector('input[name="cep"]');
    const data_nascimento = document.querySelector('input[name="data_nascimento"]');
    const senha = document.querySelector('input[name="senha"]');

    if (transferButton) {
        transferButton.addEventListener("click", function(event) {
            if (nome.value.trim() === "" || cpf_cadastro.value.trim() === ""
            || cep.value.trim() === "" || data_nascimento.value.trim() === ""
            || senha.value.trim() === "") {
                event.preventDefault();
                alert("Por favor, preencha os campos antes de realizar o Cadastro.");
            }
        });
    }
});


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
    

document.addEventListener("DOMContentLoaded", function() {
    
    var transacoes = document.querySelectorAll('.transacoes');
  
    // Verificar se há transações
    if (transacoes.length > 4) {
      var scrollToTopButton = document.getElementById('scrollToTopButton');
      if (scrollToTopButton) {
        scrollToTopButton.style.display = 'block'; // Mostrar o botão
        scrollToTopButton.addEventListener('click', function() {
          // Função para rolar suavemente para o topo
          window.scrollTo({
            top: 0,
            behavior: 'smooth'
          });
        });
      }
    }
});
  

function confirmarSaida() {
    var confirmacao = confirm("Deseja realmente sair do sistema?");
    if (confirmacao) {
        window.location.href = "sair.php";
    }
}
