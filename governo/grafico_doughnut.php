<?php
require '../backend/dbcon.php';

$query = "SELECT en.nome AS enfermidade, COUNT(d.idenfermidade) AS quantidade 
          FROM enfermidade en 
          LEFT JOIN diagnostico d ON en.idenfermidade = d.idenfermidade 
          GROUP BY en.nome";
$query_run = mysqli_query($conexao, $query);

$enfermidades = [];
$quantidades = [];

if (mysqli_num_rows($query_run) > 0) {
    while ($row = mysqli_fetch_assoc($query_run)) {
        $enfermidades[] = $row['enfermidade'];
        $quantidades[] = $row['quantidade'];
    }
}

// Convert arrays to JSON for use in JavaScript
$enfermidades_json = json_encode($enfermidades);
$quantidades_json = json_encode($quantidades);
?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Puxar os dados do PHP
    var enfermidades = <?php echo $enfermidades_json; ?>;
    var quantidades = <?php echo $quantidades_json; ?>;

    // Gerar cores distintas
    function generateDistinctColors(num) {
        let colors = [];
        for (let i = 0; i < num; i++) {
            let r = Math.floor(Math.random() * 255);
            let g = Math.floor(Math.random() * 255);
            let b = Math.floor(Math.random() * 255);
            colors.push(`rgba(${r}, ${g}, ${b}, 0.2)`);
        }
        return colors;
    }

    var backgroundColors = generateDistinctColors(enfermidades.length);
    var borderColors = backgroundColors.map(color => color.replace('0.2', '1'));

    var ctx = document.getElementById('myDoughnutChart').getContext('2d');
    var myDoughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: enfermidades,
            datasets: [{
                data: quantidades,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
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
