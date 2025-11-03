<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: home.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do-List - Login</title>
    <link rel="stylesheet" href="base.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<?php
if (filter_has_var(INPUT_POST, "logar")) {
    spl_autoload_register(function ($class) {
        require_once "Classes/{$class}.class.php";
    });
    $usuario = new Usuario;
    $usuario->setUsuario(filter_input(INPUT_POST, 'usuario'));
    $usuario->setSenhaUsuario(filter_input(INPUT_POST, 'senha'));
    $mensagem = $usuario->login();
    echo "<script>alert('$mensagem');</script>";
}
?>
<body>

<div class="left-side">
    <h1>To-Do-List</h1>
    <p>Suas atividades em um só lugar.</p>
</div>

<div class="right-side">
    <div class="login-box">
        <h3 class="mb-3 text-center">Login</h3>
        <form action="validaLogin.php" method="POST" class="border p-4 rounded shadow-sm bg-light">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuário</label>
                <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Digite seu usuário" required>
            </div>

            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" name="senha" id="senha" class="form-control" placeholder="********" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Entrar</button>

            <div class="text-center mt-3">
                <p>Não tem uma conta? 
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalCadastro">Clique aqui</a>
                </p>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalCadastro" tabindex="-1" aria-labelledby="modalCadastroLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalCadastroLabel">Criar Conta</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <form action="dbUsuario.php" method="POST" class="p-3">
                <div class="mb-3">
                    <label for="novoUsuario" class="form-label">Usuário</label>
                    <input type="text" name="usuario" id="novoUsuario" class="form-control" placeholder="Digite seu nome de usuário" required>
                </div>

                <div class="mb-3">
                    <label for="novaSenha" class="form-label">Senha</label>
                    <input type="password" name="senha" id="novaSenha" class="form-control" placeholder="********" required>
                </div>

                <div class="text-end">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" name="btnCadastrar" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
