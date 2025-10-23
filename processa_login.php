<?php
session_start();
include 'conexao.php';


$email = $_POST['email'];
$senha_formulario = $_POST['senha'];


// Busca o usuário pelo email
$sql = "SELECT id, nome, senha, perfil FROM usuario WHERE email = ? LIMIT 1";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();


// Verifica se encontrou o usuário
if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();


    // Verifica a senha
    if (password_verify($senha_formulario, $usuario['senha'])) {
        // Cria as variáveis de sessão
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['perfil'] = $usuario['perfil'];


        // Redireciona conforme o perfil
        if ($usuario['perfil'] === 'admin') {
            header("Location: painel.php"); // painel de administrador
        } else {
            header("Location: painel2.php");  // painel de usuário comum
        }
        exit;
    } else {
        echo "<h1>Erro</h1>";
        echo "<p>Senha incorreta. <a href='login.html'>Tentar novamente</a></p>";
    }
} else {
    echo "<h1>Erro</h1>";
    echo "<p>Email não encontrado. <a href='login.html'>Tentar novamente</a></p>";
}


$stmt->close();
$conexao->close();
?>
