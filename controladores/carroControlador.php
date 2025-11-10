<?php
require_once __DIR__ . '/../modelos/Carro.php';

function index() {
    // A variável $cotacaoDolar agora vem do index.php principal
    global $cotacaoDolar;
    
    $carros = listarCarros();
    require __DIR__ . '/../visoes/carros/index.php';
}

function formulario() {
    if (!isset($_SESSION['usuarioId'])) {
        header('Location: index.php?controlador=usuario&acao=login');
        exit;
    }
    $carro = null;
    $titulo = "Cadastrar Novo Carro";
    if (isset($_GET['id'])) {
        $carro = buscarCarroPorId($_GET['id']);
        $titulo = "Editar Carro";
    }
    require __DIR__ . '/../visoes/carros/formulario.php';
}

function salvar() {
    if (!isset($_SESSION['usuarioId'])) {
        header('Location: index.php?controlador=usuario&acao=login');
        exit;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        salvarCarro($_POST, $_FILES['foto']);
    }
    header('Location: index.php');
    exit;
}

function excluir() {
    if (!isset($_SESSION['usuarioId'])) {
        header('Location: index.php?controlador=usuario&acao=login');
        exit;
    }
    if (isset($_GET['id'])) {
        excluirCarro($_GET['id']);
    }
    header('Location: index.php');
    exit;
}