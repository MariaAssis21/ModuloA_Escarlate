<?php
session_start();
include 'conexao.php';


if(!isset($_SESSION['usuario_id'])){
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Controle - Sistema de Reservas </title>
    <link rel="stylesheet" href="painel.css">
</head>
<main>
    <div class="container_painel">
        <h2> Bem-vindo(a) ao Painel!</h2>
        <a href="logout.php" class="logout-button"> Sair do Sistema </a>
        <hr>


          <div class="servicos">
            <ul>
                <li><a href="cadastro_ativos">Cadastro Ativos</a></li>
                <li><a href="cadastro_destinatarios">Cadastro Destinatários</a></li>
                <li><a href="cadastro_manutencao">Cadastro Manutenção</a></li>
            </ul>
          </div>
         <hr>  
    </div>
</main>
</body>
</html>
<?php
$conexao->close();
?>
