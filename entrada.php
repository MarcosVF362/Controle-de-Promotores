
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
    <title>REGISTRAR ENTRADA</title>
    <?php include 'menu.html'; ?>
    <link rel="stylesheet" href="css/style.css">
</script>
        <style>
        /* Estilos para linhas pares */
        .promotores-list .promotor-item:nth-child(even) {
            background-color: #f2f2f2; /* Cor de fundo para linhas pares */
        }

        /* Estilos para linhas ímpares */
        .promotores-list .promotor-item:nth-child(odd) {
            background-color: #ffffff; /* Cor de fundo para linhas ímpares */
        }
    </style>
    </script>
    <script async>
        function buscarPromotores() {
            const query = document.getElementById('search').value;
            const formData = new FormData();
            formData.append('query', query);

            fetch('buscar_promotores.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro na resposta da rede');
                }
                return response.json();
            })
            .then(data => {
                const lista = document.getElementById('promotores-list');
                lista.innerHTML = '';
                data.forEach(promotor => {
                    const item = document.createElement('div');
                    item.classList.add('promotor-item');
                    item.innerHTML = `
                        <p><strong>Nome:</strong> ${promotor.nome}</p>
                        <p><strong>CPF:</strong> ${promotor.cpf}</p>
                        <p><strong>Empresa:</strong> ${promotor.empresa}</p>
                        <button onclick="darEntrada(${promotor.id})">Entrada</button>
                    `;
                    lista.appendChild(item);
                });
            })
            .catch(error => console.error('Erro ao buscar promotores:', error));
        }

        function darEntrada(id) {
            const responsavelEntrada = document.getElementById('responsavel-entrada').value;

            if (!responsavelEntrada) {
                alert("Por favor, selecione um responsável pela entrada.");
                return;
            }

            const formData = new FormData();
            formData.append('id', id);
            formData.append('responsavel_entrada', responsavelEntrada);

            fetch('registrar_entrada.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro na resposta da rede');
                }
                return response.text();
            })
            .then(data => {
                alert(data);
                window.location.href = 'lista_entradas.php'; // Redireciona para a lista de entradas
            })
            .catch(error => console.error('Erro ao registrar entrada:', error));
        }

        document.addEventListener('DOMContentLoaded', buscarPromotores);
    </script>
</head>
<body>
    <div class="container">
        <h1>ENTRADA PROMOTOR</h1>
        <div class="search-container">
            <input type="text" id="search" placeholder="Pesquisar por nome, CPF ou empresa">
            <button onclick="buscarPromotores()">Buscar</button>
        </div>
        <label for="responsavel-entrada">Responsável pela Entrada:</label>
        <select id="responsavel-entrada">
            <option value="" disabled selected>Selecione o responsável</option>
            <?php
                include 'conexao.php';
                $sql = "SELECT id, nome FROM responsaveis";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id'] . '">' . $row['nome'] . '</option>';
                    }
                }
                $conn->close();
            ?>
        </select>
        <div id="promotores-list" class="promotores-list"></div>
    </div>
    <footer class="marca-dagua">
    Power by: Marcos Vinicius Ferreira, supervisor de T.I. 2024
</footer>
</body>
</html>
