<?php
// Inicia a sessão para gerenciar usuários logados
session_start();
// Inclui a conexão com o banco de dados
include 'conexao.php';

// Verifica se o usuário está logado; caso contrário, redireciona para a página de login
if(!isset($_SESSION['usuario_id'])){
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manutenção Cadastro || Youtan</title>
</head>
<body>
    <h2>Cadastro de Manutenção</h2>

    <div class="container_forms">
    <form action="processa_manutencao.php" method="POST">
    <label>ID do Ativo:</label>
    <input type="number" name="id_ativo" required><br><br>

    <label>Tipo:</label>
    <select name="tipo" required>
        <option value="">Selecione</option>
        <option value="Corretiva">Corretiva</option>
        <option value="Preventiva">Preventiva</option>
    </select><br><br>

    <label>Data da Manutenção:</label>
    <input type="date" name="data_manutencao" required><br><br>

    <label>Responsável Técnico:</label>
    <input type="text" name="responsavel_tecnico" required><br><br>

    <label>Custo (R$):</label>
    <input type="number" step="0.01" name="custo" required><br><br>

    <label>Descrição do Serviço:</label><br>
    <textarea name="descricao" rows="4" cols="40"></textarea><br><br>

    <button type="submit">Cadastrar</button>

    <p>Clique aqui para voltar ao <a href="painel.php">Painel</a></p>
    </form>
</body>
</html>

