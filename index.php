<?php
require_once "validaUser.php";
require_once "Classes/Lista.class.php";
require_once "Classes/Usuario.class.php";

$idUsuario = $_SESSION['user_id']; // ID do usuário logado
$usuarioNome = $_SESSION['usuario'] ?? 'Usuário';

// Instancia a classe Lista
$lista = new Lista();
$tarefas = $lista->listarPorUsuario($idUsuario);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Minhas Atividades</title>
    <link rel="stylesheet" href="CSS/base.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar-custom">
        <div class="container-navbar">
            <a class="navbar-brand-custom" href="index.php">To-Do-List</a>
            <div class="user-area">
                <a href="alterarSenha.php" title="Alterar Senha">
                    <img src="img/user.png" alt="Usuário" class="rounded-circle border border-light">
                </a>
                <button class="btn btn-danger" onclick="window.location.href='logout.php'">Sair</button>
            </div>
        </div>
        </div>
    </nav>

    <!-- CONTEÚDO -->
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Atividades de <?php echo htmlspecialchars($usuarioNome); ?></h2>
            <button class="btn btn-success" onclick="window.location.href='cadLista.php'">
                + Nova Atividade
            </button>
        </div>

        <?php if (!empty($tarefas)): ?>
            <table class="table table-striped table-bordered align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Tarefa</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tarefas as $t): ?>
                        <tr>
                            <td><?= $t->id ?></td>
                            <td><?= htmlspecialchars($t->tarefa) ?></td>
                            <td><?= htmlspecialchars($t->status) ?></td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="cadLista.php?id=<?= $t->id ?>" class="btn btn-outline-primary btn-sm"
                                        title="Editar">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </a>

                                    <form action="dbLista.php" method="post" class="d-inline">
                                        <input type="hidden" name="id" value="<?= $t->id ?>">
                                        <button type="submit" name="btnMudarStatus" class="btn btn-outline-warning btn-sm">
                                            <i class="bi bi-arrow-clockwise"></i>Update
                                        </button>
                                    </form>

                                    <form action="dbLista.php" method="post" class="d-inline"
                                        onsubmit="return confirm('Tem certeza que deseja excluir esta atividade?');">
                                        <input type="hidden" name="id" value="<?= $t->id ?>">
                                        <button type="submit" name="btnDeletar" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash"></i> Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning text-center">Nenhuma atividade cadastrada.</div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>