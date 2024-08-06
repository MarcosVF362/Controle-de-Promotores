<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = $_POST['query'];
    $sql = "SELECT * FROM responsaveis WHERE nome LIKE '%$query%' OR cpf LIKE '%$query%' OR setor LIKE '%$query%'";
    $result = $conn->query($sql);

    $responsaveis = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $responsaveis[] = $row;
        }
    }
    echo json_encode($responsaveis);
}

$conn->close();
?>
