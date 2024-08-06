<?php
include 'conexao.php';

$dataInicio = $_POST['data_inicio'];
$dataFim = $_POST['data_fim'];
$query = $_POST['query'];

// Converter as datas para o formato YYYY-MM-DD
$dataInicioFormatada = date('Y-m-d', strtotime($dataInicio));
$dataFimFormatada = date('Y-m-d', strtotime($dataFim));

// Preparar a consulta SQL para buscar promotores únicos de acordo com o intervalo de datas e a pesquisa
$sql = "SELECT DISTINCT p.id, p.nome, p.empresa, p.cpf 
        FROM entradas e
        JOIN promotores p ON e.promotor_id = p.id
        WHERE e.data BETWEEN '$dataInicioFormatada' AND '$dataFimFormatada'";

if (!empty($query)) {
    $sql .= " AND (p.nome LIKE '%$query%' OR p.empresa LIKE '%$query%' OR p.cpf LIKE '%$query%')";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $promotores = array();
    while ($row = $result->fetch_assoc()) {
        $promotores[] = $row;
    }
    echo json_encode($promotores);
} else {
    echo json_encode(array("message" => "Nenhum promotor encontrado para os critérios de pesquisa."));
}

$conn->close();
?>
