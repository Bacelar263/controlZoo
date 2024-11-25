<?php

    require 'dbcon.php'; 

    if (isset($_GET['selectedDate'])) {
        $selectedDate = $_GET['selectedDate'];
    
        $sql = "SELECT * FROM agendamento WHERE dia = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $selectedDate);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Verifica se as chaves estão definidas antes de acessá-las
                $campo1 = isset($row["nome"]) ? $row["nome"] : "Valor não definido";
                $campo2 = isset($row["hora"]) ? $row["hora"] : "Valor não definido";
                echo "Agendamento encontrado: " . $campo1 . " - " . $campo2;
            }
        } else {
            echo "Nenhum agendamento encontrado para essa data.";
        }
    
        $stmt->close();
    }
    
    $conexao->close();
?>