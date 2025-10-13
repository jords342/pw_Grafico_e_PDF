<?php require __DIR__ . '/../templates/cabecalho.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-center">Criar Conta</h2>
                <?php if (isset($erro)): ?>
                    <div class="alert alert-danger"><?= $erro ?></div>
                <?php endif; ?>

                <form action="index.php?controlador=usuario&acao=cadastrar" method="post">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Cadastrar</button>
                    <p class="text-center mt-3">
                        Já tem uma conta? <a href="index.php?controlador=usuario&acao=login">Faça o login</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../templates/rodape.php'; ?>