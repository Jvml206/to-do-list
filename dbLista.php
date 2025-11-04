<?php
require_once "validaUser.php";
spl_autoload_register(function ($class) {
    require_once "Classes/{$class}.class.php";
});

$lista = new Lista();
$fkIdUsuario = $_SESSION['user_id'] ?? null;

if (!$fkIdUsuario) {
    echo "<script>alert('Usuário não logado!'); window.location='login.php';</script>";
    exit;
}

if (filter_has_var(INPUT_POST, "btnCadastrar")) {

    $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
    $lista->setTarefa(filter_input(INPUT_POST, "tarefa", FILTER_SANITIZE_STRING));
    $lista->setStatus(filter_input(INPUT_POST, "status", FILTER_SANITIZE_STRING));
    $lista->setFkIdUsuario($fkIdUsuario);

    if (empty($id)) {
        // Novo cadastro
        if ($lista->add()) {
            header("Location: index.php");
            exit;
        } else {
            echo "<script>alert('Erro ao adicionar tarefa.'); window.history.back();</script>";
        }
    } else {
        // Atualização
        if ($lista->update('id', $id)) {
            header("Location: index.php");
            exit;
        } else {
            echo "<script>alert('Erro ao alterar tarefa.'); window.history.back();</script>";
        }
    }

} elseif (filter_has_var(INPUT_POST, "btnDeletar")) {

    $id = intval(filter_input(INPUT_POST, "id"));
    if ($lista->delete("id", $id)) {
        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Erro ao excluir tarefa.'); window.history.back();</script>";
    }

} elseif (filter_has_var(INPUT_POST, "btnMudarStatus")) {

    $id = intval(filter_input(INPUT_POST, "id"));

    if ($lista->updateStatus($id)) {
        header("Location: index.php?msg=Status alterado com sucesso");
        exit;
    } else {
        echo "<script>alert('Erro ao alterar status.'); window.history.back();</script>";
    }
}
