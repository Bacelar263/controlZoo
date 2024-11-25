<?php
require '../backend/dbcon.php';

$query = "SELECT e.nome AS especie, COUNT(p.idespecie) AS quantidade 
          FROM especie e 
          LEFT JOIN pet p ON e.idespecie = p.idespecie 
          GROUP BY e.nome";
$query_run = mysqli_query($conexao, $query);

$especies = [];
$quantidades = [];

if (mysqli_num_rows($query_run) > 0) {
    while ($row = mysqli_fetch_assoc($query_run)) {
        $especies[] = $row['especie'];
        $quantidades[] = $row['quantidade'];
    }
}

// Convert arrays to JSON for use in JavaScript
$especies_json = json_encode($especies);
$quantidades_json = json_encode($quantidades);
?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Puxar os dados do PHP
    var especies = <?php echo $especies_json; ?>;
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

    var backgroundColors = generateDistinctColors(especies.length);
    var borderColors = backgroundColors.map(color => color.replace('0.2', '1'));

    var ctx = document.getElementById('myPieChart').getContext('2d');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: especies,
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
