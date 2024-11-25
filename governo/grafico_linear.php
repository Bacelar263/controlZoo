<?php
require '../backend/dbcon.php';

$query = "SELECT MONTH(datadiagnostico) AS mes, en.nome AS enfermidade, COUNT(d.idenfermidade) AS quantidade
          FROM diagnostico d
          INNER JOIN enfermidade en ON d.idenfermidade = en.idenfermidade
          GROUP BY MONTH(datadiagnostico), en.nome";
$query_run = mysqli_query($conexao, $query);

$dados = [];
$nomesMeses = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

if (mysqli_num_rows($query_run) > 0) {
    while ($row = mysqli_fetch_assoc($query_run)) {
        $mes = $nomesMeses[$row['mes'] - 1];
        $enfermidade = $row['enfermidade'];
        $quantidade = $row['quantidade'];

        if (!isset($dados[$mes])) {
            $dados[$mes] = [];
        }
        $dados[$mes][$enfermidade] = $quantidade;
    }
}

// Convert array to JSON for use in JavaScript
$dados_json = json_encode($dados);
?>
