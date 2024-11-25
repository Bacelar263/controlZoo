<?php
    require '../backend/dbcon.php'; 
    include 'grafico_pie.php';
    include 'grafico_doughnut.php';
    include 'grafico_linear.php';
    include 'grafico_bolha.php';
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=pets" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp" rel="stylesheet" />

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
                <?php
                    $query = "SELECT COUNT(*) AS total_diagnosticos FROM diagnostico";
                    $query_run = mysqli_query($conexao, $query);
                    $row = mysqli_fetch_array($query_run);
                    $total_diagnosticos = $row['total_diagnosticos'];
                ?>
                    <h1><?php echo $total_diagnosticos; ?></h1>
                    <span>Diagnósticos feitos</span>
                </div>
                <div>
                    <span class="material-icons-sharp">calendar_today</span>
                </div>
            </div>
            <div class="card-single">
                <div>
                <?php
                    $query = "SELECT COUNT(*) AS total_pets FROM pet";
                    $query_run = mysqli_query($conexao, $query);
                    $row = mysqli_fetch_array($query_run);
                    $total_pets = $row['total_pets'];
                ?>
                    <h1><?php echo $total_pets; ?></h1>
                    <span>Pets cadastrados</span>
                </div>
                <div>
                <span class="material-symbols-outlined">pets</span>
                </div>
            </div>
            <div class="card-single">
                <div>
                <?php
                    $query = "SELECT COUNT(*) AS total_tutores FROM tutor";
                    $query_run = mysqli_query($conexao, $query);
                    $row = mysqli_fetch_array($query_run);
                    $total_tutores = $row['total_tutores'];
                ?>
                    <h1><?php echo $total_tutores; ?></h1>
                    <span>Tutores novos</span>
                </div>
                <div>
                    <span class="material-icons-sharp">person_add</span>
                </div>
            </div>
            <div class="card-single">
                <div>
                <?php
                    $query = "SELECT COUNT(*) AS total_medicamentos FROM medicamento";
                    $query_run = mysqli_query($conexao, $query);
                    $row = mysqli_fetch_array($query_run);
                    $total_medicamentos = $row['total_medicamentos'];
                ?>
                    <h1><?php echo $total_medicamentos; ?></h1>
                    <span>Medicamentos administrados</span>
                </div>
                <div>
                    <span class="material-symbols-sharp">medication</span>
                </div>
            </div>
        </div>

        <div class="grafico-temp">
            <div class="calendar">
                <h2>Espécies dos pets cadastrados</h2>
                <canvas id="myPieChart" class="grafico"></canvas>
            </div>

            <div>
                <h2>Zoonoses dos pets cadastrados</h2>
                <canvas id="myDoughnutChart" class="grafico"></canvas>
            </div>
        </div>

        <div class="grafico-temp">
            <div class="calendar">
                <h2>Zoonoses encontradas ao logo do ano</h2>
                <canvas id="myLineChart" class="grafico_linear"></canvas>
            </div>

            <div>
                <h2>Bairros com Zoonose</h2>
                <canvas id="myBubbleChart" class="grafico_linear"></canvas>
            </div>
        </div>

        <div class="graficos">

            <div class="tasks-recentes">
                <h2>Últimos diagnósticos feitos</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Enfermidade</th>
                            <th>Data</th>
                            <th>Espécie</th>
                            <th>Raça</th>
                            <th>Bairro</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $query = "SELECT en.nome AS enfermidade, d.datadiagnostico AS data, e.nome AS especie, r.nome AS raca, u.bairro AS bairro FROM diagnostico d INNER JOIN pet p ON d.idpet = p.idpet INNER JOIN especie e ON p.idespecie = e.idespecie INNER JOIN raca r ON p.idraca = r.idraca INNER JOIN enfermidade en ON d.idenfermidade = en.idenfermidade INNER JOIN tutor t ON p.idtutor = t.idtutor INNER JOIN usuario u ON t.idusuario = u.idusuario";
                        $query_run = mysqli_query($conexao, $query);

                        if(mysqli_num_rows($query_run) > 0) {
                            foreach($query_run as $diagnostico) {
                    ?>
                        <tr>
                            <td> <?=$diagnostico['enfermidade']?> </td>
                            <td> <?=$diagnostico['data'] ? date('d/m/Y', strtotime($diagnostico['data'])) : ''?></td>
                            <td> <?=$diagnostico['especie']?> </td>
                            <td> <?=$diagnostico['raca']?> </td>                        
                            <td> <?=$diagnostico['bairro']?> </td>
                        </tr>
                                
                    <?php    
                        }} 
                    ?>
                    </tbody>
                </table>
