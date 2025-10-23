<?php
// Inclui a conexão com o banco de dados
require_once 'conexao.php';

// Pega as variáveis enviadas via POST do formulário
$id_ativo = $_POST['id_ativo'];// ID do ativo que passou pela manutenção
$tipo = $_POST['tipo'];// Tipo de manutenção (preventiva, corretiva etc.)
$data_manutencao = $_POST['data_manutencao'];// Data da manutenção
$responsavel_tecnico = $_POST['responsavel_tecnico'];// Técnico responsável pela manutenção
$custo = $_POST['custo'];// Custo da manutenção
$descricao = $_POST['descricao'];// Descrição detalhada da manutenção

// Prepara a query SQL para inserir os dados na tabela de manutenções
$sql = "INSERT INTO manutencoes (id_ativo, tipo, data_manutencao, responsavel_tecnico, custo, descricao)
        VALUES (?, ?, ?, ?, ?, ?)";

// Prepara a declaração (stmt) para prevenção de SQL Injection
$stmt = $conexao->prepare($sql);
// Associa os parâmetros da query com os valores recebidos
// Tipos: i = inteiro, s = string, d = double/decimal
$stmt->bind_param("isssds", $id_ativo, $tipo, $data_manutencao, $responsavel_tecnico, $custo, $descricao);

// Executa a query e verifica se foi bem-sucedida
if ($stmt->execute()) {
    // Mensagens de sucesso com links para histórico e retorno ao painel
    echo "<p> Manutenção registrada com sucesso!</p>";
    echo "<a href='historico_manutencao.php?id_ativo=$id_ativo'>Ver histórico em site</a><br>";
    echo "<a href='historico_manutencao_pdf.php?id_ativo=$id_ativo'>Ver histórico pdf</a><br>";
    echo "<a href='painel.php'>Voltar ao painel</a><br>";
    echo "<a href='cadastro_manutencao.php'>Voltar para manutenção</a><br>";
} else {
        // Mensagem de erro caso a inserção falhe
    echo "<p> Erro ao cadastrar: " . $stmt->error . "</p>";
}


