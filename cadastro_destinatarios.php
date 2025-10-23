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
    <title>Cadastro Destinatários || Youtan</title>
    <link rel="stylesheet" href="css/cadastro.css">
</head>
<body>
    <header class="menu_header">
        <nav class="menu_nav">
            <h1 class="youtan">Youtan</h1>
            <ul class="menu_list">
                <li><a href="#" class="menu_link">HOME</a></li>
                <li><a href="#" class="menu_link">SOBRE</a></li>


                <li class="menu_servico">
            <a href="#">SERVIÇOS</a>
            <ul class="opcoes_servicos">
         <li><a href="#">EXPERIÊNCIAS</a></li>
                <li><a href="#">HOSPEDAGENS</a></li>
                <li><a href="#">PACOTES</a></li>
            </ul>
        </li>


                <li><a href="#" class="menu_link">CONTATO</a></li>
                <li><a href="login.html" class="Entrar">ENTRAR</a></li>
            </ul>
        </nav>
    </header>

    <main>
    <div id="formulario_cadastro">
         <form action="processa_destinatario.php" method="POST">
        <h1>Cadastro de destinatário</h1>
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" placeholder="Digite seu nome" required><br>
        
        <label for="email">E-mail:</label><br>
        <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required><br>
        
        
        <label for="localizacao">Localização:</label><br>
           <input type="text" id="localizacao" name="localizacao" placeholder="Digite a localização" required><br>

           
        <label for="id_ativo">ID do ativo</label><br>
           <input type="number" id="id_ativo" name="id_ativo" placeholder="Digite o ID" required><br>

        
        <button type="submit">Cadastrar</button><br><br>

        <p>Clique aqui para voltar ao <a href="painel.php">Painel</a></p>
    </form>
    </div>
    </main>
</body>
</html>

    <?php
$conexao->close();
?>