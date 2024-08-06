<?php
// Verifica se o ID do responsável foi fornecido na URL
if (isset($_GET['id'])) {
    // Conecta ao banco de dados
    include 'conexao.php';

    // Obtém o ID do responsável da URL
    $id = $_GET['id'];

    // Consulta SQL para obter os dados do responsável com base no ID fornecido
    $sql = "SELECT * FROM responsaveis WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Exibe o formulário de edição preenchido com os dados do responsável
        $responsavel = $result->fetch_assoc();
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
    <?php include 'menu.html'; ?>
    <title>Editar Responsável</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        // Função para capitalizar a primeira letra de cada palavra
        function capitalizeWords(str) {
            return str.replace(/\b\w/g, function (char) {
                return char.toUpperCase();
            });
        }

        // Formatação do CPF
        function formatCPF(cpf) {
            cpf = cpf.replace(/\D/g, ""); // Remove caracteres não numéricos
            cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
            cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
            cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
            return cpf;
        }

        document.addEventListener("DOMContentLoaded", function () {
            // Adiciona evento de input para capitalizar o nome
            document.getElementById('nome').addEventListener('input', function () {
                this.value = capitalizeWords(this.value);
            });

            // Adiciona evento de input para formatar o CPF
            document.getElementById('cpf').addEventListener('input', function () {
                this.value = formatCPF(this.value);
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Editar Responsável</h1>
        <form action="atualizar_responsavel.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $responsavel['id']; ?>">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $responsavel['nome']; ?>" required>

            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" value="<?php echo $responsavel['cpf']; ?>" required>

            <label for="sexo">Sexo:</label>
            <select id="sexo" name="sexo" required>
                <option value="M" <?php if ($responsavel['sexo'] === 'M') echo 'selected'; ?>>Masculino</option>
                <option value="F" <?php if ($responsavel['sexo'] === 'F') echo 'selected'; ?>>Feminino</option>
            </select>

            <label for="setor">Setor:</label>
            <select id="setor" name="setor" required>
                <option value="Prevenção de Perdas" <?php if ($responsavel['setor'] === 'Prevenção de Perdas') echo 'selected'; ?>>Prevenção de Perdas</option>
                <option value="Frente de Loja " <?php if ($responsavel['setor'] === 'Frente de Loja') echo 'selected'; ?>>Frente de Loja</option>
                <option value="Mercearia" <?php if ($responsavel['setor'] === 'Mercearia') echo 'selected'; ?>>Mercearia</option>
                <option value="Padaria" <?php if ($responsavel['setor'] === 'Padaria') echo 'selected'; ?>>Padaria</option>
                <option value="Açougue" <?php if ($responsavel['setor'] === 'Açougue') echo 'selected'; ?>>Açougue</option>
                <option value="Frios" <?php if ($responsavel['setor'] === 'Frios') echo 'selected'; ?>>Frios</option>
                <option value="D.A.O" <?php if ($responsavel['setor'] === 'D.A.O') echo 'selected'; ?>>D.A.O</option>
            </select>

            <button type="submit">Atualizar</button>
        </form>
    </div>
    <footer class="marca-dagua">
    Power by: Marcos V Ferreira, supervisor de T.I. 2024
</footer>
</body>
</html>
<?php
    } else {
        // Se nenhum responsável com o ID fornecido for encontrado, exibe uma mensagem de erro
        echo "Responsável não encontrado.";
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
} else {
    // Se nenhum ID de responsável foi fornecido na URL, exibe uma mensagem de erro
    echo "ID do responsável não fornecido.";
}
?>
