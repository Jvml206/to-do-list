<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/base.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Cadastro de Tarefas</title>
</head>

<body>
    <nav class="navbar-custom">
        <div class="container-navbar">
            <a class="navbar-brand-custom" href="index.php">To-Do-List</a>
            <div class="d-flex align-items-center gap-3">
                <a href="alterarSenha.php" title="Alterar Senha">
                    <img src="img/user.png" alt="Usuário" class="rounded-circle border border-light">
                </a>
                <button class="btn btn-danger" onclick="window.location.href='logout.php'">Sair</button>
            </div>
        </div>
    </nav>

    <main class="container my-5">
        <?php
        require_once "validaUser.php";
        spl_autoload_register(function ($class) {
            require_once "Classes/{$class}.class.php";
        });

        $lista = null;
        $idUsuarioLogado = $_SESSION['user_id'] ?? 0;

        if (isset($_GET['id'])) {
            $editar = new Lista();
            $id = intval($_GET['id']);
            $resultado = $editar->search("id", $id);
            $lista = is_array($resultado) && count($resultado) > 0 ? $resultado[0] : null;

            // 🔒 Verifica se a tarefa pertence ao usuário logado
            if ($lista && isset($lista->fkIdUsuario)) {
                if ($lista->fkIdUsuario != $idUsuarioLogado && $idUsuarioLogado != 0) {
                    echo "<script>alert('Acesso negado! Você não pode editar esta tarefa.'); window.location='index.php';</script>";
                    exit;
                }
            }
        }
        ?>

        <h2 class="text-center mb-4"><?= $lista ? "Editar Tarefa" : "Nova Tarefa" ?></h2>

        <form action="dbLista.php" method="post" class="row g-3 mt-3">
            <input type="hidden" name="id" value="<?php echo $lista->id ?? ''; ?>">

            <div class="col-md-12">
                <label for="tarefa" class="form-label">Tarefa</label>
                <textarea name="tarefa" id="tarefa" placeholder="Descreva a tarefa" rows="3" required
                    class="form-control"><?php echo $lista->tarefa ?? ''; ?></textarea>
            </div>

            <div class="col-md-6">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="Pendente" <?= (isset($lista->status) && $lista->status == 'Pendente') ? 'selected' : ''; ?>>Pendente</option>
                    <option value="Concluída" <?= (isset($lista->status) && $lista->status == 'Concluída') ? 'selected' : ''; ?>>Concluída</option>
                </select>
            </div>

            <div class="col-12 mt-3 d-flex gap-2">
                <button type="submit" name="btnCadastrar" class="btn btn-success">Salvar</button>
                <a href="index.php" class="btn btn-outline-secondary">Voltar</a>
            </div>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>