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
    <title>RESPONSAVEIS CADASTRADOS</title>
    <?php include 'menu.html'; ?>
    <link rel="stylesheet" href="css/style.css">
    <script>
        // Função para buscar responsáveis
        function buscarResponsaveis() {
            let query = document.getElementById('search').value;
            let formData = new FormData();
            formData.append('query', query);

            fetch('buscar_responsaveis.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                let lista = document.getElementById('responsaveis-list');
                lista.innerHTML = '';
                data.forEach(responsavel => {
                    let item = document.createElement('div');
                    item.classList.add('responsavel-item');
                    item.innerHTML = `
                        <p><strong>Nome:</strong> ${responsavel.nome}</p>
                        <p><strong>CPF:</strong> ${responsavel.cpf}</p>
                        <p><strong>Sexo:</strong> ${responsavel.sexo}</p>
                        <p><strong>Setor:</strong> ${responsavel.setor}</p>
                        <button onclick="verResponsavel(${responsavel.id})">Ver</button>
                        <button onclick="editarResponsavel(${responsavel.id})">Editar</button>
                        <button onclick="excluirResponsavel(${responsavel.id})">Excluir</button>
                    `;
                    lista.appendChild(item);
                });
            })
            .catch(error => console.error('Erro ao buscar responsáveis:', error));
        }

        // Função para ver detalhes de um responsável
        function verResponsavel(id) {
            window.location.href = 'ver_responsavel.php?id=' + id;
        }

        // Função para editar um responsável
        function editarResponsavel(id) {
            window.location.href = 'editar_responsavel.php?id=' + id;
        }

        // Função para excluir um responsável
        function excluirResponsavel(id) {
            if (confirm('Todas as entradas relacionadas a este responsável serão excluídas. Tem certeza de que deseja prosseguir com a exclusão deste responsável?')) {
                let formData = new FormData();
                formData.append('id', id);

                fetch('excluir_responsavel.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    buscarResponsaveis();
                })
                .catch(error => console.error('Erro ao excluir responsável:', error));
            }
        }

        // Buscar responsáveis ao carregar a página
        document.addEventListener('DOMContentLoaded', buscarResponsaveis);
    </script>
</head>
<body>
    <div class="container">
        <h1>RESPONSÁVEIS</h1>
        <input type="text" id="search" placeholder="Pesquisar por nome, CPF ou setor">
        <button onclick="buscarResponsaveis()">Buscar</button>
        <button onclick="window.location.href='cadastro_responsaveis.php'">Cadastrar Responsável</button>
        <div id="responsaveis-list" class="responsaveis-list"></div>
    </div>
    <footer class="marca-dagua">
    Power by: Marcos V Ferreira, supervisor de T.I. 2024
</footer>
</body>
</html>
