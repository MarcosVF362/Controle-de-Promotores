<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = $_POST['query'];
    $sql = "SELECT * FROM promotores WHERE nome LIKE '%$query%' OR cpf LIKE '%$query%' OR empresa LIKE '%$query%'";
    $result = $conn->query($sql);

    $promotores = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $promotores[] = $row;
        }
    }
    echo json_encode($promotores);
}

$conn->close();
?>
