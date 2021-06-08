<?php
// Arquivo de configuração do banco de dados

// DADOS BANCO DE DADOS
$user = "root"; 
$password = ""; 
$database = "boletins"; 
$hostname = "localhost"; 
#Conecta banco de dados 
$mysqli = new mysqli($hostname, $user, $password, $database);
if ($mysqli->connect_errno) {
   echo "Falha ao conectar: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
   exit();
}

?>