<?php
require_once "validaUser.php";
require_once "Classes/Usuario.class.php";

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = new Usuario();

    $nomeUsuario = $_SESSION['usuario'];
    $senhaAtual = $_POST['senhaAtual'] ?? '';
    $novaSenha = $_POST['novaSenha'] ?? '';
    $confirmaSenha = $_POST['confirmaSenha'] ?? '';

    if ($novaSenha !== $confirmaSenha) {
        $msg = "<div class='alert alert-danger'>As senhas novas não coincidem.</div>";
    } else {
        if ($usuario->alterarSenha($nomeUsuario, $senhaAtual, $novaSenha)) {
            $msg = "<div class='alert alert-success'>Senha alterada com sucesso!</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Senha atual incorreta.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Alterar Senha</title>
    <link rel="stylesheet" href="CSS/base.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar-custom">
        <div class="container-navbar">
            <a class="navbar-brand-custom" href="index.php">To-Do-List</a>
            <div class="user-area">
                <img src="img/user.png" alt="Usuário" class="rounded-circle border border-light">
                <button class="btn btn-danger" onclick="window.location.href='logout.php'">Sair</button>
            </div>
        </div>
        </div>
    </nav>


    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header azul-claro text-center">
                <h4>Alterar Senha</h4>
            </div>
            <div class="card-body">
                <?= $msg ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="senhaAtual" class="form-label">Senha Atual:</label>
                        <input type="password" class="form-control" id="senhaAtual" name="senhaAtual" required>
                    </div>

                    <div class="mb-3">
                        <label for="novaSenha" class="form-label">Nova Senha:</label>
                        <input type="password" class="form-control" id="novaSenha" name="novaSenha" required>
                    </div>

                    <div class="mb-3">
                        <label for="confirmaSenha" class="form-label">Confirmar Nova Senha:</label>
                        <input type="password" class="form-control" id="confirmaSenha" name="confirmaSenha" required>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-success px-4">Salvar Alterações</button>
                        <a href="index.php" class="btn btn-secondary px-4">Voltar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>