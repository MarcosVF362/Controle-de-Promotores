<?php
include 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM promotores WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $promotor = $result->fetch_assoc();
    } else {
        echo "Promotor não encontrado.";
        exit;
    }
} else {
    echo "ID do promotor não fornecido.";
    exit;
}

$conn->close();
?>
<?php
// Inicia a sessão
session_start();

// Verifica se o usuário não está autenticado, se não estiver, redireciona para a página de login
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: login.php");
    exit();
}

// Continua com o código da página aqui...
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./css/icone/icone.ico" type="image/x-icon"> <!-- Link para o favicon -->
    <title>Detalhes do Promotor</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Detalhes do Promotor</h1>
        <p><strong>Nome:</strong> <?php echo $promotor['nome']; ?></p>
        <p><strong>CPF:</strong> <?php echo $promotor['cpf']; ?></p>
        <p><strong>Sexo:</strong> <?php echo $promotor['sexo']; ?></p>
        <p><strong>Telefone:</strong> <?php echo $promotor['telefone']; ?></p>
        <p><strong>Empresa:</strong> <?php echo $promotor['empresa']; ?></p>
        <p><strong>Dias da Semana:</strong> <?php echo $promotor['dias_semana']; ?></p>
        <button onclick="window.location.href='promotores.php'">Voltar</button>
        <button onclick="window.location.href='editar_promotor.php?id=<?php echo $promotor['id']; ?>'">Editar</button>
    </div>
    <footer class="marca-dagua">
    Power by: Marcos V Ferreira, supervisor de T.I. 2024
</footer>
</body>
</html>
