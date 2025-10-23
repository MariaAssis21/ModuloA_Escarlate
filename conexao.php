<?php
// Configurações do banco de dados
$hostname = "localhost";// Endereço do servidor MySQL (localhost se estiver na mesma máquina)
$username = "root"; // Usuário do MySQL
$password = "";// Senha do MySQL (vazia por padrão no XAMPP/WAMP)
$database = "youtan";// Nome do banco de dados que será usado
// Cria a conexão com o banco de dados usando a classe mysqli
$conexao = new mysqli($hostname, $username, $password, $database);
// Verifica se houve erro na conexão
if ($conexao->connect_error) {
     // Encerra o script e exibe a mensagem de erro caso a conexão falhe
    die("Erro ao conectar com o banco de dados:" . $conexao->connect_error);
}


// A conexão está pronta para ser usada nas consultas SQL
?>