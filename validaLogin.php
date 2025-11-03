<?php
session_start();
spl_autoload_register(function ($class) {
    require_once "Classes/{$class}.class.php";
});

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = new Usuario();
    $usuario->setUsuario($_POST['usuario']);
    $usuario->setSenhaUsuario($_POST['senha']);

    $mensagem = $usuario->login();
    if ($mensagem !== true) {
        echo "<script>alert('$mensagem'); window.location.href='login.php';</script>";
    }
}
