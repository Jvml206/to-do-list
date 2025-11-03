<?php
spl_autoload_register(function ($class) {
    require_once "Classes/{$class}.class.php";
});

$Usuario = new Usuario();

if (filter_has_var(INPUT_POST, "btnCadastrar")):
    $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
    $usuario = filter_input(INPUT_POST, "usuario", FILTER_SANITIZE_STRING);
    $senha = filter_input(INPUT_POST, "senha");

    // Criptografa a senha antes de salvar
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $Usuario->setIdUsuario($id);
    $Usuario->setUsuario($usuario);
    $Usuario->setSenhaUsuario($senhaHash);

    if (empty($id)):
        // Inserir novo usuário
        if ($Usuario->add()) {
            echo "<script>alert('Usuário cadastrado com sucesso!');window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar usuário.');window.open(document.referrer,'_self');</script>";
        }
    else:
        // Atualizar usuário (sem alterar o nome de usuário, apenas a senha)
        if ($Usuario->update('id_usuario', $id)) {
            echo "<script>alert('Senha atualizada com sucesso!');window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Erro ao atualizar senha.');window.open(document.referrer,'_self');</script>";
        }
    endif;

elseif (filter_has_var(INPUT_POST, "btnDeletar")):
    $id = intval(filter_input(INPUT_POST, "id"));
    if ($Usuario->delete("id_usuario", $id)) {
        header("location:login.php");
    } else {
        echo "<script>alert('Erro ao excluir usuário.'); window.open(document.referrer, '_self');</script>";
    }
endif;
?>
