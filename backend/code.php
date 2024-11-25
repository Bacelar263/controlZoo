<?php
session_start();
require 'dbcon.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

if(isset($_POST['agendar'])) {

    // Dados do formulário
    $idtutor = mysqli_real_escape_string($conexao, $_POST['idtutor']);
    $idveterinario = mysqli_real_escape_string($conexao, $_POST['idveterinario']);
    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
    $tipo_servico = mysqli_real_escape_string($conexao, $_POST['tipo_servico']);
    $data = mysqli_real_escape_string($conexao, $_POST['data']);

    $formattedDate = date("d/m/Y", strtotime($_POST['data'])); // Formata o dia

    $query = "INSERT INTO agendamento (idtutor, idveterinario, descricao, tipo_servico, data) VALUES ('$idtutor','teste','$descricao','$tipo_servico','$data')";

    $query_run = mysqli_query($conexao, $query);
    if ($query_run) {
        echo '<script>window.location.href = "../dashboard.php?message=success";</script>';
        $mail->send();  
            exit(0);
    }else {
        echo '<script>window.location.href = ".../dashboard.php?message=erro";</script>';
        exit(0);
    }
        
}


if(isset($_POST['agendarCalendario'])) {

    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $telefone = mysqli_real_escape_string($conexao, $_POST['telefone']);
    $opcao_servicos = mysqli_real_escape_string($conexao, $_POST['opcao_servicos']);
    $dia = mysqli_real_escape_string($conexao, $_POST['dia']);
    $opcao_hora = mysqli_real_escape_string($conexao, $_POST['opcao_hora']);
    $observacao = mysqli_real_escape_string($conexao, $_POST['observacao']);

    if($opcao_servicos == '1') {
            $valor = 30.00;
    } elseif($opcao_servicos == '2') {
        $valor = 15.00;
    } elseif($opcao_servicos == '3') {
        $valor = 40.00;
    }

    $query = "INSERT INTO agendamento (nome, email, telefone, servico, dia, hora, observacao, valor) VALUES ('$nome','$email','$telefone','$opcao_servicos','$dia','$opcao_hora','$observacao','$valor')";

    $query_run = mysqli_query($conexao, $query);
    if($query_run)
    {
        $_SESSION['message'] = "Agendamento feito com sucesso!";
        header("Location: ../calendario.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Erro ao realizar o agendamento!";
        header("Location: ../calendario.php");
        exit(0);
    }
}


if (isset($_GET['selectedDate'])) {
    $selectedDate = $_GET['selectedDate'];

    $sql = "SELECT * FROM agendamento WHERE data = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $selectedDate);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table>"; // Inicia a tabela
        echo "<tr>";
            echo "<th>Veterinário</th>";
            echo "<th>Tutor</th>";
            echo "<th>Descrição</th>";
            echo "<th>Tipo de agendamento</th>";
            echo "<th>Ver mais</th>";
        echo "</tr>";
        
        while ($row = $result->fetch_assoc()) {
            // Obter nome do tutor
            $id_tutor = $row['idtutor'];
            $sql_tutor = "SELECT nome FROM usuario WHERE idusuario = ?";
            $stmt_tutor = $conexao->prepare($sql_tutor);
            $stmt_tutor->bind_param("i", $id_tutor);
            $stmt_tutor->execute();
            $result_tutor = $stmt_tutor->get_result();
            $tutor = $result_tutor->fetch_assoc();

            // Definir tipo de aviso
            switch ($row['tipo_servico']) {
                case 1:
                    $aviso = 'Visita';
                    break;
                case 2:
                    $aviso = 'Retorno';
                    break;
                case 3:
                    $aviso = 'Procedimento';
                    break;
                case 4:
                    $aviso = 'Outros';
                    break;
                default:
                    $aviso = 'Indefinido';
                    break;
            }

            echo "<tr>";
                echo "<td>" . $row['idveterinario'] . "</td>";
                echo "<td>" . $tutor['nome'] . "</td>";
                echo "<td>" . $row['descricao'] . "</td>";
                echo "<td>" . $aviso . "</td>";
                echo "<td> <a href='agendado.php?id=" . $row['idagendamento'] . "'><span class='material-icons-sharp'>visibility</span></a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Nenhum agendamento encontrado para essa data.";
    }
    $stmt->close();
    $conexao->close();
}


if (isset($_GET['date'])) {
    $dia = $_GET['date']; 
    
    $sql = "SELECT * FROM agendamento WHERE dia  = '$dia' AND status = '0'";
    $result = $conexao->query($sql);

    $events = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $events[] = array(
                "id" => $row['id'],
                "title" => $row["nome"],
                "time" => $row["hora"]
            );
        }
    }

    // Retorna os agendamentos como JSON
    header("Content-Type: application/json");
    echo json_encode($events);

    $conexao->close();
}

