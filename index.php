<?php
// Inicia a sessão
session_start();

// Verifica se o usuário não está autenticado, se não estiver, redireciona para a página de login
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONTROLE DE PROMOTORES</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="./css/icone/icone.ico" type="image/x-icon"> <!-- Link para o favicon -->
</head>
<body class="index-page">
    <?php include 'menuinicio.html'; ?>
    <!-- Conteúdo da página -->
    <footer class="marca-dagua">
    Power by: Marcos Vinicius Ferreira, supervisor de T.I. 2024
</footer>
</body>
</html>
