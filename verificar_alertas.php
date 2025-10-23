<?php
require_once 'conexao.php';

// Função para registrar logs
function registrar_log($conexao, $id_alerta, $acao) {
    $stmt = $conexao->prepare("INSERT INTO logs_alertas (id_alerta, acao) VALUES (?, ?)");
    $stmt->bind_param("is", $id_alerta, $acao);
    $stmt->execute();
}

// Evitar alertas duplicados: verifica se já existe um alerta igual
function alerta_existe($conexao, $tipo, $id_ativo) {
    $stmt = $conexao->prepare("SELECT COUNT(*) FROM alertas WHERE tipo_alerta=? AND id_ativo=? AND resolvido=0");
    $stmt->bind_param("si", $tipo, $id_ativo);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    return $count > 0;
}

// data atual
$hoje = date('Y-m-d');

// busca alertas com data próxima
$sql = "SELECT * FROM manutencoes WHERE data_manutencao <= DATE_ADD(?, INTERVAL 3 DAY)";
$stmt = $conexao->prepare($sql);
$stmt->bind_param('s', $hoje);
$stmt->execute();
$result = $stmt->get_result();

// se houver alertas
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // envia e-mail ou registra notificação
        echo "Alerta: manutenção próxima para o ativo ID " . $row['id_ativo'] . "\n";
    }
}

echo "✅ Verificação concluída com sucesso!";
?>
