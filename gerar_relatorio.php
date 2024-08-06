<?php
include 'conexao.php';
require 'vendor/autoload.php'; 

setlocale(LC_TIME, 'pt_BR.utf-8', 'pt_BR', 'portuguese_brazil.1252');

$conn->set_charset("utf8mb4");

$id = $_GET['id'];
$campos = json_decode($_GET['campos'], true); 
$dataInicio = $_GET['data_inicio'];
$dataFim = $_GET['data_fim'];

// Converter as datas para o formato YYYY-MM-DD
$dataInicioFormatada = date('Y-m-d', strtotime($dataInicio));
$dataFimFormatada = date('Y-m-d', strtotime($dataFim));

// Montar a lista de campos a serem selecionados na consulta SQL
$camposSql = "p.nome, p.dias_semana"; // Nome e dias_semana sempre serão selecionados

// Definir a origem de cada campo (tabela 'entradas' ou 'promotores')
$tabelaCampos = [
    'data' => 'e.data',
    'hora_entrada' => 'TIME_FORMAT(e.hora_entrada, "%H:%i") as hora_entrada',
    'hora_saida' => 'TIME_FORMAT(e.hora_saida, "%H:%i") as hora_saida',
    'empresa' => 'p.empresa',
    'cpf' => 'p.cpf',
    'responsavel_entrada' => 'r1.nome as responsavel_entrada',
    'responsavel_saida' => 'r2.nome as responsavel_saida'
];

foreach ($campos as $campo) {
    if ($campo != 'nome' && $campo != 'dias_semana') {
        if (array_key_exists($campo, $tabelaCampos)) {
            $camposSql .= ", " . $tabelaCampos[$campo];
        }
    }
}

// Preparar a consulta SQL para buscar os relatórios de acordo com o intervalo de datas e os campos selecionados
$sql = "SELECT $camposSql
        FROM entradas e
        JOIN promotores p ON e.promotor_id = p.id
        JOIN responsaveis r1 ON e.responsavel_entrada = r1.id
        LEFT JOIN responsaveis r2 ON e.responsavel_saida = r2.id
        WHERE e.data BETWEEN '$dataInicioFormatada' AND '$dataFimFormatada' AND e.promotor_id = $id
        ORDER BY e.data ASC"; // Ordenar por data de forma ascendente

$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Formatando a hora de entrada e saída para mostrar apenas hora e minutos
        if (isset($row['hora_entrada'])) {
            $row['hora_entrada'] = date('H:i', strtotime($row['hora_entrada']));
        }
        if (isset($row['hora_saida'])) {
            $row['hora_saida'] = date('H:i', strtotime($row['hora_saida']));
        }
        if (isset($row['data'])) {
            $timestamp = strtotime($row['data']);
            $row['data'] = strftime('%d/%m/%Y', $timestamp) . ' (' . utf8_encode(strftime('%A', $timestamp)) . ')';
        }
        $data[] = $row;
    }
}

// Gerar HTML do relatório
ob_start();
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
    <link rel="icon" href="./css/icone/icone.ico" type="image/x-icon">
    <title>Relatório de Entradas</title>
    <?php include 'menu.html'; ?>
    <link rel="stylesheet" href="./css/stylegera.css">
    <link rel="stylesheet" href="./css/print.css" media="print">
</head>
<body>
    <h1>RELATÓRIO DE ENTRADAS</h1>
    <h2>DADOS DO PROMOTOR:</h2>
    <?php if (count($data) > 0): ?>
        <?php foreach ($data as $index => $row): ?>
            <?php if ($index === 0): ?>
                <div class="header-info">
                    <p><strong>Nome:</strong> <?php echo $row['nome']; ?></p>
                    <p><strong>CPF:</strong> <?php echo $row['cpf']; ?></p>
                    <p><strong>Empresa:</strong> <?php echo $row['empresa']; ?></p>
                    <p><strong>Dias da Semana:</strong> <?php echo $row['dias_semana']; ?></p> <!-- Adicionando os dias da semana -->
                </div>
                <div>
                    <footer class="marca-dagua">
                        Power by: Marcos V Ferreira, supervisor de T.I. 2024
                    </footer>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>#</th> <!-- Adicione a coluna numerada aqui -->
                            <?php foreach ($campos as $campo): ?>
                                <?php if ($campo !== 'nome' && $campo !== 'cpf' && $campo !== 'empresa' && $campo !== 'dias_semana'): ?>
                                    <th><?php echo ucfirst(str_replace('_', ' ', $campo)); ?></th>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
            <?php endif; ?>
            <tr>
                <td><?php echo $index + 1; ?></td> <!-- Número da linha -->
                <?php foreach ($campos as $campo): ?>
                    <?php if ($campo !== 'nome' && $campo !== 'cpf' && $campo !== 'empresa' && $campo !== 'dias_semana'): ?>
                        <td><?php echo $row[$campo]; ?></td>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
                    </tbody>
                </table>
    <?php else: ?>
        <p>Nenhuma entrada encontrada.</p>
    <?php endif; ?>
    <div class="print-button-container">
        <button onclick="window.print()">Imprimir</button>
</body>
</html>

<?php
$html = ob_get_clean();
echo $html;

// Função para exportar para Excel usando PhpSpreadsheet
function exportarExcel($data) {
    // Crie o arquivo Excel aqui usando PhpSpreadsheet
}

// Função para exportar para PDF usando Dompdf
function exportarPDF($html) {
    // Crie o arquivo PDF aqui usando Dompdf
}
?>
