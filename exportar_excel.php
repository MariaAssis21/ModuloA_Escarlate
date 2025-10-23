<?php
require_once 'conexao.php';
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=relatorio_ativos.xls");

$result = $conn->query("SELECT categoria, COUNT(*) AS total FROM ativos GROUP BY categoria");

echo "Categoria\tTotal\n";
while ($row = $result->fetch_assoc()) {
    echo "{$row['categoria']}\t{$row['total']}\n";
}
?>
