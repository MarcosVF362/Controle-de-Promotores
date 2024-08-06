<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Inclui o arquivo de conexão com o banco de dados
    include 'conexao.php';

    // Obtém os dados do formulário
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $cpf = mysqli_real_escape_string($conn, $_POST['cpf']);
    $sexo = mysqli_real_escape_string($conn, $_POST['sexo']);
    $setor = mysqli_real_escape_string($conn, $_POST['setor']);

    // Consulta SQL para verificar se o CPF já está cadastrado
    $check_sql = "SELECT * FROM responsaveis WHERE cpf = '$cpf'";
    $check_result = $conn->query($check_sql);

    // Verifica se o CPF já está cadastrado
    if ($check_result->num_rows > 0) {
        echo "<script>
                alert('CPF já cadastrado!');
                window.history.back();
              </script>";
    } else {
        // CPF não cadastrado, procede com a inserção
        $sql = "INSERT INTO responsaveis (nome, cpf, sexo, setor) VALUES ('$nome', '$cpf', '$sexo', '$setor')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    alert('Responsável cadastrado com sucesso!');
                    window.location.href='index.php';
                  </script>";
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
} else {
    echo "Método de requisição inválido.";
}
?>
