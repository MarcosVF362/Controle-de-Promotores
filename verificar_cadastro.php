<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cpf = $_POST['cpf'];

    // Verifica se o CPF já está cadastrado no banco de dados
    $sql = "SELECT * FROM promotores WHERE cpf = '$cpf'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Promotor já cadastrado
        echo "Promotor já cadastrado.";
    } else {
        // Promotor não cadastrado, pode prosseguir com o cadastro
        $nome = $_POST['nome'];
        $sexo = $_POST['sexo'];
        $empresa = $_POST['empresa'];
        $telefone = $_POST ['telefone'];

        // Verificar se 'dias_semana' está definido e concatenar os valores
        if (isset($_POST['dias_semana'])) {
            $dias_semana = implode(', ', $_POST['dias_semana']);
        } else {
            $dias_semana = '';
        }

        // Inserir os dados do promotor na tabela
        $sql_insert = "INSERT INTO promotores (nome, cpf, sexo, empresa, dias_semana, telefone) VALUES ('$nome', '$cpf', '$sexo', '$empresa', '$dias_semana','$telefone')";
        if ($conn->query($sql_insert) === TRUE) {
            echo "Promotor cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar promotor: " . $conn->error;
        }
    }
} else {
    echo "Método inválido. Esta página aceita apenas solicitações POST.";
}

$conn->close();
?>
