<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Usuario extends CRUD
{
    protected $table = "usuario";
    private $idUsuario;
    private $usuario;
    private $senhaUsuario;

    // GETTERS e SETTERS
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function getSenhaUsuario()
    {
        return $this->senhaUsuario;
    }

    public function setSenhaUsuario($senhaUsuario)
    {
        $this->senhaUsuario = $senhaUsuario;
    }

    // Adiciona um usuário novo (usuario é único)
    public function add()
    {
        // Verifica se o nome de usuário já existe
        $checkSql = "SELECT COUNT(*) FROM $this->table WHERE usuario = :usuario";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->bindParam(':usuario', $this->usuario, PDO::PARAM_STR);
        $checkStmt->execute();

        if ($checkStmt->fetchColumn() > 0) {
            return "Erro: nome de usuário já existe.";
        }

        // Criptografa a senha antes de salvar
        $senhaHash = password_hash($this->senhaUsuario, PASSWORD_DEFAULT);

        // Cadastra novo usuário
        $sql = "INSERT INTO $this->table (usuario, senha) 
                VALUES (:usuario, :senha)";
        $stmt = $this->db->prepare($sql);

        try {
            $stmt->bindParam(':usuario', $this->usuario, PDO::PARAM_STR);
            $stmt->bindParam(':senha', $senhaHash, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $this->idUsuario = $this->db->lastInsertId();
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Erro ao criar usuário: " . $e->getMessage();
            return false;
        }
    }

    // Atualizar apenas a senha (usuario é imutável)
    public function update($campo, $id)
    {
        // Criptografa a nova senha
        $senhaHash = password_hash($this->senhaUsuario, PASSWORD_DEFAULT);

        $sql = "UPDATE $this->table 
                SET senha = :senha
                WHERE $campo = :id";
        $stmt = $this->db->prepare($sql);

        try {
            $stmt->bindParam(':senha', $senhaHash, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao atualizar usuário: " . $e->getMessage();
            return false;
        }
    }

    // Efetuar login
    public function login()
    {
        $sql = "SELECT * FROM $this->table WHERE usuario = :usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario', $this->usuario, PDO::PARAM_STR);
        $stmt->execute();
            if ($stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(PDO::FETCH_OBJ);

            if (password_verify($this->senhaUsuario, $usuario->senha)) {
                $_SESSION['user_id'] = $usuario->id; 
                $_SESSION['usuario'] = $usuario->usuario;
                $_SESSION['ultimaAtividade'] = time();

                header("Location: index.php");
                exit();
            }
        }

        return "Usuário ou senha incorreta. Por favor, tente novamente.";
    }
    
    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }

  
    public function sessaoExpirou()
    {
        $tempo = 1800; // 30 minutos
        if (isset($_SESSION['ultimaAtividade']) && (time() - $_SESSION['ultimaAtividade']) > $tempo) {
            $this->logout();
            return true;
        }
        $_SESSION['ultimaAtividade'] = time();
        return false;
    }

    // Alterar senha
    public function alterarSenha($usuario, $senhaAtual, $novaSenha)
    {
        try {
            $query = "SELECT senha FROM $this->table WHERE usuario = :usuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
            $stmt->execute();

            $dados = $stmt->fetch(PDO::FETCH_OBJ);

            if ($dados && password_verify($senhaAtual, $dados->senhaUsuario)) {
                $novaSenhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
                $query = "UPDATE $this->table SET senha = :novaSenha WHERE usuario = :usuario";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':novaSenha', $novaSenhaHash, PDO::PARAM_STR);
                $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
                return $stmt->execute();
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }
}
