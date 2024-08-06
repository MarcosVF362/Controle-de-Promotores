<?php
include 'conexao.php';

// Ajustar a consulta SQL para usar os nomes de colunas corretos e ordenar pelos IDs em ordem decrescente
$sql = "SELECT e.id, p.nome AS promotor_nome, p.empresa, e.data AS data_entrada, TIME_FORMAT(e.hora_entrada, '%H:%i') AS hora_entrada, TIME_FORMAT(e.hora_saida, '%H:%i') AS hora_saida, r1.nome as responsavel_entrada, r2.nome as responsavel_saida 
        FROM entradas e
        JOIN promotores p ON e.promotor_id = p.id
        JOIN responsaveis r1 ON e.responsavel_entrada = r1.id
        LEFT JOIN responsaveis r2 ON e.responsavel_saida = r2.id
        ORDER BY e.id DESC"; // Ordenar pelos IDs em ordem decrescente

$result = $conn->query($sql);

if ($result === false) {
    die("Erro na consulta: " . $conn->error);
}

// Carregar os nomes dos responsáveis
$responsaveis = [];
$responsaveis_sql = "SELECT id, nome FROM responsaveis";
$responsaveis_result = $conn->query($responsaveis_sql);
if ($responsaveis_result->num_rows > 0) {
    while ($responsavel = $responsaveis_result->fetch_assoc()) {
        $responsaveis[] = $responsavel;
    }
}
?>
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
    <link rel="icon" href="./css/icone/icone.ico" type="image/x-icon"> <!-- Link para o favicon -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LISTA DE ENTRADAS</title>
    <?php include 'menu.html'; ?>
    <link rel="stylesheet" href="./css/style2.css">
    <script>
        function registrarSaida(id) {
            const responsavelSaidaSelect = document.getElementById(`responsavel-saida-${id}`);
            const responsavelSaida = responsavelSaidaSelect.value;

            if (!responsavelSaida || responsavelSaida === "selecione") {
                alert("Por favor, selecione um responsável pela saída.");
                return;
            }

            if (confirm("Deseja confirmar a saída do promotor?")) {
                const formData = new FormData();
                formData.append('id', id);
                formData.append('responsavel_saida', responsavelSaida);

                fetch('registrar_saida.php', {
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

                    // Atualizar a tabela dinamicamente
                    const currentDate = new Date();
                    const currentHour = currentDate.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });

                    document.getElementById(`hora-saida-${id}`).innerText = currentHour;
                    responsavelSaidaSelect.disabled = true; // Desativa o dropdown após a confirmação
                    responsavelSaidaSelect.style.display = 'none'; // Oculta o dropdown
                    const responsavelSaidaText = document.createElement('span');
                    responsavelSaidaText.innerText = responsavelSaidaSelect.options[responsavelSaidaSelect.selectedIndex].text;
                    responsavelSaidaSelect.parentNode.appendChild(responsavelSaidaText); // Adiciona o nome do responsável pela saída como texto
                    const botaoSaida = document.getElementById(`botao-saida-${id}`);
                    botaoSaida.innerText = "Saída efetuada";
                    botaoSaida.disabled = true; // Desativa o botão após a confirmação
                })
                .catch(error => console.error('Erro ao registrar saída:', error));
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>LISTA DE ENTRADAS</h1>
        <table>
            <thead>
                <tr>
                    <th>Promotor</th>
                    <th>Empresa</th>
                    <th>Data</th>
                    <th>Hora Entrada</th>
                    <th>Resp. Entrada</th>
                    <th>Hora Saída</th>
                    <th>Resp. Saída</th>
                    <th>Saída</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $dataEntrada = date("d/m/Y", strtotime($row['data_entrada'])); // Formatar data para dia/mes/ano
                        $saidaDesabilitada = $row['hora_saida'] ? 'disabled' : ''; // Verifica se a saída já foi registrada
                        echo '<tr>';
                        echo '<td>' . substr($row['promotor_nome'], 0, 20) . '</td>';
                        echo '<td>' . substr($row['empresa'], 0, 20) . '</td>';
                        echo '<td>' . $dataEntrada . '</td>';
                        echo '<td>' . $row['hora_entrada'] . '</td>';
                        echo '<td>' . $row['responsavel_entrada'] . '</td>';
                        echo '<td id="hora-saida-' . $row['id'] . '">' . $row['hora_saida'] . '</td>';
                        echo '<td>';

                        if ($row['hora_saida']) {
                            echo $row['responsavel_saida']; // Se a saída já foi registrada, exibe o nome do responsável
                        } else {
                            echo '<select id="responsavel-saida-' . $row['id'] . '" ' . $saidaDesabilitada . '>';
                            echo '<option value="selecione">Responsável</option>'; // Opção padrão
                            foreach ($responsaveis as $responsavel) {
                                $selected = ($responsavel['id'] == $row['responsavel_saida']) ? 'selected' : ''; // Verifica se este responsável é o selecionado
                                echo '<option value="' . $responsavel['id'] . '" ' . $selected . '>' . $responsavel['nome'] . '</option>';
                            }
                            echo '</select>';
                        }

                        echo '</td>';
                        echo '<td>';
                        echo '<button id="botao-saida-' . $row['id'] . '" onclick="registrarSaida(' . $row['id'] . ')" ' . $saidaDesabilitada . '>' . ($row['hora_saida'] ? 'Saída efetuada' : 'Registrar Saída') . '</button>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="8">Nenhuma entrada encontrada.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <footer class="marca-dagua">
    Power by: Marcos V Ferreira, supervisor de T.I. 2024
</footer>
</html>