<!--                
                <div>
                    <a href="#">Ver todo o histórico de atendimentos</a>
                </div>
-->
            </div>

        </div>
        

    </section>

    <!-- ==================== FINAL DA DASHBOARD ==================== -->
    <script src="./assets/js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<script>
document.addEventListener("DOMContentLoaded", function() {
    // Puxar os dados do PHP para o gráfico de pizza
    var especies = <?php echo $especies_json; ?>;
    var quantidades = <?php echo $quantidades_json; ?>;

    // Paleta de cores predefinida
    var colors = [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(199, 199, 199, 0.2)',
        'rgba(83, 102, 255, 0.2)',
        'rgba(153, 159, 64, 0.2)',
        'rgba(255, 200, 64, 0.2)'
    ];

    var ctx = document.getElementById('myPieChart').getContext('2d');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: especies,
            datasets: [{
                data: quantidades,
                backgroundColor: colors.slice(0, especies.length),
                borderColor: colors.slice(0, especies.length).map(color => color.replace('0.2', '1')),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed !== null) {
                                label += context.parsed;
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
});
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Puxar os dados do PHP
        var enfermidades = <?php echo $enfermidades_json; ?>;
        var quantidades = <?php echo $quantidades_json; ?>;

        var ctx = document.getElementById('myDoughnutChart').getContext('2d');
        var myDoughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: enfermidades,
                datasets: [{
                    data: quantidades,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    label += context.parsed;
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    });
    </script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Puxar os dados do PHP
        var dados = <?php echo $dados_json; ?>;

        var meses = Object.keys(dados);
        var enfermidades = [];
        var datasets = [];

        // Obter todas as enfermidades únicas
        meses.forEach(function(mes) {
            Object.keys(dados[mes]).forEach(function(enfermidade) {
                if (!enfermidades.includes(enfermidade)) {
                    enfermidades.push(enfermidade);
                }
            });
        });

        // Criar datasets para cada enfermidade
        enfermidades.forEach(function(enfermidade) {
            var data = [];
            meses.forEach(function(mes) {
                if (dados[mes][enfermidade] !== undefined) {
                    data.push(dados[mes][enfermidade]);
                } else {
                    data.push(0);
                }
            });
            datasets.push({
                label: enfermidade,
                data: data,
                fill: false,
                borderColor: 'rgba(' + Math.floor(Math.random() * 255) + ',' + Math.floor(Math.random() * 255) + ',' + Math.floor(Math.random() * 255) + ',1)',
                tension: 0.1
            });
        });

        var ctx = document.getElementById('myLineChart').getContext('2d');
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: meses,
                datasets: datasets
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMin: 0,
                        suggestedMax: Math.max(...datasets.map(dataset => Math.max(...dataset.data))) + 5
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    label += context.parsed;
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    });
    </script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Puxar os dados do PHP
        var bairros = <?php echo $bairros_json; ?>;
        var quantidades = <?php echo $quantidades_json; ?>;
        
        // Preparar os dados para o gráfico Bubble
        var bubbleData = bairros.map((bairro, index) => {
            return {
                x: index + 1, // Usar o índice como x (pode ser qualquer valor)
                y: quantidades[index], // Usar a quantidade como y
                r: quantidades[index] * 2 // Ajustar o tamanho da bolha
            };
        });

        var ctx = document.getElementById('myBubbleChart').getContext('2d');
        var myBubbleChart = new Chart(ctx, {
            type: 'bubble',
            data: {
                datasets: [{
                    label: 'Enfermidades por Bairro',
                    data: bubbleData,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Bairros'
                        },
                        ticks: {
                            callback: function(value, index) {
                                return bairros[index]; // Mostrar o nome do bairro no eixo x
                            }
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Quantidade de Enfermidades'
                        },
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.raw !== null) {
                                    label += `Bairro: ${bairros[context.dataIndex]}, Enfermidades: ${context.raw.y}`;
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    });
    </script>

  </body>
</html>
