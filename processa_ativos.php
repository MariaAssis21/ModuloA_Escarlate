<?php
session_start();
include 'conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Verifica se o formulário foi enviado via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Coleta e limpa os dados enviados
    $nome          = trim($_POST['nome']);
    $categoria     = trim($_POST['categoria']);
    $valor         = str_replace(['R$', '.', ','], ['', '', '.'], $_POST['valor']); // converte R$ para decimal
    $data_aquisicao = $_POST['data'];
    $numero_serie  = trim($_POST['numero']);
    $status_opcao  = $_POST['opcao'];
    $localizacao   = trim($_POST['localizacao']);

    // Converte o número da opção do select em texto legível
    $status = '';
    switch ($status_opcao) {
        case '1': $status = 'Postagem confirmada'; break;
        case '2': $status = 'Objeto postado'; break;
        case '3': $status = 'Objeto encaminhado'; break;
        case '4': $status = 'Em trânsito'; break;
        case '5': $status = 'Objeto chegou em unidade de distribuição'; break;
        case '6': $status = 'Objeto saiu para entrega ao destinatário'; break;
        case '7': $status = 'Objeto entregue ao destinatário'; break;
        default:
            die("Erro: Status inválido.");
    }

    // Verifica se todos os campos estão preenchidos
    if (empty($nome) || empty($categoria) || empty($valor) || empty($data_aquisicao) || empty($numero_serie) || empty($status) || empty($localizacao)) {
        die("Erro: Todos os campos são obrigatórios.");
    }

    // Prepara o SQL
    $sql = "INSERT INTO ativo (usuario_id, nome, categoria, valor, data_aquisicao, numero_serie, status, localizacao)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexao->prepare($sql);

    if ($stmt === false) {
        die("Erro ao preparar a consulta: " . $conexao->error);
    }

    // Liga as variáveis aos parâmetros da consulta
    $stmt->bind_param("issdssss", $usuario_id, $nome, $categoria, $valor, $data_aquisicao, $numero_serie, $status, $localizacao);

    // Executa e verifica se deu certo
    if ($stmt->execute()) {
        echo "<h1>Ativo cadastrado com sucesso!</h1>";
        echo "<p><a href='cadastro_ativos.php'>Cadastrar outro ativo</a></p>";
        echo "<p><a href='painel.php'>Voltar ao painel</a></p>";
    } else {
        echo "<h1>Erro ao cadastrar ativo!</h1>";
        echo "<p>Ocorreu um erro inesperado: " . htmlspecialchars($stmt->error) . "</p>";
    }

    $stmt->close();
    $conexao->close();

} else {
    // Se o arquivo for acessado diretamente, redireciona
    header("Location: cadastro_ativos.php");
    exit();
}
?>