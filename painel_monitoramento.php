<?php
require_once 'conexao.php';

// filtros opcionais
$filtro = "";
if (isset($_GET['categoria']) && $_GET['categoria'] != '') {
    $filtro = "WHERE a.categoria = '" . $_GET['categoria'] . "'";
}

// busca todos os ativos e seus responsáveis
$sql = "SELECT a.id, a.nome AS nome_ativo, a.categoria, a.localizacao,
               d.nome AS responsavel, d.email_usuario
        FROM ativo a
        LEFT JOIN destinatario d ON a.id_destinatario = d.id_destinatario
        $filtro
        ORDER BY a.nome";

$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2> Monitoramento de Ativos</h2>

<form method="GET">
    <label>Filtrar por categoria:</label>
    <input type="text" name="categoria" placeholder="ex: Computadores">
    <button type="submit">Filtrar</button>
    <a href="painel_monitoramento.php">Limpar</a>
</form>

<p>Clique aqui para voltar ao <a href="painel.php">Painel</a></p>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Ativo</th>
        <th>Categoria</th>
        <th>Localização Atual</th>
        <th>Responsável</th>
        <th>E-mail</th>
        <th>Ações</th>
    </tr>



<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nome_ativo']}</td>
                <td>{$row['categoria']}</td>
                <td>{$row['localizacao']}</td>
                <td>{$row['responsavel']}</td>
                <td>{$row['email_usuario']}</td>
                <td><a href='atualizar_localizacao.php?id={$row['id']}'>Atualizar</a></td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='7'>Nenhum ativo encontrado.</td></tr>";
}
?>
</table>
</body>
</html>