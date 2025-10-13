<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuarioId']) && isset($_COOKIE['usuarioId'])) {
    require_once __DIR__ . '/../../modelos/Usuario.php';
    $usuario = buscarUsuarioPorId($_COOKIE['usuarioId']);
    if ($usuario) {
        $_SESSION['usuarioId'] = $usuario['id'];
        $_SESSION['usuarioNome'] = $usuario['nome'];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Controle de Carros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="publico/css/estilo.css">
</head>
<body class="<?= isset($_COOKIE['tema']) && $_COOKIE['tema'] == 'escuro' ? 'modo-escuro' : '' ?>">
    <?php include 'navegacao.php'; ?>
    <div class="container mt-4">