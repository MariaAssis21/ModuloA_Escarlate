<?php
require_once 'conexao.php';
require_once 'vendor/autoload.php'; // Se você usou o Composer para instalar a TCPDF


$id_ativo = $_GET['id_ativo'];

$sql = "SELECT * FROM manutencoes WHERE id_ativo = ? ORDER BY data_manutencao DESC";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_ativo);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>Histórico de Manutenções do Ativo #$id_ativo</h2>";

    echo "<a href='painel.php'>Voltar ao painel</a><br>";
    echo "<a href='cadastro_manutencao.php'>Voltar para manutenção</a><br><br>";

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='8'>
            <tr>
                <th>Data</th>
                <th>Tipo</th>
                <th>Técnico</th>
                <th>Custo (R$)</th>
                <th>Descrição</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['data_manutencao']}</td>
                <td>{$row['tipo']}</td>
                <td>{$row['responsavel_tecnico']}</td>
                <td>{$row['custo']}</td>
                <td>{$row['descricao']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Nenhuma manutenção registrada ainda.</p>";
    echo "<a href='painel.php'>Voltar ao painel</a>";
    echo "<a href='cadastro_manutencao.php'>Voltar para manutenção</a>";
}

$html = <<<EOD
    <h1>Histórico de Manutenções do Ativo #$id_ativo</h1>
EOD;

// Criação do PDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);
$pdf->writeHTML($html, true, false, true, false, '');

// Saída do PDF
$pdf->Output('historico_manutencao_ativo_'.$id_ativo.'.pdf', 'I');
?>