<?php
require_once 'conexao.php';

// Consulta 1 – Ativos por categoria
$categorias = $conexao->query("SELECT categoria, COUNT(*) AS total FROM ativo GROUP BY categoria");

// Consulta 2 – Ativos por status
$status = $conexao->query("SELECT status, COUNT(*) AS total FROM ativo GROUP BY status");

// Consulta 3 – Custos de manutenção por mês
$custos = $conexao->query("SELECT DATE_FORMAT(data_manutencao, '%Y-%m') AS mes, SUM(custo) AS total FROM manutencoes GROUP BY mes ORDER BY mes");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Dashboard Gerencial</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #f5f6fa;
    margin: 0;
}
.container {
    width: 95%;
    max-width: 1100px;
    margin: 30px auto;
}
.card {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}
h2 {
    text-align: center;
    color: #333;
}
.filter {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 20px;
}
button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 8px 14px;
    border-radius: 5px;
    cursor: pointer;
}
button:hover { background-color: #0056b3; }
canvas { width: 100% !important; max-height: 400px; }
</style>
</head>
<body>
<div class="container">
    <h2> Painel Gerencial de Ativos</h2>

    <a href="painel.php">Voltar Para o Painel</a>

    <div class="filter">
        <button onclick="window.location='exportar_pdf.php'">Exportar PDF</button>&nbsp;
        <button onclick="window.location='exportar_excel.php'">Exportar Excel</button>
    </div>

    <div class="card">
        <h3>Ativos por Categoria</h3>
        <canvas id="graficoCategoria"></canvas>
    </div>

    <div class="card">
        <h3>Ativos por Status</h3>
        <canvas id="graficoStatus"></canvas>
    </div>

    <div class="card">
        <h3>Custo de Manutenção Mensal</h3>
        <canvas id="graficoCustos"></canvas>
    </div>
</div>

<script>
const categorias = {
    labels: [<?php while($c = $categorias->fetch_assoc()) echo "'{$c['categoria']}',"; ?>],
    data: [<?php $categorias->data_seek(0); while($c = $categorias->fetch_assoc()) echo "{$c['total']},"; ?>]
};
const status = {
    labels: [<?php while($s = $status->fetch_assoc()) echo "'{$s['status']}',"; ?>],
    data: [<?php $status->data_seek(0); while($s = $status->fetch_assoc()) echo "{$s['total']},"; ?>]
};
const custos = {
    labels: [<?php while($c = $custos->fetch_assoc()) echo "'{$c['mes']}',"; ?>],
    data: [<?php $custos->data_seek(0); while($c = $custos->fetch_assoc()) echo "{$c['total']},"; ?>]
};

new Chart(document.getElementById('graficoCategoria'), {
    type: 'pie',
    data: {
        labels: categorias.labels,
        datasets: [{ data: categorias.data, backgroundColor: ['#007bff','#28a745','#ffc107','#dc3545'] }]
    }
});

new Chart(document.getElementById('graficoStatus'), {
    type: 'doughnut',
    data: {
        labels: status.labels,
        datasets: [{ data: status.data, backgroundColor: ['#17a2b8','#6f42c1','#fd7e14','#20c997'] }]
    }
});

new Chart(document.getElementById('graficoCustos'), {
    type: 'line',
    data: {
        labels: custos.labels,
        datasets: [{
            label: 'Custo Total (R$)',
            data: custos.data,
            fill: false,
            borderColor: '#007bff',
            tension: 0.1
        }]
    }
});
</script>
</body>
</html>
