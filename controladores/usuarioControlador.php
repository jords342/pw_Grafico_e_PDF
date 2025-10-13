<?php
require_once __DIR__ . '/../modelos/Usuario.php';

function login() {
    if (isset($_SESSION['usuarioId'])) {
        header('Location: index.php');
        exit;
    }
    $erro = null;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario = autenticarUsuario($_POST['email'], $_POST['senha']);
        if ($usuario) {
            $_SESSION['usuarioId'] = $usuario['id'];
            $_SESSION['usuarioNome'] = $usuario['nome'];
            if (isset($_POST['lembrar'])) {
                $tempoExpiracao = time() + (30 * 24 * 60 * 60);
                setcookie('usuarioId', $usuario['id'], $tempoExpiracao, "/");
            }
            header('Location: index.php');
            exit;
        } else {
            $erro = "Email ou senha inválidos!";
        }
    }
    require __DIR__ . '/../visoes/usuarios/login.php';
}

function logout() {
    session_unset();
    session_destroy();
    if (isset($_COOKIE['usuarioId'])) {
        setcookie('usuarioId', '', time() - 3600, "/");
    }
    header('Location: index.php?controlador=usuario&acao=login');
    exit;
}

function cadastrar() {
    $erro = null;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (cadastrarUsuario($_POST)) {
            header('Location: index.php?controlador=usuario&acao=login&sucesso=1');
            exit;
        } else {
            $erro = "Não foi possível cadastrar. O email já pode estar em uso.";
        }
    }
    require __DIR__ . '/../visoes/usuarios/cadastro.php';
}