<?php
// Verifica se o ID do promotor foi fornecido na URL
if (isset($_GET['id'])) {
    // Conecta ao banco de dados
    include 'conexao.php';

    // Obtém o ID do promotor da URL
    $id = $_GET['id'];

    // Consulta SQL para obter os dados do promotor com base no ID fornecido
    $sql = "SELECT * FROM promotores WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Exibe o formulário de edição preenchido com os dados do promotor
        $promotor = $result->fetch_assoc();
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
    <title>Editar Promotor</title>
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

        // Formatação do telefone
        function formatPhone(phone) {
            phone = phone.replace(/\D/g, ""); // Remove caracteres não numéricos
            phone = phone.replace(/^(\d{2})(\d)/g, "($1) $2");
            phone = phone.replace(/(\d)(\d{4})$/, "$1-$2");
            return phone;
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

            // Adiciona evento de input para formatar o telefone
            document.getElementById('telefone').addEventListener('input', function () {
                this.value = formatPhone(this.value);
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Editar Promotor</h1>
        <form action="atualizar_promotor.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $promotor['id']; ?>">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $promotor['nome']; ?>" required>

            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" value="<?php echo $promotor['cpf']; ?>" required>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" value="<?php echo $promotor['telefone']; ?>" required>

            <label for="sexo">Sexo:</label>
            <select id="sexo" name="sexo" required>
                <option value="M" <?php if ($promotor['sexo'] === 'M') echo 'selected'; ?>>Masculino</option>
                <option value="F" <?php if ($promotor['sexo'] === 'F') echo 'selected'; ?>>Feminino</option>
            </select>

            <label for="empresa">Empresa:</label>
            <input type="text" id="empresa" name="empresa" value="<?php echo $promotor['empresa']; ?>" required>

            <label for="dias_semana">Dias da Semana:</label>
            <div class="dias-semana">
                <?php
                $dias_semana = explode(', ', $promotor['dias_semana']);
                $dias_todos = ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab', 'Dom'];
                foreach ($dias_todos as $dia) {
                    $checked = in_array($dia, $dias_semana) ? 'checked' : '';
                    echo "<input type=\"checkbox\" id=\"{$dia}\" name=\"dias_semana[]\" value=\"{$dia}\" {$checked}>";
                    echo "<label for=\"{$dia}\">{$dia}</label>";
                }
                ?>
            </div>

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
        // Se nenhum promotor com o ID fornecido for encontrado, exibe uma mensagem de erro
        echo "Promotor não encontrado.";
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
} else {
    // Se nenhum ID de promotor foi fornecido na URL, exibe uma mensagem de erro
    echo "ID do promotor não fornecido.";
}
?>
