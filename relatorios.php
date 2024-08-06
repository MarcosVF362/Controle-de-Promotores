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
    <link rel="icon" href="./css/icone/icone.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios de Entradas</title>
    <?php include 'menu.html'; ?>
    <link rel="stylesheet" href="./css/stylerela.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Relatórios de Entradas</h1>
        <div class="search-container">
            <input type="text" id="search" placeholder="Pesquisar por nome, empresa ou CPF">
            <div class="date-container">
                <div>
                    <label for="data_inicio">Data de Início:</label>
                    <input type="date" id="data_inicio" name="data_inicio">
                </div>
                <div>
                    <label for="data_fim">Data de Fim:</label>
                    <input type="date" id="data_fim" name="data_fim">
                </div>
            </div>
            <!-- Caixas de seleção para os campos -->
            <div class="checkbox-container">
                <label for="data"><input type="checkbox" id="data" name="campo" value="data"> Data</label>
                <label for="hora_entrada"><input type="checkbox" id="hora_entrada" name="campo" value="hora_entrada"> Hora de Entrada</label>
                <label for="hora_saida"><input type="checkbox" id="hora_saida" name="campo" value="hora_saida"> Hora de Saída</label>
                <label for="responsavel_entrada"><input type="checkbox" id="responsavel_entrada" name="campo" value="responsavel_entrada"> Resp Entrada</label>
                <label for="responsavel_saida"><input type="checkbox" id="responsavel_saida" name="campo" value="responsavel_saida"> Resp Saída</label>
            </div>
            <button onclick="buscarRelatorios()">Buscar</button>
        </div>
        <div id="resultados-relatorios" class="resultados-relatorios"></div>
    </div>
    <footer class="marca-dagua">
        Power by: Marcos V Ferreira, supervisor de T.I. 2024
    </footer>
    <script>
        function buscarRelatorios() {
            const query = document.getElementById('search').value;
            const dataInicio = document.getElementById('data_inicio').value;
            const dataFim = document.getElementById('data_fim').value;

            const formData = new FormData();
            formData.append('query', query);
            formData.append('data_inicio', dataInicio);
            formData.append('data_fim', dataFim);

            fetch('buscar_relatorios.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const resultados = document.getElementById('resultados-relatorios');
                resultados.innerHTML = '';

                if (data.hasOwnProperty('message')) {
                    resultados.innerHTML = `<p>${data.message}</p>`;
                    return;
                }

                data.forEach(item => {
                    const card = document.createElement('div');
                    card.classList.add('resultado-item');
                    card.innerHTML = `
                        <p><strong>Nome:</strong> ${item.nome}</p>
                        <p><strong>Empresa:</strong> ${item.empresa}</p>
                        <p><strong>CPF:</strong> ${item.cpf}</p>
                        <button onclick="gerarRelatorio(${item.id})">Gerar Relatório</button>`;
                    resultados.appendChild(card);
                });
            })
            .catch(error => console.error('Erro ao buscar relatórios:', error));
        }

        function gerarRelatorio(id) {
            const camposSelecionados = ['nome', 'cpf', 'empresa']; // Nome, CPF e Empresa sempre são obrigatórios
            document.querySelectorAll('input[name=campo]:checked').forEach(item => {
                camposSelecionados.push(item.value);
            });

            const dataInicio = document.getElementById('data_inicio').value;
            const dataFim = document.getElementById('data_fim').value;
            
            const campos = JSON.stringify(camposSelecionados);
            window.location.href = `gerar_relatorio.php?id=${id}&data_inicio=${encodeURIComponent(dataInicio)}&data_fim=${encodeURIComponent(dataFim)}&campos=${encodeURIComponent(campos)}`;
        }
    </script>
</body>
</html>
