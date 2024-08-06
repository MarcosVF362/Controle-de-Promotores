<?php
include 'conexao.php';

$sql = "SELECT e.id, p.nome, p.empresa, e.data_entrada, e.hora_entrada, e.hora_saida, r1.nome as responsavel_entrada, r2.nome as responsavel_saida 
        FROM entradas e
        JOIN promotores p ON e.promotor_id = p.id
        JOIN responsaveis r1 ON e.responsavel_entrada = r1.id
        LEFT JOIN responsaveis r2 ON e.responsavel_saida = r2.id";

$result = $conn->query($sql);

$entradas = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Removido o loop secundário para buscar todos os responsáveis, pois não parece ser necessário.
        // Se necessário, isso pode ser feito separadamente fora deste loop principal.
        $entradas[] = $row;
    }
}

echo json_encode($entradas);

$conn->close();
?>
