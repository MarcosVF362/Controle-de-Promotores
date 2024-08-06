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
    <title>CADASTRAR PROMOTOR</title>
    <?php include 'menu.html'; ?>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>CADASTRAR PROMOTOR</h1>
        <form action="verificar_cadastro.php" method="POST" id="cadastroForm">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="cpf">CPF:</label>
            <!-- Utilize o atributo "pattern" para definir a máscara -->
            <input type="text" id="cpf" name="cpf" required>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" required>

            <label for="sexo">Sexo:</label>
            <select id="sexo" name="sexo" required>
                <option value="M">Masculino</option>
                <option value="F">Feminino</option>
            </select>

            <label for="empresa">Empresa:</label>
            <input type="text" id="empresa" name="empresa" required>

            <label for="dias_semana">Dias da Semana:</label>
            <div class="dias-semana">
                <input type="checkbox" id="seg" name="dias_semana[]" value="Seg">
                <label for="seg">Seg</label>

                <input type="checkbox" id="ter" name="dias_semana[]" value="Ter">
                <label for="ter">Ter</label>

                <input type="checkbox" id="qua" name="dias_semana[]" value="Qua">
                <label for="qua">Qua</label>

                <input type="checkbox" id="qui" name="dias_semana[]" value="Qui">
                <label for="qui">Qui</label>

                <input type="checkbox" id="sex" name="dias_semana[]" value="Sex">
                <label for="sex">Sex</label>

                <input type="checkbox" id="sab" name="dias_semana[]" value="Sab">
                <label for="sab">Sab</label>

                <input type="checkbox" id="dom" name="dias_semana[]" value="Dom">
                <label for="dom">Dom</label>
            </div>

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

        // Adiciona um listener para o evento "input" no campo de CPF
        document.getElementById('cpf').addEventListener('input', function (e) {
            // Obtém o valor atual do campo de CPF
            let cpf = e.target.value;

            // Remove todos os caracteres não numéricos do CPF
            cpf = cpf.replace(/\D/g, '');

            // Adiciona automaticamente os pontos e o traço ao CPF
            cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
            cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
            cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');

            // Limita o CPF a 14 caracteres (incluindo pontos e traço)
            if (cpf.length > 14) {
                cpf = cpf.substring(0, 14);
            }

            // Atualiza o valor do campo de CPF com a versão formatada
            e.target.value = cpf;
        });

        // Adiciona um listener para o evento "input" no campo de telefone
        document.getElementById('telefone').addEventListener('input', function (e) {
            // Obtém o valor atual do campo de telefone
            let telefone = e.target.value;

            // Remove todos os caracteres não numéricos do telefone
            telefone = telefone.replace(/\D/g, '');

            // Formata o telefone no padrão (XX) XXXXX-XXXX
            if (telefone.length > 10) {
                telefone = telefone.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
            } else if (telefone.length > 5) {
                telefone = telefone.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
            } else if (telefone.length > 2) {
                telefone = telefone.replace(/^(\d{2})(\d{0,5}).*/, '($1) $2');
            } else {
                telefone = telefone.replace(/^(\d*)/, '($1');
            }

            // Atualiza o valor do campo de telefone com a versão formatada
            e.target.value = telefone;
        });

        // Adiciona um listener para o evento "submit" no formulário
        document.getElementById('cadastroForm').addEventListener('submit', function (e) {
            // Evita o comportamento padrão de envio do formulário
            e.preventDefault();

            // Envia o formulário usando AJAX
            let form = this;
            let formData = new FormData(form);
            fetch(form.action, {
                method: form.method,
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                // Mostra o resultado do cadastro em um popup
                alert(data);
                // Redireciona para o índice após 2 segundos
                setTimeout(function () {
                    window.location.href = 'index.php';
                });
            })
            .catch(error => console.error('Erro ao cadastrar:', error));
        });
    </script>
    <footer class="marca-dagua">
    Power by: Marcos V Ferreira, supervisor de T.I. 2024
</footer>
</body>
</html>
