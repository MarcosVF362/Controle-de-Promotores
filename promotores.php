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
    <title>PROMOTORES CADASTRADOS</title>
    <?php include 'menu.html'; ?>
    <link rel="stylesheet" href="css/style.css">
    <script>
        // Função para buscar promotores
        function buscarPromotores() {
            let query = document.getElementById('search').value;
            let formData = new FormData();
            formData.append('query', query);

            fetch('buscar_promotores.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                let lista = document.getElementById('promotores-list');
                lista.innerHTML = '';
                data.forEach(promotor => {
                    let item = document.createElement('div');
                    item.classList.add('promotor-item');
                    item.innerHTML = `
                        <p><strong>Nome:</strong> ${promotor.nome}</p>
                        <p><strong>CPF:</strong> ${promotor.cpf}</p>
                        <button onclick="verPromotor(${promotor.id})">Ver</button>
                        <button onclick="editarPromotor(${promotor.id})">Editar</button>
                        <button onclick="excluirPromotor(${promotor.id})">Excluir</button>
                    `;
                    lista.appendChild(item);
                });
            })
            .catch(error => console.error('Erro ao buscar promotores:', error));
        }

        // Função para ver detalhes de um promotor
        function verPromotor(id) {
            window.location.href = 'ver_promotor.php?id=' + id;
        }

        // Função para editar um promotor
        function editarPromotor(id) {
            window.location.href = 'editar_promotor.php?id=' + id;
        }

        // Função para excluir um promotor
        function excluirPromotor(id) {
            if (confirm('Todas as entradas deste promotor serão excluídas. Tem certeza de que deseja prosseguir com a exclusão deste promotor?')) {
                let formData = new FormData();
                formData.append('id', id);

                fetch('excluir_promotor.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    buscarPromotores();
                })
                .catch(error => console.error('Erro ao excluir promotor:', error));
            }
        }

        // Buscar promotores ao carregar a página
        document.addEventListener('DOMContentLoaded', buscarPromotores);
    </script>
</head>
<body>
    <div class="container">
        <h1>PROMOTORES</h1>
        <input type="text" id="search" placeholder="Pesquisar por nome, CPF ou empresa">
        <button onclick="buscarPromotores()">Buscar</button>
        <button onclick="window.location.href='cadastro_promotores.php'">CADASTRAR PROMOTOR</button>
        <div id="promotores-list" class="promotores-list"></div>
    </div>
</body>
<footer class="marca-dagua">
    Power by: Marcos V Ferreira, supervisor de T.I. 2024
</footer>
</html>