if(isset($_POST['cadastrarTutor'])) {
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $cpfcnpj = mysqli_real_escape_string($conexao, $_POST['cpfcnpj']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $telefone = mysqli_real_escape_string($conexao, $_POST['telefone']);
    $cep = mysqli_real_escape_string($conexao, $_POST['cep']);
    $rua = mysqli_real_escape_string($conexao, $_POST['rua']);
    $bairro = mysqli_real_escape_string($conexao, $_POST['bairro']);
    $cidade = mysqli_real_escape_string($conexao, $_POST['cidade']);
    $uf = mysqli_real_escape_string($conexao, $_POST['uf']);
    $numero = mysqli_real_escape_string($conexao, $_POST['numero']);
    $complemento = mysqli_real_escape_string($conexao, $_POST['complemento']);
    $tipousuario = 1;

    // Iniciar transação
    mysqli_begin_transaction($conexao);

    try {
        // Inserir dados na tabela usuario
        $query_usuario = "INSERT INTO usuario (nome, email, telefone, cep, rua, bairro, cidade, uf, numero, complemento, tipousuario, datacadastro)
                          VALUES ('$nome','$email','$telefone','$cep','$rua','$bairro','$cidade','$uf','$numero','$complemento', '$tipousuario', NOW())";
        $query_run = mysqli_query($conexao, $query_usuario);

        if(!$query_run) {
            throw new Exception('Erro ao cadastrar usuário.');
        }

        // Pegar o idusuario inserido
        $idusuario = mysqli_insert_id($conexao);

        // Inserir dados na tabela tutor
        $query_tutor = "INSERT INTO tutor (idusuario, cpfcnpj) VALUES ('$idusuario', '$cpfcnpj')";
        $query_run_tutor = mysqli_query($conexao, $query_tutor);

        if(!$query_run_tutor) {
            throw new Exception('Erro ao cadastrar tutor.');
        }

        // Commit da transação
        mysqli_commit($conexao);
        echo '<script>window.location.href = "../dashboard.php?message=ClienteCadastrado";</script>';
        exit(0);
    } catch (Exception $e) {
        // Rollback da transação em caso de erro
        mysqli_rollback($conexao);
        echo '<script>window.location.href = "../dashboard.php?message=ClienteNaoCadastrado";</script>';
        exit(0);
    }
}

if(isset($_POST['atualizar_tutor'])) {

    $idtutor = mysqli_real_escape_string($conexao, $_POST['id_tutor']);
    $idusuario = mysqli_real_escape_string($conexao, $_POST['id_usuario']);

    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $cpfcnpj = mysqli_real_escape_string($conexao, $_POST['cpfcnpj']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $telefone = mysqli_real_escape_string($conexao, $_POST['telefone']);
    $cep = mysqli_real_escape_string($conexao, $_POST['cep']);
    $rua = mysqli_real_escape_string($conexao, $_POST['rua']);
    $bairro = mysqli_real_escape_string($conexao, $_POST['bairro']);
    $cidade = mysqli_real_escape_string($conexao, $_POST['cidade']);
    $uf = mysqli_real_escape_string($conexao, $_POST['uf']);
    $numero = mysqli_real_escape_string($conexao, $_POST['numero']);
    $complemento = mysqli_real_escape_string($conexao, $_POST['complemento']);

    // Atualizar o campo cpfcnpj na tabela tutor
    $query_tutor = "UPDATE tutor SET cpfcnpj='$cpfcnpj' WHERE idtutor='$idtutor'";
    $query_tutor_run = mysqli_query($conexao, $query_tutor);

    // Atualizar os dados na tabela usuario
    $query_usuario = "UPDATE usuario SET nome='$nome', email='$email', telefone='$telefone', cep='$cep', rua='$rua', bairro='$bairro', cidade='$cidade', uf='$uf', numero='$numero', complemento='$complemento' WHERE idusuario='$idusuario'";
    $query_usuario_run = mysqli_query($conexao, $query_usuario);

    if($query_tutor_run && $query_usuario_run)
    {
        $_SESSION['message'] = "Tutor atualizado com sucesso";
        header("Location: ../clientes.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Tutor não foi atualizado";
        header("Location: ../clientes.php");
        exit(0);
    }
}

if(isset($_POST['deletar_cliente'])) {

    $cliente_id = mysqli_real_escape_string($conexao, $_POST['cliente_id']);

    $query = "DELETE FROM cliente WHERE id='$cliente_id' ";
    $query_run = mysqli_query($conexao, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Cliente excluido com sucesso";
        header("Location: ../clientes.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Não foi possivel excluir o Cliente";
        header("Location: ../clientes.php");
        exit(0);
    }
}

if(isset($_POST['cadastrarEspecie'])) {

    $nome = mysqli_real_escape_string($conexao, $_POST['nomeespecie']);

    // Iniciar transação
    mysqli_begin_transaction($conexao);

    try {
        // Inserir dados na tabela usuario
        $query_especie = "INSERT INTO especie (nome) VALUES ('$nome')";
        $query_run = mysqli_query($conexao, $query_especie);

        if(!$query_run) {
            throw new Exception('Erro ao cadastrar espécie.');
        }

        // Commit da transação
        mysqli_commit($conexao);
        echo '<script>window.location.href = "../clientes.php?message=ClienteCadastrado";</script>';
        exit(0);
    } catch (Exception $e) {
        // Rollback da transação em caso de erro
        mysqli_rollback($conexao);
        echo '<script>window.location.href = "../clientes.php?message=ClienteNaoCadastrado";</script>';
        exit(0);
    }
}

if(isset($_POST['cadastrarRaca'])) {

    $nome = mysqli_real_escape_string($conexao, $_POST['nomeRaca']);

    // Iniciar transação
    mysqli_begin_transaction($conexao);

    try {
        // Inserir dados na tabela usuario
        $query_raca = "INSERT INTO raca (nome) VALUES ('$nome')";
        $query_run = mysqli_query($conexao, $query_raca);

        if(!$query_run) {
            throw new Exception('Erro ao cadastrar raça.');
        }

        // Commit da transação
        mysqli_commit($conexao);
        echo '<script>window.location.href = "../clientes.php?message=ClienteCadastrado";</script>';
        exit(0);
    } catch (Exception $e) {
        // Rollback da transação em caso de erro
        mysqli_rollback($conexao);
        echo '<script>window.location.href = "../clientes.php?message=ClienteNaoCadastrado";</script>';
        exit(0);
    }
}

if (isset($_POST['cadastrarPet'])) {

    $idtutor = mysqli_real_escape_string($conexao, $_POST['id_tutor']);
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $especie = mysqli_real_escape_string($conexao, $_POST['especie']);
    $raca = mysqli_real_escape_string($conexao, $_POST['raca']);
    $datanascimento = mysqli_real_escape_string($conexao, $_POST['datanascimento']);
    $sexo = mysqli_real_escape_string($conexao, $_POST['sexo']);
    $cor = mysqli_real_escape_string($conexao, $_POST['cor']);

    // Iniciar transação
    mysqli_begin_transaction($conexao);

    try {
        // Inserir dados na tabela pet
        $query_pet = "INSERT INTO pet (idtutor, nome, idespecie, idraca, datanascimento, sexo, cor) 
                      VALUES ('$idtutor', '$nome', '$especie', '$raca', '$datanascimento', '$sexo', '$cor')";
        $query_run = mysqli_query($conexao, $query_pet);

        if (!$query_run) {
            throw new Exception('Erro ao cadastrar pet.');
        }

        // Commit da transação
        mysqli_commit($conexao);
        echo '<script>window.location.href = "../dashboard.php?message=PetCadastrado";</script>';
        exit(0);
    } catch (Exception $e) {
        // Rollback da transação em caso de erro
        mysqli_rollback($conexao);
        echo '<script>window.location.href = "../dashboard.php?message=PetNaoCadastrado";</script>';
        exit(0);
    }
}

if(isset($_POST['cadastrarEnfermidade'])) {

    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);

    // Iniciar transação
    mysqli_begin_transaction($conexao);

    try {
        // Inserir dados na tabela usuario
        $query_especie = "INSERT INTO enfermidade (nome) VALUES ('$nome')";
        $query_run = mysqli_query($conexao, $query_especie);

        if(!$query_run) {
            throw new Exception('Erro ao cadastrar enfermidade.');
        }

        // Commit da transação
        mysqli_commit($conexao);
        echo '<script>window.location.href = "../diagnostico.php?message=ClienteCadastrado";</script>';
        exit(0);
    } catch (Exception $e) {
        // Rollback da transação em caso de erro
        mysqli_rollback($conexao);
        echo '<script>window.location.href = "../diagnostico.php?message=ClienteNaoCadastrado";</script>';
        exit(0);
    }
}

if(isset($_POST['cadastrarmedicamento'])) {

    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $fabricante = mysqli_real_escape_string($conexao, $_POST['fabricante']);
    $dose = mysqli_real_escape_string($conexao, $_POST['dose']);

    // Iniciar transação
    mysqli_begin_transaction($conexao);

    try {
        // Inserir dados na tabela usuario
        $query_especie = "INSERT INTO medicamento (nome, fabricante, dose) VALUES ('$nome', '$fabricante', '$dose')";
        $query_run = mysqli_query($conexao, $query_especie);

        if(!$query_run) {
            throw new Exception('Erro ao cadastrar medicamento.');
        }

        // Commit da transação
        mysqli_commit($conexao);
        echo '<script>window.location.href = "../diagnostico.php;</script>';
        exit(0);
    } catch (Exception $e) {
        // Rollback da transação em caso de erro
        mysqli_rollback($conexao);
        echo '<script>window.location.href = "../diagnostico.php;</script>';
        exit(0);
    }
}

if (isset($_POST['enviardiagnostico'])) {
    $pet = mysqli_real_escape_string($conexao, $_POST['pet']);
    $enfermidade = mysqli_real_escape_string($conexao, $_POST['enfermidade']);
    $medicamento = mysqli_real_escape_string($conexao, $_POST['medicamento']);
    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
    $datadiagnostico = mysqli_real_escape_string($conexao, $_POST['data_diagnostico']);

    // Iniciar transação
    mysqli_begin_transaction($conexao);

    try {
        // Inserir dados na tabela diagnostico
        $query_diagnostico = "INSERT INTO diagnostico (idpet, idenfermidade, idmedicamento, descricao, datadiagnostico) 
                              VALUES ('$pet', '$enfermidade', '$medicamento', '$descricao', '$datadiagnostico')";
        $query_run = mysqli_query($conexao, $query_diagnostico);

        if (!$query_run) {
            throw new Exception('Erro ao cadastrar diagnóstico.');
        }

        // Commit da transação
        mysqli_commit($conexao);
        echo '<script>window.location.href = "../dashboard.php?message=DiagnosticoCadastrado";</script>';
        exit(0);
    } catch (Exception $e) {
        // Rollback da transação em caso de erro
        mysqli_rollback($conexao);
        echo '<script>window.location.href = "../diagnostico.php?message=DiagnosticoNaoCadastrado";</script>';
        exit(0);
    }
}



?>

