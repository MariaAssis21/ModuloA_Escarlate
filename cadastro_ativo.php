<?php
// Inicia a sessão para gerenciar usuários logados
session_start();
// Inclui a conexão com o banco de dados
include 'conexao.php';

// Verifica se o usuário está logado, se não, redireciona para a página de login
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
    <title>Cadastro Ativos || Youtan</title>
    <link rel="stylesheet" href="css/cadastro_ativos.css">
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
         <form action="processa_ativos.php" method="POST">
        <h1>Cadastro de Ativos</h1>
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" placeholder="Digite o nome" required><br>
        
        <label for="categoria">Categoria:</label><br>
        <input type="text" id="categoria" name="categoria" placeholder="Digite a categoria" required><br>
        
        <label for="valor">Digite o valor:</label><br>
    <input type="text" id="valor" name="valor" placeholder="R$ 0,00" oninput="formatarMoeda(this)"><br>

   <!-- <script src="cadastro_ativos.js"></script> -->

     <label for="data">Data de aquisição:</label><br>
        <input type="date" id="data" name="data" placeholder="Digite a data de aquisição" required><br>

          <label for="numero">Número de série:</label><br>
        <input type="number" id="numero" name="numero" placeholder="Digite o número de série" required><br>

      <label>Status:</label><br>
        <select name="opcao">
  <option value="1">Postagem confirmada</option>
  <option value="2">Objeto postado</option>
  <option value="3">Objeto encaminhado</option>
  <option value="4">Em trânsito</option>
  <option value="5">Objeto chegou em unidade de distribuição</option>
  <option value="6">Objeto saiu para entrega ao destinatário</option>
  <option value="7">Objeto entregue ao destinatário</option>
</select><br>

        <label for="localizacao">Localização:</label><br>
           <input type="text" id="localizacao" name="localizacao" placeholder="Digite a localização" required><br>

        
        <button type="submit">Cadastrar ativo</button><br><br>

        <p>Clique aqui para voltar ao <a href="painel.php">Painel</a></p>
    </form>
    </div>
    </main>
</body>
</html>

<?php
$conexao->close();
?>