<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $sexo = $_POST['sexo'];
    $telefone = $_POST['telefone'];
    $empresa = $_POST['empresa'];
    
    // Verificar se 'dias_semana' está definido e concatenar os valores
    if (isset($_POST['dias_semana'])) {
        $dias_semana = implode(', ', $_POST['dias_semana']);
    } else {
        $dias_semana = '';
    }

    // Atualizar os dados do promotor na tabela
    $sql = "UPDATE promotores SET nome='$nome', cpf='$cpf', sexo='$sexo', telefone='$telefone', empresa='$empresa', dias_semana='$dias_semana' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        // Se a atualização for bem-sucedida, redireciona para a página de promotores com um pop-up de confirmação
        echo "<script>alert('Cadastro atualizado com sucesso!'); window.location.href = 'promotores.php';</script>";
    } else {
        echo "Erro ao atualizar promotor: " . $conn->error;
    }
}

$conn->close();
?>
