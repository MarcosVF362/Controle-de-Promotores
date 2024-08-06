<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $sexo = $_POST['sexo'];
    $setor = $_POST['setor'];

    // Atualizar os dados do responsável na tabela
    $sql = "UPDATE responsaveis SET nome='$nome', cpf='$cpf', sexo='$sexo', setor='$setor' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        // Se a atualização for bem-sucedida, redireciona para a página de responsáveis com um pop-up de confirmação
        echo "<script>alert('Cadastro atualizado com sucesso!'); window.location.href = 'responsaveis.php';</script>";
    } else {
        echo "Erro ao atualizar responsável: " . $conn->error;
    }
}

$conn->close();
?>
