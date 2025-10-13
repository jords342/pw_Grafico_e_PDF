<?php
require_once __DIR__ . '/../configuracao.php';

function autenticarUsuario($email, $senha) {
    try {
        $conexao = criarConexao();
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $sentenca = $conexao->prepare($sql);
        $sentenca->bindValue(':email', $email);
        $sentenca->execute();
        $usuario = $sentenca->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }
        return null;

    } catch (PDOException $e) {
        return null;
    }
}

function buscarUsuarioPorId($id) {
    try {
        $conexao = criarConexao();
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $sentenca = $conexao->prepare($sql);
        $sentenca->bindValue(':id', $id);
        $sentenca->execute();
        return $sentenca->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return null;
    }
}

function cadastrarUsuario($dados) {
    try {
        $conexao = criarConexao();
        $senhaHash = password_hash($dados['senha'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
        $sentenca = $conexao->prepare($sql);
        $sentenca->bindValue(':nome', $dados['nome']);
        $sentenca->bindValue(':email', $dados['email']);
        $sentenca->bindValue(':senha', $senhaHash);
        
        return $sentenca->execute();

    } catch (PDOException $e) {
        return false;
    }
}