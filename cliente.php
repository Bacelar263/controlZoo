<?php
    session_start();
    require './backend/dbcon.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ControlZoo - tutor</title>

    <!-- =================== REMIXICONS =================== -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">

    <!-- Importando ícones do google -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=add" />

    <!-- Importando ícones do boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>

    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">

    <!-- Importando arquivo css -->
    <link rel="stylesheet" href="./assets/css/base.css">
    <link rel="stylesheet" href="./assets/css/cliente.css">
    <link rel="stylesheet" href="./assets/css/clientes.css">

  </head>

  <body>

    <!-- ==================== INÍCIO DA SIDEBAR ==================== -->

    <section class="sidebar">
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
            <a href="tutors.php">
                <span class="material-icons-sharp">person</span>
                <span class="title">tutors</span>
            </a>
            <span class="tooltip">tutors</span>
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

    <section class="home">
        <div class="container">
            <?php
                if(isset($_GET['id']))
                {
                    $tutor_id = mysqli_real_escape_string($conexao, $_GET['id']);
                    $query = "SELECT t.*, u.* FROM tutor t INNER JOIN usuario u ON t.idusuario = u.idusuario WHERE idtutor='$tutor_id' ";
                    $query_run = mysqli_query($conexao, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        $tutor = mysqli_fetch_array($query_run);
            ?>
            <div>
                <h1 class="home__titulo">tutor <?=$tutor['nome']?></h1>
            </div>

            <div>

            <form action="./backend/code.php" method="post">
                <input type="text" name="id_tutor" style="visibility: hidden;" value="<?=$tutor['idtutor']?>">
                <input type="text" name="id_usuario" style="visibility: hidden;" value="<?=$tutor['idusuario']?>">
                    <div class="container__form-notas">

                        <div class="inputBox">
                            <input type="text" name="nome" class="input__form" value="<?=$tutor['nome']?>">
                            <span>Nome  </span>
                        </div>

                        <div class="inputBox">
                            <input type="text" name="cpfcnpj" id="cpfcnpj" oninput="handleInput(event)" class="input__form" value="<?=$tutor['cpfcnpj']?>">
                            <span>CPF</span>
                        </div>

                        <div class="inputBox">
                            <input type="text" name="email" id="email" class="input__form" value="<?=$tutor['email']?>">
                            <span>E-mail</span>
                        </div>

                        <div class="inputBox">
                            <input type="text" name="telefone" id="telefone" class="input__form" value="<?=$tutor['telefone']?>">
                            <span>Telefone</span>
                        </div>

                        <div class="inputBox">
                            <input type="text" id="cep" name="cep" maxlength="9" class="input__form" value="<?= $tutor['cep']?>" onblur="pesquisacep(this.value);">
                            <span>CEP</span>
                        </div>

                        <div class="inputBox">
                            <input type="text" id="rua" name="rua" class="input__form" value="<?= $tutor['rua']?>">
                            <span>Rua</span>
                        </div>

                        <div class="inputBox">
                            <input type="text" id="bairro" name="bairro" class="input__form" value="<?= $tutor['bairro']?>">
                            <span>Bairro</span>
                        </div>

                        <div class="inputBox">
                            <input type="text" id="cidade" name="cidade" class="input__form" value="<?= $tutor['cidade']?>">
                            <span>Cidade</span>
                        </div>

                        <div class="inputBox">
                            <input type="text" id="uf" name="uf" class="input__form" value="<?= $tutor['uf']?>">
                            <span>UF</span>
                        </div>

                        <div class="inputBox">
                            <input type="text" name="numero" class="input__form" value="<?= $tutor['numero']?>">
                            <span>Número</span>
                        </div>

                        <div class="inputBox">
                            <input type="text" name="complemento" class="input__form" value="<?= $tutor['complemento']?>">
                            <span>Complemento</span>
                        </div>

                    </div>

                    <div class="form__btns" id="btnContainer">
                        <div class="botao">
                            <button type="submit" style="background-color: var(--cor-alerta);" name="atualizar_tutor">Atualizar</button>
                        </div>
                        <div class="botao">
                            <button type="submit" style="background-color: var(--cor-perigo);" name="deletar_tutor" value="<?=$tutor['idtutor']?>">Deletar</button>
                        </div>
                    </div> 
                </form>
            </div>

            <?php
                } else {
                    echo "<h4>tutor não encontrado</h4>";
                }
            }
            ?>

            <div></div>
            <div></div>
            <div></div>
            <div>
                <h1 class="home__titulo">Seus pets <a href="#" id="pet"><span class="material-symbols-sharp">add</span></a></h1>
            </div>

            <!-- ==================== MODAL PET ==================== -->
            <div class="habilidade__modal" id="modal_pet">
                <div class="habilidade__modal-content">
                    <h4 class="cad__fornecedor-titulo">Cadastre o pet</h4>
                    <i class="ri-close-fill habilidade__modal-close modal_pet_close"></i>
                    <?php
                        if(isset($_GET['id']))
                        {
                            $tutor_id = mysqli_real_escape_string($conexao, $_GET['id']);
                    ?>

                    <form action="./backend/code.php" method="POST" class="contact__form">
                        <input type="text" name="id_tutor" style="visibility: hidden;" value="<?=$tutor['idtutor']?>">
                        <div class="cad__fornecedor-form">
                            <div class="inputBox">
                                <input type="text" name="nome" class="input__form" required>
                                <span>Nome</span>
                            </div>

                            <div class="inputBox">
                                <div class="custom-select input__form" id="dataEmissao">
                                    <div style="display:flex; align-items: left; justify-content: space-between" onclick="toggleOptions()">
                                        <a href="#">
                                            Selecione a espécie
                                        </a>
                                        <i class="ri-arrow-up-s-fill arrow"></i>
                                    </div>

                                    <div class="options" style="align-items: left;">
                                        <div class="option">
                                            <?php 
                                            $query = "SELECT idespecie, nome FROM especie";
                                            $query_run = mysqli_query($conexao, $query);

                                            if(mysqli_num_rows($query_run) > 0) {
                                                foreach($query_run as $especie) {
                                            ?>
                                                    <div class="option">
                                                        <input type="radio" name="especie" value="<?=$especie['idespecie']?>">
                                                        <label><?=$especie['nome']?></label>
                                                    </div>
                                            <?php    
                                                }} 
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <a href="#" id="especie">Adicionar nova espécie</a>
                            </div>

                            <div class="inputBox">
                                <div class="custom-select_especie input__form" id="dataEmissao">
                                    <div style="display:flex; align-items: left; justify-content: space-between" onclick="toggleOptionsEspecie()">
                                        <a href="#">
                                            Selecione a raça
                                        </a>
                                        <i class="ri-arrow-up-s-fill arrow"></i>
                                    </div>

                                    <div class="options" style="align-items: left;">
                                        <div class="option">
                                            <?php 
                                            $query = "SELECT idraca, nome FROM raca";
                                            $query_run = mysqli_query($conexao, $query);

                                            if(mysqli_num_rows($query_run) > 0) {
                                                foreach($query_run as $raca) {
                                            ?>
                                                    <div class="option">
                                                        <input type="radio" name="raca" value="<?=$raca['idraca']?>">
                                                        <label><?=$raca['nome']?></label>
                                                    </div>
                                            <?php    
                                                }} 
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <a href="#" id="raca">Adicionar nova raça</a>
                            </div>

                            <div class="inputBox">
                                <input type="date" name="datanascimento" id="datanascimento" class="input__form valid" required>
                                <span>Data de nascimento</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="sexo" class="input__form" id="sexo" required>
                                <span>Sexo</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="cor" class="input__form" id="cor" required>
                                <span>Cor</span>
                            </div>
                        </div>

                        <div class="depoimento__btn botao">
                            <button type="submit" class="btn botao__flex" style="background-color: var(--cor-sucesso);" name="cadastrarPet">
                                Enviar <i class="ri-arrow-right-line"></i>
                            </button>
                        </div>
                    </form>

                    <?php
                        } else {
                            echo "<h4>tutor não encontrado</h4>";
                        }
                    ?>

                    <!-- ==================== MODAL ESPÉCIE ==================== -->
                    <div class="habilidade__modal" id="modal_especie">
                        <div class="habilidade__modal-content">
                            <h4 class="cad__fornecedor-titulo">Cadastrar espécie</h4>
                            <i class="ri-close-fill habilidade__modal-close modal_especie_close"></i>

                            <form action="./backend/code.php" method="POST" class="contact__form">
                                <div class="cad__fornecedor-form">
                                    <div class="inputBox">
                                        <input type="text" name="nomeespecie" class="input__form" required>
                                        <span>Nome</span>
                                    </div>
                                </div>

                                <div class="depoimento__btn botao">
                                    <button type="submit" style="background-color: green;" name="cadastrarEspecie">Cadastrar</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- ==================== MODAL RAÇA ==================== -->
                    <div class="habilidade__modal" id="modal_raca">
                        <div class="habilidade__modal-content">
                            <h4 class="cad__fornecedor-titulo">Cadastrar raça</h4>
                            <i class="ri-close-fill habilidade__modal-close modal_raca_close"></i>

                            <form action="./backend/code.php" method="POST" class="contact__form">
                                <div class="cad__fornecedor-form">
                                    <div class="inputBox">
                                        <input type="text" name="nomeRaca" class="input__form" required>
                                        <span>Nome</span>
                                    </div>
                                </div>

                                <div class="depoimento__btn botao">
                                    <button type="submit" style="background-color: green;" name="cadastrarRaca">Cadastrar</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>


            <section class="table__body">
            <table class="tabela_clientes">
                <thead>
                    <tr>
                        <th> Id <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Nome <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Cor <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Data de nascimento <span class="icon-arrow">&UpArrow;</span></th>
                        <th> sexo <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Espécie <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Raça <span class="icon-arrow">&UpArrow;</span></th>
                        <th style="pointer-events: none;"> Ver detalhes </th>
                    </tr>
                </thead>
                <tbody> 
                <?php 
                    $query = "SELECT p.*, e.nome nome_especie, r.nome nome_raca FROM pet p INNER JOIN especie e ON p.idespecie = e.idespecie INNER JOIN raca r ON p.idraca = r.idraca";
                    $query_run = mysqli_query($conexao, $query);

                    if(mysqli_num_rows($query_run) > 0) {
                        foreach($query_run as $pet) {
                ?>

                    <tr>
                        <td> <?=$pet['idpet']?> </td>
                        <td> <?=$pet['nome']?> </td>
                        <td> <?=$pet['cor']?> </td>
                        <td> <?=$pet['datanascimento'] ? date('d/m/Y', strtotime($pet['datanascimento'])) : ''?></td>
                        <td> <?=$pet['cor']?> </td>
                        <td> <?=$pet['nome_especie']?> </td>
                        <td> <?=$pet['nome_raca']?> </td>
                        <td> <a href="pet.php?id=<?=$pet['idpet']?>"><span class="material-icons-sharp">visibility</span></a> </td>
                    </tr>

                <?php    
                    }} 
                ?>
                </tbody>
            </table>
        </section>
            
        </div>
    </section>
    <!-- ==================== FINAL DA DASHBOARD ==================== -->
    <script src="./assets/js/index.js"></script>

    <script>
