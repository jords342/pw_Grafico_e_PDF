<?php require __DIR__ . '/../templates/cabecalho.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Carros Disponíveis</h1>
</div>
    
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
                        <p class="card-text"><strong>Preço:</strong> R$ <?= number_format($carro['preco'], 2, ',', '.') ?></p>
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