<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "supermercado";


// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>