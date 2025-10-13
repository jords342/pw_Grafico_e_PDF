<?php
require_once __DIR__ . '/../modelos/Carro.php';

function index() {
    if (!isset($_SESSION['usuarioId'])) {
        header('Location: index.php?controlador=usuario&acao=login');
        exit;
    }
    $carros = listarCarros();
    $nomes = array_column($carros, 'nome');
    $precos = array_column($carros, 'preco');
    require __DIR__ . '/../visoes/grafico/index.php';
}