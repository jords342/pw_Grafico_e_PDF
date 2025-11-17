<?php require __DIR__ . '/../templates/cabecalho.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Carros Disponíveis</h1>
</div>

<!-- NOVO: Formulário com o Selectbox para ordenação -->
<div class="row mb-4">
    <div class="col-md-4">
        <form action="index.php" method="get" id="form-ordenacao">
            <input type="hidden" name="controlador" value="carro">
            <input type="hidden" name="acao" value="index">
            <select name="ordenar" class="form-select" onchange="document.getElementById('form-ordenacao').submit()">
                <option value="">Ordenar por Padrão</option>
                <option value="preco_asc" <?= ($ordenacaoAtual ?? '') == 'preco_asc' ? 'selected' : '' ?>>Preço: Menor para Maior</option>
                <option value="preco_desc" <?= ($ordenacaoAtual ?? '') == 'preco_desc' ? 'selected' : '' ?>>Preço: Maior para Menor</option>
                <option value="nome_asc" <?= ($ordenacaoAtual ?? '') == 'nome_asc' ? 'selected' : '' ?>>Nome: A-Z</option>
            </select>
        </form>
    </div>
</div>
<!-- FIM DO NOVO CÓDIGO -->
    
<div class="row">
    <?php if (empty($carros)): ?>
        <div class="col-12"><div class="alert alert-info text-center">Nenhum carro cadastrado ainda.</div></div>
    <?php else: ?>
        <?php foreach ($carros as $carro): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="publico/uploads/<?= htmlspecialchars($carro['foto'] ?: 'placeholder.png') ?>" class="card-img-top card-img-fixed" alt="<?= htmlspecialchars($carro['nome']) ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($carro['nome']) ?></h5>
                        <p class="card-text flex-grow-1"><?= htmlspecialchars(substr($carro['descricao'], 0, 100)) . '...' ?></p>
                        
                        <!-- Exibição do preço em Reais e Dólares -->
                        <?php
                            $precoValido = is_numeric($carro['preco']) && $carro['preco'] > 0;
                            if ($precoValido):
                                $precoEmDolar = $carro['preco'] / $cotacaoDolar;
                        ?>
                            <p class="card-text">
                                <strong>Preço (BRL):</strong> R$ <?= number_format($carro['preco'], 2, ',', '.') ?><br>
                                <!-- Valor em dólar ao lado do valor em reais -->
                                <strong>Preço (USD):</strong> $ <?= number_format($precoEmDolar, 2, ',', '.') ?>
                            </p>
                        <?php else: ?>
                            <p class="card-text text-danger">
                                <strong>Preço:</strong> Valor indisponível
                            </p>
                        <?php endif; ?>
                        <!-- Fim da Exibição -->

                        <p class="card-text"><small>Fabricado em: <?= $carro['dataFabricacaoBr'] ?></small></p> 
                        <?php if (isset($_SESSION['usuarioId'])): ?>
                            <div class="mt-auto pt-2 border-top d-flex justify-content-center">
                                <a href="index.php?controlador=carro&acao=formulario&id=<?= $carro['idCarro'] ?>" class="btn btn-warning btn-sm mx-1">Editar</a>
                                <a href="index.php?controlador=carro&acao=excluir&id=<?= $carro['idCarro'] ?>" class="btn btn-danger btn-sm mx-1" onclick="return confirm('Tem certeza que deseja excluir este carro?')">Excluir</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../templates/rodape.php'; ?>