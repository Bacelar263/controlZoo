<?php
    require './backend/dbcon.php'; 
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ControlZoo - Adicionar diagnóstico</title>

    <!-- Importando ícones do google -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=pill" />

    <!-- Importando ícones do boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>

    <!-- =================== REMIXICONS =================== -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">

    <!-- Importando arquivo css -->
    <link rel="stylesheet" href="./assets/css/base.css">
    <link rel="stylesheet" href="./assets/css/cliente.css">

  </head>

  <body>

    <!-- ==================== INÍCIO DA SIDEBAR ==================== -->

    <section class="sidebar">
        <img src="./assets/img/logo_cortada.jpg" alt="logo da ControlZoo" class="logo_cz">
        <div class="nav-header">
            <p class="logo">Olá, <b>Guilherme</b></p>
            <i class="bx bx-menu btn-menu"></i>
        </div>
        <ul class="nav-links">
            <li>
                <a href="dashboard.php">
                    <span class="material-icons-sharp">grid_view</span>
                    <span class="title">Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="clientes.php">
                    <span class="material-icons-sharp">person</span>
                    <span class="title">Clientes</span>
                </a>
                <span class="tooltip">Clientes</span>
            </li>
            <li>
                <a href="diagnostico.php">
                    <span class="material-symbols-outlined">pill</span>
                    <span class="title">Diagnóstico</span>
                </a>
                <span class="tooltip">Diagnóstico</span>
            </li>
            <li>
                <a href="#">
                    <span class="material-icons-sharp">logout</span>
                    <span class="title">Sair</span>
                </a>
                <span class="tooltip">Sair</span>
            </li>
        </ul>
        
        <div class="theme-wrapper">
            <p>Modo noturno</p>
            <div class="theme-btn">
                <span class="material-icons-sharp theme-ball">light_mode</span>
            </div>
        </div>

    </section>

    <!-- ==================== FINAL DA SIDEBAR ==================== -->

    <!-- ==================== INÍCIO DA SECTION DIAGNÓSTICO ==================== -->
    <section class="home">
        <div class="container">
            <div>
                <h1 class="home__titulo">Adicionar Diagnóstico</h1>
            </div>

            <div>
                <form action="./backend/code.php" method="post">
                    <div class="container__form-notas">
                        <div class="inputBox">
                            <div class="custom-select_especie input__form" id="dataEmissao">
                                <div style="display:flex; align-items: left; justify-content: space-between" onclick="toggleOptionsEspecie()">
                                    <a href="#">
                                        Selecione o pet
                                    </a>
                                    <i class="ri-arrow-up-s-fill arrow"></i>
                                </div>

                                <div class="options" style="align-items: left;">
                                    <div class="option">
                                        <?php 
                                        $query = "SELECT idpet, nome FROM pet";
                                        $query_run = mysqli_query($conexao, $query);

                                        if(mysqli_num_rows($query_run) > 0) {
                                            foreach($query_run as $pet) {
                                        ?>
                                                <div class="option">
                                                    <input type="radio" name="pet" value="<?=$pet['idpet']?>">
                                                    <label><?=$pet['nome']?></label>
                                                </div>
                                        <?php    
                                            }} 
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="inputBox">
                            <div class="custom-select input__form" id="dataEmissao">
                                <div style="display:flex; align-items: center; justify-content: space-between" onclick="toggleOptions()">
                                    <a href="#" >
                                        Selecione a enfermidade
                                    </a>
                                    <i class="ri-arrow-up-s-fill arrow"></i>
                                </div>

                                <div class="options" style="align-items: left;">
                                    <div class="option">
                                        <?php 
                                        $query = "SELECT idenfermidade, nome FROM enfermidade";
                                        $query_run = mysqli_query($conexao, $query);

                                        if(mysqli_num_rows($query_run) > 0) {
                                            foreach($query_run as $enfermidade) {
                                        ?>
                                                <div class="option">
                                                    <input type="radio" name="enfermidade" value="<?=$enfermidade['idenfermidade']?>">
                                                    <label><?=$enfermidade['nome']?></label>
                                                </div>
                                        <?php    
                                            }} 
                                        ?>
                                    </div>
                                </div>

                            </div>
                            <a href="#" id="doenca">Adicionar nova enfermidade</a>
                        </div>

                        <div class="inputBox">
                            <div class="custom-select_medicamentos input__form" id="dataEmissao">
                                <div style="display:flex; align-items: center; justify-content: space-between" onclick="toggleOptionsMedicamentos()">
                                    <a href="#" >
                                        Selecione o medicamento
                                    </a>
                                    <i class="ri-arrow-up-s-fill arrow"></i>
                                </div>

                                <div class="options" style="align-items: left;">
                                    <div class="option">
                                        <?php 
                                        $query = "SELECT idmedicamento, nome FROM medicamento";
                                        $query_run = mysqli_query($conexao, $query);

                                        if(mysqli_num_rows($query_run) > 0) {
                                            foreach($query_run as $medicamento) {
                                        ?>
                                                <div class="option">
                                                    <input type="radio" name="medicamento" value="<?=$medicamento['idmedicamento']?>">
                                                    <label><?=$medicamento['nome']?></label>
                                                </div>
                                        <?php    
                                            }} 
                                        ?>
                                    </div>
                                </div>

                            </div>
                            <a href="#" id="medicamento">Adicionar novo medicamento</a>
                        </div>

                        <div class="inputBox">
                            <input type="date" name="data_diagnostico" class="input__form valid" required>
                            <span>Data do diagnóstico</span>
                        </div>

                    </div>

                    <div class="textAreaBox">
                        <textarea name="descricao" required></textarea>
                        <span>Descrição</span>
                    </div>

                    <div class="form__btns" id="btnContainer">
                        <div class="botao">
                            <button type="button" onclick="limparCampos()" style="visibility: hidden;" style="color: #fcfcfc;">Limpar</button>
                        </div>
                        
                        <div class="botao">
                            <button type="button" style="visibility: hidden;">Simular</button>
                        </div>
              
                        <div class="botao">
                            <button type="submit" name="enviardiagnostico" style="color: #fcfcfc;">Enviar diagnostico</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="habilidade__modal" id="modal_doenca">
                <div class="habilidade__modal-content">
                    <h4 class="cad__fornecedor-titulo">Cadastrar enfermidade</h4>
                    <i class="ri-close-fill modal_doenca_close"></i>
    
                    <form action="./backend/code.php" method="POST" class="contact__form">
                        <div class="cad__fornecedor-form">
                            <div class="inputBox">
                                <input type="text" name="nome" class="input__form" required>
                                <span>Nome</span>
                            </div>
                        </div>

                        <div class="depoimento__btn botao">
                            <button type="submit" style="background-color: green;" name="cadastrarEnfermidade">Cadastrar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ==================== MODAL MEDICAMENTO ==================== -->
            <div class="habilidade__modal" id="modal_medicamento">
                <div class="habilidade__modal-content">
                    <h4 class="cad__fornecedor-titulo">Cadastrar Medicamento</h4>
                    <i class="ri-close-fill habilidade__modal-close modal_medicamento_close"></i>

                    <form action="./backend/code.php" method="POST" class="contact__form">
                        <div class="cad__fornecedor-form">
                            <div class="inputBox">
                                <input type="text" name="nome" class="input__form" required>
                                <span>Nome</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="fabricante" class="input__form" required>
                                <span>Fabricante</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="dose" class="input__form" required>
                                <span>Dose</span>
                            </div>
                        </div>

                        <div class="depoimento__btn botao">
                            <button type="submit" style="background-color: green;" name="cadastrarmedicamento">Cadastrar</button>
                        </div>
                    </form>
                </div>
            </div>

            <div></div>
            <div></div>
            <div></div>
        </div>
    </section>

    <script src="./assets/js/index.js"></script>

    <script>

        /*=============== MODAL MEDICAMENTO ===============*/

        const medicamento = document.getElementById('medicamento');
        const modal_medicamento = document.getElementById('modal_medicamento');
        const modal_medicamento_close = document.querySelectorAll('.modal_medicamento_close');

        medicamento.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default behavior of the anchor link
            modal_medicamento.classList.add('active-modal');
        });

        // Attach event listeners to modal close buttons
        modal_medicamento_close.forEach(function(modal_medicamento_closex) {
            modal_medicamento_closex.addEventListener('click', function() {
                modal_medicamento.classList.remove('active-modal');
            });
        });


        /*=============== MODAL ===============*/

        const doenca = document.getElementById('doenca');
        const modal_doenca = document.getElementById('modal_doenca');
        const modal_doenca_close = document.querySelectorAll('.modal_doenca_close');
        const doenca_select = document.getElementById('doenca_select');

        doenca.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default behavior of the anchor link
            modal_doenca.classList.add('active-modal');
        });

        // Attach event listeners to modal close buttons
        modal_doenca_close.forEach(function(modal_doenca_closex) {
        modal_doenca_closex.addEventListener('click', function() {
            modal_doenca.classList.remove('active-modal');
            });
        });

        // Optionally, you can listen for changes to the select element
        doenca_select.addEventListener('change', function() {
            if (doenca_select.value === '0') {
                // Reset modal state when the select value is changed to "Escolha"
                modal_doenca.classList.remove('active-modal');
            }
        });



    </script>
</body>
</html>