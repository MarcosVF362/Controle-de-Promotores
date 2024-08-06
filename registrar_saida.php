<?php
date_default_timezone_set('America/Sao_Paulo'); // Definindo o fuso horário para o Brasil

include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o ID do promotor e o responsável pela saída estão definidos
    if (isset($_POST['id']) && isset($_POST['responsavel_saida'])) {
        $promotor_id = $_POST['id'];
        $responsavel_saida = $_POST['responsavel_saida'];

        // Capturar a hora atual no formato desejado (hora:minuto)
        $hora_saida = date("H:i");

        // Atualizar a consulta SQL para registrar a hora de saída e o responsável pela saída
        $sql = "UPDATE entradas SET hora_saida = '$hora_saida', responsavel_saida = '$responsavel_saida' WHERE id = '$promotor_id'";

        if ($conn->query($sql) === TRUE) {
            echo "Saída registrada com sucesso!";
        } else {
            echo "Erro ao registrar saída: " . $conn->error;
        }
    } else {
        echo "Erro: ID do promotor ou responsável pela saída não foram fornecidos.";
    }
} else {
    echo "Método de solicitação inválido.";
}

$conn->close();
?>
