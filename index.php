<?php
/**
 * Ponto de Entrada Único (Front Controller)
 * 
 * Todas as requisições são direcionadas para este arquivo, que atua como um roteador,
 * determinando qual controlador e ação devem ser executados.
 */

// 1. Iniciar a sessão em todas as páginas
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 2. CORREÇÃO: Carregar funções utilitárias e obter a cotação do dólar
// Esta função agora deve estar em um arquivo separado chamado 'utilitarios.php'
// para não causar conflitos de nomes de funções.
require_once __DIR__ . '/utilitarios.php';
$cotacaoDolar = obterCotacaoDolar();


// 3. Definir valores padrão para controlador e ação
$controladorNome = $_GET['controlador'] ?? 'carro';
$acao = $_GET['acao'] ?? 'index';

// 4. Montar o nome do arquivo do controlador
// Ex: 'carro' se torna 'controladores/carroControlador.php'
$caminhoControlador = __DIR__ . "/controladores/{$controladorNome}Controlador.php";

// 5. Verificar se o arquivo do controlador existe antes de incluí-lo
if (!file_exists($caminhoControlador)) {
    // Se não existir, exibe uma mensagem de erro ou redireciona para uma página 404
    http_response_code(404);
    echo "<h1>Erro 404 - Página Não Encontrada</h1>";
    echo "<p>O controlador '{$controladorNome}' não foi encontrado.</p>";
    exit;
}

// 6. Incluir o arquivo do controlador
require_once $caminhoControlador;

// 7. Verificar se a função (ação) solicitada existe no controlador
if (function_exists($acao)) {
    // Se a função existe, chama-a
    // Ex: Se a URL for ?controlador=carro&acao=formulario, chama a função formulario()
    $acao();
} else {
    // Se a função não existe, trata o erro.
    // Pode ser chamando uma ação padrão como 'index' ou exibindo um erro.
    if (function_exists('index')) {
        // Tenta chamar a ação 'index' como um fallback seguro
        index();
    } else {
        // Se nem a ação 'index' existir, exibe um erro fatal.
        http_response_code(404);
        echo "<h1>Erro 404 - Página Não Encontrada</h1>";
        echo "<p>A ação '{$acao}' não foi encontrada no controlador '{$controladorNome}'.</p>";
        exit;
    }
}