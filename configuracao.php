<?php
define('DB_HOST', 'localhost');
define('DB_NOME', 'controleCarro'); 
define('DB_USUARIO', 'root');
define('DB_SENHA', ''); 

function criarConexao() {
    try {
        $conexao = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NOME, DB_USUARIO, DB_SENHA);
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexao;
    } catch (PDOException $e) {
        die("Erro na conexão com o banco de dados: " . $e->getMessage());
    }
}
?>