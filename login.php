<?php
// Inicia a sessão
session_start();

// Verifica se o usuário já está autenticado, se estiver, redireciona para index.php
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    header("Location: index.php");
    exit();
}

// Verifica se o método de requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexao.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepara e executa a consulta SQL
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ? AND password = PASSWORD(?)");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se há um usuário correspondente
    if ($result->num_rows > 0) {
        // Login bem-sucedido, define a sessão como autenticada
        $_SESSION['authenticated'] = true;
        
        // Redireciona para index.php
        header("Location: index.php");
        exit();
    } else {
        // Exibe um alerta se o nome de usuário ou senha estiverem incorretos
        echo "<script>showAlert('Nome de usuário ou senha incorretos.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<link rel="icon" href="./css/icone/icone.ico" type="image/x-icon">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="./css/stylelogin.css">
    <script>
        function showAlert(message) {
            alert(message);
        }
    </script>
</head>
<body>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h2 class="login-title">Login</h2>
            <label for="username">Usuário:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required><br>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
