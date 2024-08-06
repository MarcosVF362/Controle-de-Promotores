<?php
date_default_timezone_set('America/Sao_Paulo'); // Definindo o fuso horário para o Brasil

include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o ID do promotor e o responsável pela entrada estão definidos
    if (isset($_POST['id']) && isset($_POST['responsavel_entrada'])) {
        $promotor_id = $_POST['id'];
        $responsavel_entrada = $_POST['responsavel_entrada'];

        // Capturar a data e hora atual no formato desejado (ano-mês-dia hora:minuto:segundo)
        $data_entrada = date("Y-m-d H:i:s");

        // Atualizar a consulta SQL para registrar a data e hora de entrada, além do responsável pela entrada
        $sql = "INSERT INTO entradas (promotor_id, data, hora_entrada, responsavel_entrada) VALUES ('$promotor_id', '$data_entrada', '$data_entrada', '$responsavel_entrada')";

        if ($conn->query($sql) === TRUE) {
            echo "Entrada registrada com sucesso!";
        } else {
            echo "Erro ao registrar entrada: " . $conn->error;
        }
    } else {
        echo "Erro: ID do promotor ou responsável pela entrada não foram fornecidos.";
    }
} else {
    echo "Método de solicitação inválido.";
}

$conn->close();
?>
