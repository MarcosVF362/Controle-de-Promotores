<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Consulta para buscar o usuário
    $sql = "SELECT id, username, password FROM usuarios WHERE usuario = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verificar a senha
        if (password_verify($password, $row['password'])) {
            $_SESSION['login_user'] = $username;
            header("location: index.php");
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "Usuário não encontrado.";
    }
}
?>
