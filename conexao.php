<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "youtan";

$conexao = new mysqli($hostname, $username, $password, $database);

if ($conexao->connect_error) {
    die("Erro ao conectar com o banco de dados:" . $conexao->connect_error);
}


?>