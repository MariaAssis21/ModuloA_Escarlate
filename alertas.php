<?php
// Inclui a conexão com o banco de dados
require_once 'conexao.php';
// Consulta para buscar todos os alertas junto com o nome do ativo correspondente
// Ordena os resultados pela data do alerta em ordem decrescente (mais recentes primeiro)
$sql = "SELECT a.id_alerta, a.tipo_alerta, a.mensagem, a.data_alerta, a.resolvido, at.nome_ativo
        FROM alertas a
        JOIN ativo at ON a.id_ativo = at.id_ativo
        ORDER BY a.data_alerta DESC";
        // Executa a consulta e armazena o resultado
$result = $conexao->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Painel de Alertas</title>
<style>
    /* Estilo geral da página */
body {
    font-family: Arial, sans-serif;
    background: #f8f9fa;
    margin: 0;
    padding: 0;
}
/* Container centralizado para o conteúdo */
.container {
    max-width: 900px;
    margin: 50px auto;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    padding: 20px;
}
/* Título centralizado */
h2 {
    text-align: center;
    color: #333;
}

/* Estilo da tabela */
table {
    width: 100%;
    border-collapse: collapse;
}
/* Estilo das células da tabela */
th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}
/* Cabeçalho da tabela */
th {
    background-color: #007bff;
    color: white;
}
/* Linha de alerta resolvido */
.resolvido {
    background-color: #d4edda;
}
/* Linha de alerta pendente */
.pendente {
    background-color: #f8d7da;
}
/* Estilo dos botões de ação */
.btn {
    padding: 6px 12px;
    background: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
}

/* Efeito hover do botão */
.btn:hover {
    background: #0056b3;
}
</style>
</head>
<body>
<div class="container">
    <h2>🔔 Alertas do Sistema</h2>
    <table>
        <tr>
            <th>Ativo</th>
            <th>Tipo</th>
            <th>Mensagem</th>
            <th>Data</th>
            <th>Status</th>
            <th>Ação</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
            <tr class="<?= $row['resolvido'] ? 'resolvido' : 'pendente' ?>">
                <td><?= $row['nome_ativo'] ?></td>
                <td><?= ucfirst($row['tipo_alerta']) ?></td>
                <td><?= $row['mensagem'] ?></td>
                <td><?= date('d/m/Y H:i', strtotime($row['data_alerta'])) ?></td>
                <td><?= $row['resolvido'] ? 'Resolvido' : 'Pendente' ?></td>
                <td>
                    <?php if(!$row['resolvido']) { ?>
                        <a class="btn" href="resolver_alerta.php?id=<?= $row['id_alerta'] ?>">Marcar como resolvido</a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
