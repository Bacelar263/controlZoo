<?php
    require './backend/dbcon.php'; 
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ControlZoo - Clientes</title>

    <!-- Importando ícones do google -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Importando ícones do boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>

    <!-- =================== REMIXICONS =================== -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">

    <!-- Importando arquivo css -->
    <link rel="stylesheet" href="./assets/css/base.css">
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
                <a href="clientes.php">
                    <span class="material-icons-sharp">person</span>
                    <span class="title">Clientes</span>
                </a>
                <span class="tooltip">Clientes</span>
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

    <main class="custom-table" id="customers_table">
        <section class="table__header">
            <h1>Lista de clientes</h1>
            <div class="input-group">
                <input type="search" placeholder="Procurar cliente...">
                <span class="material-icons-sharp">search</span>
            </div>
            <div class="export__file">
            </div>
        </section>
        <section class="table__body">
            <table class="tabela_clientes">
                <thead>
                    <tr>
                        <th> Id <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Cliente <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Telefone <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Data do cadastro <span class="icon-arrow">&UpArrow;</span></th>
                        <th> E-mail <span class="icon-arrow">&UpArrow;</span></th>
                        <th> CPF <span class="icon-arrow">&UpArrow;</span></th>
                        <th style="pointer-events: none;"> Ver detalhes </th>
                    </tr>
                </thead>
                <tbody> 
                <?php 
                    $query = "SELECT t.*, u.* FROM tutor t INNER JOIN usuario u ON t.idusuario = u.idusuario WHERE u.tipousuario = 1";
                    $query_run = mysqli_query($conexao, $query);

                    if(mysqli_num_rows($query_run) > 0) {
                        foreach($query_run as $cliente) {
                ?>

                    <tr>
                        <td> <?=$cliente['idtutor']?> </td>
                        <td> <?=$cliente['nome']?> </td>
                        <td> <?=$cliente['telefone']?> </td>
                        <td> <?=$cliente['datacadastro'] ? date('d/m/Y H:i:s', strtotime($cliente['datacadastro'])) : ''?></td>
                        <td> <?=$cliente['email']?> </td>
                        <td> <?=$cliente['cpfcnpj']?> </td>
                        <td> <a href="cliente.php?id=<?=$cliente['idtutor']?>"><span class="material-icons-sharp">visibility</span></a> </td>
                    </tr>

                <?php    
                    }} 
                ?>
                </tbody>
            </table>
        </section>
    </main>
        

    </section>

    <!-- ==================== FINAL DA DASHBOARD ==================== -->
    <script src="./assets/js/cliente.js"></script>

  </body>
</html> 