<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Excluir as entradas associadas ao responsável
    $sqlDeleteEntradas = "DELETE FROM entradas WHERE responsavel_entrada = $id OR responsavel_saida = $id";

    if ($conn->query($sqlDeleteEntradas) === TRUE) {
        // Se as entradas foram excluídas com sucesso, então podemos excluir o responsável
        $sqlDeleteResponsavel = "DELETE FROM responsaveis WHERE id = $id";

        if ($conn->query($sqlDeleteResponsavel) === TRUE) {
            echo "Responsável e suas entradas associadas foram excluídos com sucesso!";
        } else {
            echo "Erro ao excluir responsável: " . $conn->error;
        }
    } else {
        echo "Erro ao excluir entradas associadas: " . $conn->error;
    }
}

$conn->close();
?>
