<?php

/**
 * Busca a cotação do Dólar (USD para BRL) em tempo real de uma API externa.
 * Inclui tratamento de exceções para falhas na comunicação ou formato de resposta.
 * 
 * @return float A cotação atual do dólar ou um valor padrão em caso de falha.
 */
function obterCotacaoDolar() {
    $url = 'https://economia.awesomeapi.com.br/json/last/USD-BRL';

    try {
        $json = @file_get_contents($url);

        if ($json === false) {
            throw new Exception("Não foi possível conectar à API de cotação.");
        }
        $dados = json_decode($json, true);

        if (!isset($dados['USDBRL']['bid'])) {
            throw new Exception("Resposta da API em formato inesperado.");
        }
        return floatval($dados['USDBRL']['bid']);

    } catch (Exception $e) {
        // error_log("Erro ao buscar cotação: " . $e->getMessage());
        return 5.30;
    }
}