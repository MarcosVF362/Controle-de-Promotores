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
    <title>CADASTRAR RESPONSÁVEL</title>
    <?php include 'menu.html'; ?>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
    <h1>CADASTRAR RESPONSÁVEL</h1>
        <form action="cadastrar_responsavel.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" maxlength="14" required>

            <label for="sexo">Sexo:</label>
            <select id="sexo" name="sexo" required>
                <option value="M">Masculino</option>
                <option value="F">Feminino</option>
            </select>

            <label for="setor">Setor:</label>
            <select id="setor" name="setor" required>
                <option value="" selected disabled>Selecione um setor</option>
                <option value="Prevenção de Perdas">Prevenção de Perdas</option>
                <option value="Frente de Loja">Frente de Loja</option>
                <option value="Mercearia">Mercearia</option>
                <option value="Padaria">Padaria</option>
                <option value="Açougue">Açougue</option>
                <option value="Frios">Frios</option>
                <option value="D.A.O">D.A.O</option>
            </select>

            <button type="submit">Cadastrar</button>
        </form>
    </div>

    <script>
        // Adiciona um listener para o evento "input" no campo de nome
        document.getElementById('nome').addEventListener('input', function (e) {
            // Obtém o valor atual do campo de nome
            let nome = e.target.value;

            // Capitaliza a primeira letra de cada palavra no nome
            let nomeFormatado = nome.toLowerCase().replace(/(?:^|\s)\S/g, function(a) { return a.toUpperCase(); });

            // Atualiza o valor do campo de nome com as primeiras letras maiúsculas
            e.target.value = nomeFormatado;
        });

        function formatCPF(cpf) {
            cpf = cpf.replace(/\D/g, "");
            cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
            cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
            cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
            return cpf;
        }

        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById('nome').addEventListener('input', function () {
                this.value = capitalizeWords(this.value);
            });

            document.getElementById('cpf').addEventListener('input', function () {
                let cursorPosition = this.selectionStart;
                let oldLength = this.value.length;
                this.value = formatCPF(this.value);
                let newLength = this.value.length;
                cursorPosition += newLength - oldLength;
                this.setSelectionRange(cursorPosition, cursorPosition);
            });
        });
    </script>
    <footer class="marca-dagua">
    Power by: Marcos V Ferreira, supervisor de T.I. 2024
</footer>
</body>
</html>
