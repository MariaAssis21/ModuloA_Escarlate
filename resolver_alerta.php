<?php
// Inclui o arquivo de conexão com o banco de dados
require_once 'conexao.php';
// Recebe o ID do alerta via parâmetro GET da URL
$id = $_GET['id_ativo'];
// Prepara a consulta para marcar o alerta como resolvido
$stmt = $conexao->prepare("UPDATE alertas SET resolvido=1, data_resolvido=NOW() WHERE id_alerta=?");
// Associa o parâmetro do ID à consulta (tipo inteiro)
$stmt->bind_param("i", $id);
// Executa a atualização no banco
$stmt->execute();

// Registrar a ação no log de alertas
$stmt2 = $conexao->prepare("INSERT INTO logs_alertas (id_alerta, acao) VALUES (?, 'resolvido')");
// Associa o parâmetro do ID à consulta do log
$stmt2->bind_param("i", $id);
// Executa a inserção no log
$stmt2->execute();
// Redireciona de volta para a página de alertas
header("Location: alertas.php");
exit;
?>
