<?php
require '../backend/dbcon.php';

$query = "SELECT u.bairro, COUNT(d.idenfermidade) AS quantidade 
          FROM diagnostico d
          INNER JOIN pet p ON d.idpet = p.idpet
          INNER JOIN tutor t ON p.idtutor = t.idtutor
          INNER JOIN usuario u ON t.idusuario = u.idusuario
          GROUP BY u.bairro";
$query_run = mysqli_query($conexao, $query);

$bairros = [];
$quantidades = [];

if (mysqli_num_rows($query_run) > 0) {
    while ($row = mysqli_fetch_assoc($query_run)) {
        $bairros[] = $row['bairro'];
        $quantidades[] = $row['quantidade'];
    }
}

// Convert arrays to JSON for use in JavaScript
$bairros_json = json_encode($bairros);
$quantidades_json = json_encode($quantidades);
?>
