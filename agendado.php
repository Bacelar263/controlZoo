<?php
    require './backend/dbcon.php'; 
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ControlZoo - Alterar agendamento</title>

    <!-- =================== REMIXICONS =================== -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">

    <!-- Importando ícones do google -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">

    <!-- Importando ícones do boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>

    <!-- Importando arquivo css -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/style1.css">

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
                <a href="calendario.php">
                    <span class="material-icons-sharp">calendar_today</span>
                    <span class="title">Calendário</span>
                </a>
                <span class="tooltip">Calendário</span>
            </li>
            <li>
                <a href="clientes.html">
                    <span class="material-icons-sharp">person</span>
                    <span class="title">Clientes</span>
                </a>
                <span class="tooltip">Clientes</span>
            </li>
            <li>
                <a href="historico.html">
                    <span class="material-icons-sharp">history</span>
                    <span class="title">Histórico</span>
                </a>
                <span class="tooltip">Histórico</span>
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
                    $cliente_id = mysqli_real_escape_string($conexao, $_GET['id']);
                    $query = "SELECT agendamento.*, cliente.id, cliente.nome FROM agendamento LEFT JOIN cliente ON agendamento.id_cliente = cliente.id WHERE agendamento.id='$cliente_id' ";
                    $query_run = mysqli_query($conexao, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        $cliente = mysqli_fetch_array($query_run);
            ?>  
            <div>
                <h3 class="home__titulo">
                    <?=$cliente['nome'] ? explode(' ', $cliente['nome'])[0] : ''?> 
                    - Agendado para o dia <?=$cliente['data'] ? date('d/m/Y', strtotime($cliente['data'])) : ''?> 
                </h3>
            </div>

            <div>
                <form action="./backend/code.php" method="POST">
                    <input type="hidden" name="id_cliente" value="<?= $_GET['id'] ?>">
                    <div class="container__form">
                        <div class="inputBox">
                            <select class="input__form" id="fornecedorSelect" name="cliente">
                            <?php 
                                $query = "SELECT id, nome FROM cliente";
                                $query_run = mysqli_query($conexao, $query);

                                if(mysqli_num_rows($query_run) > 0) {
                                    foreach($query_run as $cliente_option) {
                            ?>
                                <option value="<?=$cliente_option['id']?>" <?php echo ($cliente_option['id'] == $cliente['id_cliente']) ? 'selected' : ''; ?>>
                                    <?=$cliente_option['nome']?>
                                </option>
                            <?php    
                                }} 
                            ?>
                            <option value="add"><a href="#" id="addFornecedor">Adicionar novo cliente</a></option>

                            </select>
                            <span>Nome do cliente</span>
                        </div>

                        <div class="inputBox">
                            <select class="input__form" id="tipo_aviso" name="tipo_aviso">
                                <?php
                                    if($cliente['tipo_aviso'] == 1) {
                                ?>  
                                    <option value="1" selected>Cobrança</option>
                                    <option value="2">Reagendado</option>
                                    <option value="3">Pago</option>
                                    <option value="4">Outros</option>
                                <?php
                                    } elseif($cliente['tipo_aviso'] == 2) {
                                ?> 
                                    <option value="1">Cobrança</option>
                                    <option value="2" selected>Reagendado</option>
                                    <option value="3">Pago</option>
                                    <option value="4">Outros</option>
                                <?php
                                    } elseif($cliente['tipo_aviso'] == 3) {
                                ?>
                                    <option value="1">Cobrança</option>
                                    <option value="2">Reagendado</option>
                                    <option value="3" selected>Pago</option>
                                    <option value="4">Outros</option>
                                <?php
                                    } elseif($cliente['tipo_aviso'] == 4) {
                                ?>
                                    <option value="1">Cobrança</option>
                                    <option value="2">Reagendado</option>
                                    <option value="3">Pago</option>
                                    <option value="4" selected>Outros</option>
                                <?php
                                    } 
                                ?>  
                            </select>
                            <span>Qual o serviço?</span>
                        </div>

                        <div class="inputBox">
                            <input type="date" class="input__form" name="data" value="<?=$cliente['data'];?>" />
                            <span>Data do serviço</span>
                        </div>

                    </div>

                    <div class="textAreaBox">
                        <textarea name="descricao" id="descricao" cols="15" rows="10"><?=$cliente['descricao'];?></textarea>
                        <span>Observação do serviço</span>
                    </div>

                    <div class="form__btns" id="btnContainer">
                        <div class="botao">
                            <button type="submit" name="deletar_cliente" style="color:white;">Excluir</button>
                        </div>
                        
                        <div class="botao">
                            <button type="submit" name="atualizar_cliente" style="background-color:green; color:white;">Atualizar</button>
                        </div>
                    </div>
                </form>
            </div>

            <?php
                } else {   
                    echo "<h4>Nenhum ID encontrado</h4>";
                }}
            ?>

        <div class="habilidade__modal" id="modal">
                <div class="habilidade__modal-content">
                    <h4 class="cad__fornecedor-titulo">Cadastre o cliente</h4>
                    <i class="ri-close-fill habilidade__modal-close"></i>
    
                    <form action="./backend/code.php" method="POST" class="contact__form">
                        <div class="cad__fornecedor-form">
                            <div class="inputBox">
                                <input type="text" name="nome" class="input__form" required>
                                <span>Nome</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="CPFCNPJ" class="input__form" required>
                                <span>CPF ou CNPJ</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="email" class="input__form" required>
                                <span>Email</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="telefone" class="input__form" required>
                                <span>Telefone</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="cep" class="input__form" id="cep" size="10" maxlength="9" onblur="pesquisacep(this.value);">
                                <span>CEP</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="rua" class="input__form" id="rua" required>
                                <span>Rua</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="bairro" class="input__form" id="bairro" required>
                                <span>Bairro</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="cidade" class="input__form" id="cidade" required>
                                <span>Cidade</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="estado" class="input__form" id="uf" size="2" required>
                                <span>Estado</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="numero" class="input__form" id="numero" required>
                                <span>Número</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="complemento" class="input__form">
                                <span>Complemento</span>
                            </div>
                        </div>

                        <div class="depoimento__btn">
                            <button type="submit" class="btn botao__flex" name="cadastrarCliente">
                                Enviar <i class="ri-arrow-right-line"></i>
                            </button>
                        </div>
                    </form>
                </div>
        </div>

            <div></div>
            <div></div>
            <div></div>
        </div>
    </section>
    <!-- ==================== FINAL DA DASHBOARD ==================== -->
    <!-- <script src="./assets/js/index.js"></script> -->



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>

    <script>
        const modal = document.getElementById('modal');
        const modalCloses = document.querySelectorAll('.habilidade__modal-close');
        const fornecedorSelect = document.getElementById('fornecedorSelect');

        // Função para exibir o modal
        function exibirModal() {
            modal.classList.add('active-modal');
        }

        // Função para fechar o modal
        function fecharModal() {
            modal.classList.remove('active-modal');
        }

        // Ouvinte de mudança no elemento select
        fornecedorSelect.addEventListener('change', function() {
            // Verificar se a opção selecionada é "add"
            if (fornecedorSelect.value === 'add') {
                exibirModal();
            } else {
                fecharModal();
            }
        });

        // Anexar ouvintes de eventos aos botões de fechar o modal
        modalCloses.forEach(function(modalClose) {
            modalClose.addEventListener('click', fecharModal);
        });


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

  </body>
</html>