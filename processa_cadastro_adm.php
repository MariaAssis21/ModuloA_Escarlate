<?php

include 'conexao.php';

//colocar dentro das variáveis o que foi colocado no formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$perfil_opcao = $_POST['opcao'];

if ($perfil_opcao == '1') {
    $perfil = 'admin';
} elseif ($perfil_opcao == '2') {
    $perfil = 'comum'; // ou 'Usuário', se preferir
} else {
    die("Erro: Opção de perfil inválida.");
}


//ver se nenhum está vazio
if (empty($nome) || empty($email) || empty($senha) || empty($perfil)){
    die("Erro: Todos os campos são obrigatórios.");
}

//usa um hash para proteger a senha no banco
 $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

 //inserir no sql
 $sql ="INSERT INTO usuario (nome, email, senha, perfil) VALUES (?, ?, ?, ?)";

 //usar um tratamento de variável para segurança
 $stmt = $conexao->prepare($sql);
 if ($stmt === false) {
    die("Erro ao preparar a consulta: " . $conexao->error);
 }
 $stmt->bind_param("ssss", $nome, $email, $senha_hash, $perfil);

 if($stmt-> execute()){
    //se executar manda para a página de login para logar
    echo "<h1> Cadastro realizado com sucesso! </h1>";
    echo "<p> Você já pode fazer o login. <a href='login.html'> ir para a página de login </a></p>";
 } else {
    if($conexao-> error === 1062) {
        //se não mostra erro de email repetido
        echo"<h1> Erro ao cadastrar. </h1>";
        echo "<p> O e-mail informado já está em uso. Por favor, utilize outro e-mail. <a href='cadastro.html'> Tentar novamente </a></p>";
    } else {
        //ou mostra erro inesperado
        echo "<h1> Erro ao cadastrar. </h1>";
        echo "<p>Ocorreu um erro inesperado. Por favor, tente novamente mais tarde. Erro:" . $stmt-> error . "</p>";
    }
 }
 //fecha as variáveis de tratamento e conexão
 $stmt-> close();
 $conexao -> close();
?>
