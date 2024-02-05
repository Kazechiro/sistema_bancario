<?php
if (!isset($_SESSION)) {
    session_start();
}

include('protect.php');
include('conexao.php');

include('deposito.php');
include('sacar.php');

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Biblioteca fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400;500;600;700&family=Roboto:wght@300;400;500;700;900&family=Sora:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Biblioteca icones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Animações -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <link rel="stylesheet" href="style.css">

    <title>Sistema Bancário - FinTechGuard</title>
</head>

<body>
    <div class="bg_home container" id="home">
        <header>
            <nav class="navbar">
                <div class="navbar_logo">
                    <div class="coin"></div>
                    <h1>FinTechGuard</h1>
                </div>

                <div class="bem_vindo_nome">
                    <h2> Bem vindo (a): <?php echo $_SESSION['nome']; ?></h2>
                </div>

                <div class="navbar_links">
                    <a href="principal.php" class="nav-link" onclick="changeColor(this)"><button id="butao_selecionado">Início</button></a>
                    <a href="transferir.php" class="nav-link" onclick="changeColor(this)"><button>Transferir</button></a>
                    <a href="extrato.php" class="nav-link" onclick="changeColor(this)"><button>Extrato</button></a>
                    <a href="perfil.php" class="nav-link" onclick="changeColor(this)"><button>Perfil</button></a>
                    <a href="javascript:void(0);" onclick="confirmarSaida();"><button>Sair</button></a>
                </div>

                <div class="navbar_toggle">
                    <button class="toggle_button">&#9776;</button>
                </div>
            </nav>

            <main class="hero container" data-aos="fade-up" data-aos-delay="100">
                <div class="detalhes_conta clearfix">

                    <h1>Detalhes da Conta</h1><br>
                    <h3>Nome do Cliente: <?php echo $_SESSION['nome']; ?></h3>
                    <h3>Seu saldo na conta é de: R$<?php echo $_SESSION['saldo']; ?></h3><br>
                    <hr>

                    <div class="informacoes_conta">

                        <div class="form_depositar">
                            <h2>Faça o Depósito</h2><br>
                            <form action="deposito.php" method="POST">
                                <div class="input_container_depositar">
                                    <input type="number" name="valor_deposito" id="valor" class="inputDepositar" placeholder="" required>
                                    <label class="labelDepositar" for="valor">
                                        Valor:
                                    </label>
                                </div>
                                <div class="botao_conta">
                                    <button type="submit" value="depositar">Depositar</button>
                                </div>
                                <?php
                                if (isset($_SESSION['msg_deposito'])) {
                                    echo $_SESSION['msg_deposito'];
                                    unset($_SESSION['msg_deposito']);
                                }
                                ?>
                            </form>
                        </div>

                        <div class="form_sacar">
                            <h2>Faça o Saque</h2><br>
                            <form action="sacar.php" method="POST" id="form_login">
                                <div class="input_container_sacar">
                                    <input type="number" name="valor_sacado" class="inputSacar" placeholder="" required>
                                    <label class="labelSacar">
                                        Valor:
                                    </label>
                                </div>
                                <div class="botao_conta">
                                    <button type="submit" value="sacar">Sacar</button>
                                </div>
                                <?php
                                if (isset($_SESSION['msg_sacar'])) {
                                    echo $_SESSION['msg_sacar'];
                                    unset($_SESSION['msg_sacar']);
                                }
                                ?>
                            </form>
                        </div>

                    </div>
                </div>
            </main>

        </header>
    </div>

    <script type="text/javascript" src="js/script.js"></script>
</body>

</html>