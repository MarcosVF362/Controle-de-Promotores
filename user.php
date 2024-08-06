<?php
include('db.php');

$username = 'prevencao';
$password = 'prev2024';

// Criptografar a senha
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Inserir usuário no banco de dados
$sql = "INSERT INTO usuarios (username, password) VALUES ('$username', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
    echo "Novo usuário criado com sucesso";
} else {
    echo "Erro: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>