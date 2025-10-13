<?php require __DIR__ . '/../templates/cabecalho.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-center">Login</h2>
                
                <?php if (isset($erro)): ?>
                    <div class="alert alert-danger"><?= $erro ?></div>
                <?php endif; ?>

                <?php if (isset($_GET['sucesso'])): ?>
                    <div class="alert alert-success">Cadastro realizado com sucesso! Faça o login.</div>
                <?php endif; ?>

                <form action="index.php?controlador=usuario&acao=login" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="lembrar" name="lembrar">
                        <label class="form-check-label" for="lembrar">Lembrar-me</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>
                <div class="text-center mt-3">
                    <p>Não tem uma conta? <a href="index.php?controlador=usuario&acao=cadastrar">Cadastre-se</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../templates/rodape.php'; ?>