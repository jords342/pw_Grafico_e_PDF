<?php
require_once __DIR__ . '/../configuracao.php';

// ATUALIZAÇÃO: A função agora aceita um parâmetro para ordenação
function listarCarros($ordenacao = '') {
    $conexao = criarConexao();
    
    // SQL base
    $sql = "SELECT *, DATE_FORMAT(dataFabricacao, '%d/%m/%Y') as dataFabricacaoBr FROM tbCarro";

    // Lógica para adicionar a cláusula ORDER BY de forma segura
    switch ($ordenacao) {
        case 'preco_asc':
            $sql .= " ORDER BY preco ASC";
            break;
        case 'preco_desc':
            $sql .= " ORDER BY preco DESC";
            break;
        case 'nome_asc':
            $sql .= " ORDER BY nome ASC";
            break;
        default:
            // Ordenação padrão, se nenhuma for especificada
            $sql .= " ORDER BY idCarro DESC";
            break;
    }

    $sentenca = $conexao->query($sql);
    return $sentenca->fetchAll(PDO::FETCH_ASSOC);
}

function buscarCarroPorId($id) {
    $conexao = criarConexao();
    $sentenca = $conexao->prepare("SELECT * FROM tbCarro WHERE idCarro = ?");
    $sentenca->execute([$id]);
    return $sentenca->fetch(PDO::FETCH_ASSOC);
}

function salvarCarro($dados, $arquivoFoto) {
    $conexao = criarConexao();
    
    $nomeFotoFinal = $dados['fotoAtual'] ?? null;

    if (isset($arquivoFoto) && $arquivoFoto['error'] == 0) {
        if (!empty($nomeFotoFinal) && file_exists(__DIR__ . '/../publico/uploads/' . $nomeFotoFinal)) {
            unlink(__DIR__ . '/../publico/uploads/' . $nomeFotoFinal);
        }

        $extensao = pathinfo($arquivoFoto['name'], PATHINFO_EXTENSION);
        $nomeFotoFinal = uniqid() . '.' . $extensao;
        $caminhoDestino = __DIR__ . '/../publico/uploads/' . $nomeFotoFinal;
        move_uploaded_file($arquivoFoto['tmp_name'], $caminhoDestino);
    }

    if (isset($dados['idCarro']) && !empty($dados['idCarro'])) {
        $sql = "UPDATE tbCarro SET nome = ?, descricao = ?, dataFabricacao = ?, preco = ?, foto = ? WHERE idCarro = ?";
        $params = [$dados['nome'], $dados['descricao'], $dados['dataFabricacao'], $dados['preco'], $nomeFotoFinal, $dados['idCarro']];
    } else {
        $sql = "INSERT INTO tbCarro (nome, descricao, dataFabricacao, preco, foto) VALUES (?, ?, ?, ?, ?)";
        $params = [$dados['nome'], $dados['descricao'], $dados['dataFabricacao'], $dados['preco'], $nomeFotoFinal];
    }
    
    $sentenca = $conexao->prepare($sql);
    return $sentenca->execute($params);
}

function excluirCarro($id) {
    $conexao = criarConexao();
    
    $carro = buscarCarroPorId($id);
    if ($carro && !empty($carro['foto'])) {
        $caminhoFoto = __DIR__ . '/../publico/uploads/' . $carro['foto'];
        if (file_exists($caminhoFoto)) {
            unlink($caminhoFoto);
        }
    }
    
    $sentenca = $conexao->prepare("DELETE FROM tbCarro WHERE idCarro = ?");
    return $sentenca->execute([$id]);
}
?>