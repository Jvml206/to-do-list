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

    <nav class="navbar navbar-expand-lg bg-primary px-4">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand fw-bold text-white" href="index.php">HOME</a>
            <div class="d-flex align-items-center gap-3">
                <img src="img/user.png" alt="Usuário" class="rounded-circle border border-light">
                <button class="btn btn-danger" onclick="window.location.href='logout.php'">Sair</button>
            </div>
        </div>
    </nav>


    <div class="container mt-5" >
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
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

                    <button type="submit" class="btn btn-success w-100">Salvar Alterações</button>
                    <a href="index.php" class="btn btn-secondary w-100 mt-2">Voltar</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