/*=============== MODAL ===============*/

const especie = document.getElementById('especie');
const modal_especie = document.getElementById('modal_especie');
const modal_especie_close = document.querySelectorAll('.modal_especie_close');
const especie_select = document.getElementById('especie_select');

const pet = document.getElementById('pet');
const modal_pet = document.getElementById('modal_pet');
const modal_pet_close = document.querySelectorAll('.modal_pet_close');
const pet_select = document.getElementById('pet_select');

const raca = document.getElementById('raca');
const modal_raca = document.getElementById('modal_raca');
const modal_raca_close = document.querySelectorAll('.modal_raca_close');
const raca_select = document.getElementById('raca_select');

especie.addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default behavior of the anchor link
    modal_especie.classList.add('active-modal');
});

pet.addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default behavior of the anchor link
    modal_pet.classList.add('active-modal');
});

raca.addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default behavior of the anchor link
    modal_raca.classList.add('active-modal');
});

// Attach event listeners to modal close buttons
modal_especie_close.forEach(function(modal_especie_closex) {
    modal_especie_closex.addEventListener('click', function() {
        modal_especie.classList.remove('active-modal');
    });
});

modal_pet_close.forEach(function(modal_pet_closex) {
    modal_pet_closex.addEventListener('click', function() {
        modal_pet.classList.remove('active-modal');
    });
});

