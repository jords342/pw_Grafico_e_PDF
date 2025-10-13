<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Controle de Carros</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <?php if (isset($_SESSION['usuarioId'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controlador=carro&acao=formulario">Cadastrar Carro</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controlador=grafico">Gráfico</a>
                    </li>
                <?php endif; ?>
            </ul>
            <div class="d-flex align-items-center">
                <div class="form-check form-switch text-white me-3">
                    <input class="form-check-input" type="checkbox" id="interruptorModoEscuro" <?= isset($_COOKIE['tema']) && $_COOKIE['tema'] == 'escuro' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="interruptorModoEscuro">Modo Escuro</label>
                </div>
                <?php if (isset($_SESSION['usuarioId'])): ?>
                    <span class="navbar-text me-3">Olá, <?= htmlspecialchars($_SESSION['usuarioNome']); ?></span>
                    <a href="index.php?controlador=usuario&acao=logout" class="btn btn-outline-danger">Sair</a>
                <?php else: ?>
                    <a href="index.php?controlador=usuario&acao=login" class="btn btn-outline-success">Entrar</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>