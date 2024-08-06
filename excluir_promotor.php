<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Excluir as entradas associadas ao promotor
    $sqlDeleteEntradas = "DELETE FROM entradas WHERE promotor_id = $id";

    if ($conn->query($sqlDeleteEntradas) === TRUE) {
        // Se as entradas foram excluídas com sucesso, então podemos excluir o promotor
        $sqlDeletePromotor = "DELETE FROM promotores WHERE id = $id";

        if ($conn->query($sqlDeletePromotor) === TRUE) {
            echo "Promotor e suas entradas associadas foram excluídos com sucesso!";
        } else {
            echo "Erro ao excluir promotor: " . $conn->error;
        }
    } else {
        echo "Erro ao excluir entradas associadas: " . $conn->error;
    }
}

$conn->close();
?>
