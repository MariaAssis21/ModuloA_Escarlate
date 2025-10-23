<?php
// OBRIGATÓRIO: NADA PODE SER ENVIADO PARA O NAVEGADOR ANTES DE $pdf->Output()

// Adiciona verificação para evitar o "Undefined array key"
if (!isset($_GET['id_ativo'])) {
    die("Erro: ID do ativo não fornecido na URL.");
}

require_once 'conexao.php';
require_once 'vendor/autoload.php'; 

$id_ativo = $_GET['id_ativo'];

// Prepara e executa a consulta SQL
$sql = "SELECT * FROM manutencoes WHERE id_ativo = ? ORDER BY data_manutencao DESC";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_ativo);
$stmt->execute();
$result = $stmt->get_result();

// INÍCIO DA CONSTRUÇÃO DO HTML (Usando $html, sem 'echo')

// 1. Constrói o título
$html = '<h1 style="text-align: center;">Histórico de Manutenções do Ativo #' . htmlspecialchars($id_ativo) . '</h1>';

if ($result->num_rows > 0) {
    // 2. Constrói a tabela
    $html .= '<table cellspacing="0" cellpadding="5" border="1" style="width: 100%;">
                <thead>
                    <tr style="background-color: #f0f0f0;">
                        <th width="15%">Data</th>
                        <th width="15%">Tipo</th>
                        <th width="15%">Técnico</th>
                        <th width="15%">Custo (R$)</th>
                        <th width="40%">Descrição</th>
                    </tr>
                </thead>
                <tbody>';
    
    // 3. Adiciona as linhas (Loop removido do 'echo')
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
                    <td>' . htmlspecialchars($row['data_manutencao']) . '</td>
                    <td>' . htmlspecialchars($row['tipo']) . '</td>
                    <td>' . htmlspecialchars($row['responsavel_tecnico']) . '</td>
                    <td>' . number_format($row['custo'], 2, ',', '.') . '</td>
                    <td>' . htmlspecialchars($row['descricao']) . '</td>
                  </tr>';
    }
    
    $html .= '</tbody></table>';
} else {
    // 4. Constrói a mensagem de "sem manutenção"
    $html .= '<p style="text-align: center;">Nenhuma manutenção registrada ainda.</p>';
}

// FIM DA CONSTRUÇÃO DO HTML

// CRIAÇÃO DO PDF (Deve ser o único código de saída de arquivo)
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetTitle('Historico de Manutencao - Ativo ' . $id_ativo);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

// Escreve o HTML construído na variável $html
$pdf->writeHTML($html, true, false, true, false, '');

// Saída do PDF
$pdf->Output('historico_manutencao_ativo_'.$id_ativo.'.pdf', 'I');

// Não há necessidade de '?>' no final do arquivo PHP, mas se usar, não pode haver nada depois.