modal_raca_close.forEach(function(modal_raca_closex) {
    modal_raca_closex.addEventListener('click', function() {
        modal_raca.classList.remove('active-modal');
    });
});

// Optionally, you can listen for changes to the select elements
especie_select.addEventListener('change', function() {
    if (especie_select.value === '0') {
        // Reset modal state when the select value is changed to "Escolha"
        modal_especie.classList.remove('active-modal');
    }
});

pet_select.addEventListener('change', function() {
    if (pet_select.value === '0') {
        // Reset modal state when the select value is changed to "Escolha"
        modal_pet.classList.remove('active-modal');
    }
});

raca_select.addEventListener('change', function() {
    if (raca_select.value === '0') {
        // Reset modal state when the select value is changed to "Escolha"
        modal_raca.classList.remove('active-modal');
    }
});


    </script>

    <script>
        function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('uf').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('rua').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
        
    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('rua').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('uf').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

                console.log(script)

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
        $(document).ready(function(){
                // Máscara para telefone
                $('#telefone').mask('(00) 00000-0000');

                // Máscara para CEP
                $('#cep').mask('00000-000');
    });
    </script>

    <script>
            function maskCPF_CNPJ(input) {
                let value = input.value.replace(/\D/g, '');
                let mask;

                if (value.length <= 11) {
                    mask = '###.###.###-##';
                } else {
                    mask = '##.###.###/####-##';
                }

                let maskedValue = '';
                let j = 0;

                for (let i = 0; i < mask.length; i++) {
                    if (mask[i] === '#') {
                        if (value[j] !== undefined) {
                            maskedValue += value[j];
                            j++;
                        } else {
                            break;
                        }
                    } else {
                        maskedValue += mask[i];
                    }
                }

                input.value = maskedValue;
            }

            function handleInput(event) {
                const input = event.target;
                maskCPF_CNPJ(input);
            }
    </script>
  </body>
</html>