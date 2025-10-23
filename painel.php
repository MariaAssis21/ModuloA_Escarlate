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
    <title>Home || Youtan</title>
    <link rel="stylesheet" href="css/painel.css">
</head>
<main>
    <div class="container_painel">
        <h2> Bem-vindo(a) ao Painel!</h2>
        <a href="logout.php" class="logout-button"> Sair do Sistema </a>
        <hr>


          <div class="servicos">
            <ul>
                <li><a href="cadastro_ativo.php">Cadastro Ativos</a></li>
                <li><a href="cadastro_destinatarios.php">Cadastro Destinatários</a></li>
                <li><a href="cadastro_manutencao.php">Cadastro Manutenção</a></li>
                <li><a href="painel_monitoramento.php">Painel de Monitoramento</a></li>
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
