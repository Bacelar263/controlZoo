<?php
    require './backend/dbcon.php'; 
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ControlZoo - Dashboard</title>

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
    <link rel="stylesheet" href="./assets/css/dashboard.css">

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
    <section class="home">

        <div class="cards">
            <div class="card-single">
                <div>

                    <span>Agendamentos feitos</span>
                </div>
                <div>
                    <span class="material-icons-sharp">calendar_today</span>
                </div>
            </div>
            <div class="card-single">
                <div>

                    <span>Atendimentos realizados</span>
                </div>
                <div>
                    <span class="material-icons-sharp">person</span>
                </div>
            </div>
            <div class="card-single">
                <div>
                    <span>Clientes novos</span>
                </div>
                <div>
                    <span class="material-icons-sharp">person_add</span>
                </div>
            </div>
            <div class="card-single">
                <div>

                    <span>Ganhos</span>
                </div>
                <div>
                    <span class="material-icons-sharp">attach_money </span>
                </div>
            </div>
        </div>

        <div class="grafico-temp">
            <div class="calendar">
                <div class="calendar-header">
                    <span class="month-picker" id="month-picker"></span>
                    <div class="year-picker">
                        <span class="year-change" id="prev-year">
                            <pre><</pre>
                        </span>
                        <span id="year"></span>
                        <span class="year-change" id="next-year">
                            <pre>></pre>
                        </span>
                    </div>
                </div>
                <div class="calendar-body">
                    <div class="calendar-week-day">
                        <div>Dom</div>
                        <div>Seg</div>
                        <div>Ter</div>
                        <div>Qua</div>
                        <div>Qui</div>
                        <div>Sex</div>
                        <div>Sab</div>
                    </div>
                    <div class="calendar-days"></div>
                </div>
                <div class="month-list"></div>
            </div>

            <!-- MODAL DE CLIENTE -->


            <div class="evento">
                <h1 class="dia-selecionado"></h1>
                <div class="agendados" id="agendadosDiv">
                    
                </div>

                <div class="add-event-wrapper">
                    <div class="add-event-header">
                        <div class="title">Adicionar Agendamento</div>
                        <i class="ri-close-line close" id="close-btn"></i>
                    </div> 
                    <div class="add-event-body">
                    <form action="./backend/code.php" method="post">
                        <div class="add-event-input">
                            <select name="idtutor" id="fornecedorSelect" required>
                                <option value="0">Escolha o tutor</option>
                                <?php 
                                    $query = "SELECT t.idtutor, u.nome FROM tutor t INNER JOIN usuario u ON t.idusuario = u.idusuario WHERE u.tipousuario = 1";
                                    $query_run = mysqli_query($conexao, $query);

                                    if(mysqli_num_rows($query_run) > 0) {   
                                        foreach($query_run as $tutor) {
                                ?>
                                    <option value="<?=$tutor['idtutor']?>"><?=$tutor['nome']?></option>
                                <?php    
                                    }} 
                                ?>
                                <option value="add"><a href="#" id="addFornecedor">Adicionar novo tutor</a></option>
                            </select>
                        </div>

                        <!-- <div class="add-event-input">
                            <input type="text" placeholder="Telefone (opcional)" name="telefone" />
                        </div>

                        <div class="add-event-input">
                            <input type="email" placeholder="Email (opcional)" name="email" />
                        </div> -->

                        <div class="add-event-input">
                            <input type="text" placeholder="Descrição" name="descricao" />
                        </div>

                        <div class="add-event-input">
                            <select name="tipo_servico" required>
                                <option value="0">Escolha o tipo de aviso</option>
                                <option value="1">Visita</option>
                                <option value="2">Retorno</option>
                                <option value="3">Procedimento</option>
                                <option value="4">Outros</option>
                            </select>
                        </div>

                        <div class="add-event-input">
                            <input type="date" name="data" value="<?php echo date('Y-m-d'); ?>" required />
                        </div>

                        <div class="add-event-footer">
                            <button type="submit" name="agendar" class="add-event-btn">Adicionar Agendamento</button>
                        </div>

                    </form>
                    </div>

                    

                </div>
                <button class="add-event">
                    +
                </button>
                <h2></h2>
            </div>
        </div>
        
        <div class="habilidade__modal" id="modal">
                <div class="habilidade__modal-content">
                    <h4 class="cad__fornecedor-titulo">Cadastre o tutor</h4>
                    <i class="ri-close-fill habilidade__modal-close"></i>
    
                    <form action="./backend/code.php" method="POST" class="contact__form">
                        <div class="cad__fornecedor-form">
                            <div class="inputBox">
                                <input type="text" name="nome" class="input__form" required>
                                <span>Nome</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="cpfcnpj" id="cpfcnpj" oninput="handleInput(event)" maxlength="18" class="input__form" required>
                                <span>CPF ou CNPJ</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="email" class="input__form" required>
                                <span>Email</span>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="telefone" id="telefone" class="input__form" required>
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
                                <input type="text" name="uf" class="input__form" id="uf" size="2" required>
                                <span>UF</span>
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
                            <button type="submit" class="btn botao__flex" name="cadastrarTutor">
                                Enviar <i class="ri-arrow-right-line"></i>
                            </button>
                        </div>
                    </form>
                </div>
        </div>

        <div class="graficos">

            <div class="tasks-recentes">
                <h2>Últimos atendimentos feitos</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Serviço</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <div>
                    <a href="#">Ver todo o histórico de atendimentos</a>
                </div>
            </div>

        </div>
        

    </section>

    <!-- ==================== FINAL DA DASHBOARD ==================== -->
    <script src="./assets/js/index.js"></script>

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