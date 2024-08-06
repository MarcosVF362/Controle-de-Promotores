<?php
include 'conexao.php';

$dataInicio = $_POST['data_inicio'];
$dataFim = $_POST['data_fim'];

// Converter as datas para o formato YYYY-MM-DD
$dataInicioFormatada = date('Y-m-d', strtotime($dataInicio));
$dataFimFormatada = date('Y-m-d', strtotime($dataFim));

// Consulta SQL para buscar os nomes únicos dos usuários durante o intervalo de tempo especificado
$sql = "SELECT DISTINCT p.nome 
        FROM entradas e
        JOIN promotores p ON e.promotor_id = p.id
        WHERE e.data BETWEEN '$dataInicioFormatada' AND '$dataFimFormatada'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $nomes = array();
    while ($row = $result->fetch_assoc()) {
        $nomes[] = $row['nome'];
    }
    echo json_encode($nomes);
} else {
    echo json_encode(array("message" => "Nenhum nome de usuário encontrado para o intervalo de tempo especificado."));
}

$conn->close();
?>
