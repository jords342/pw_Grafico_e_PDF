<?php require __DIR__ . '/../templates/cabecalho.php'; ?>

<h2><?= htmlspecialchars($titulo) ?></h2>
<hr>
<!-- action aponta para o roteador -->
<form action="index.php?controlador=carro&acao=salvar" method="post" enctype="multipart/form-data">
    <input type="hidden" name="idCarro" value="<?= $carro['idCarro'] ?? '' ?>">
    <!-- 'foto_atual' alterado para 'fotoAtual' -->
    <input type="hidden" name="fotoAtual" value="<?= $carro['foto'] ?? '' ?>">

    <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($carro['nome'] ?? '') ?>" required>
    </div>
    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <textarea class="form-control" id="descricao" name="descricao" rows="4" required><?= htmlspecialchars($carro['descricao'] ?? '') ?></textarea>
    </div>
    <div class="mb-3">
        <label for="dataFabricacao" class="form-label">Data de Fabricação</label>
        <input type="date" class="form-control" id="dataFabricacao" name="dataFabricacao" value="<?= htmlspecialchars($carro['dataFabricacao'] ?? '') ?>" required>
    </div>
    <div class="mb-3">
        <label for="preco" class="form-label">Preço</label>
        <input type="number" step="0.01" class="form-control" id="preco" name="preco" value="<?= htmlspecialchars($carro['preco'] ?? '') ?>" required>
    </div>
    <div class="d-flex justify-content-center">
        <img id="previewFoto" class="mt-2" src="<?= !empty($carro['foto']) ? 'publico/uploads/' . htmlspecialchars($carro['foto']) : '' ?>" width="150" alt="Preview da foto" <?= empty($carro['foto']) ? 'style="display: none;"' : '' ?>>
    </div>
    <div class="d-flex justify-content-center">
        <div class="mb-3">
            <label for="foto" class="form-label">Foto do Carro</label>
            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
        </div>
    </div>
    <hr>
    <div class="d-flex justify-content-center gap-2">
        <a href="index.php" class="btn btn-secondary">Voltar</a>
        <button type="submit" class="btn btn-success">Salvar</button>
    </div>
</form>

<?php require __DIR__ . '/../templates/rodape.php'; ?>