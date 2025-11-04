<?php

class Lista extends CRUD
{
    protected $table = "lista";
    private $id;
    private $tarefa;
    private $status;
    private $fkIdUsuario;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTarefa()
    {
        return $this->tarefa;
    }

    public function setTarefa($tarefa)
    {
        $this->tarefa = $tarefa;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getFkIdUsuario()
    {
        return $this->fkIdUsuario;
    }

    public function setFkIdUsuario($fkIdUsuario)
    {
        $this->fkIdUsuario = $fkIdUsuario;
    }

    public function add()
    {
        $sql = "INSERT INTO $this->table (tarefa, status, fkIdUsuario)
                VALUES (:tarefa, :status, :fkIdUsuario)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':tarefa', $this->tarefa, PDO::PARAM_STR);
        $stmt->bindParam(':status', $this->status, PDO::PARAM_STR);
        $stmt->bindParam(':fkIdUsuario', $this->fkIdUsuario, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update(string $campo, int $id)
    {
        $sql = "UPDATE $this->table 
                SET tarefa = :tarefa, status = :status 
                WHERE $campo = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':tarefa', $this->tarefa, PDO::PARAM_STR);
        $stmt->bindParam(':status', $this->status, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

public function updateStatus(int $id)
{

    $sqlSelect = "SELECT status FROM {$this->table} WHERE id = :id";
    $stmtSelect = $this->db->prepare($sqlSelect);
    $stmtSelect->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtSelect->execute();
    $statusAtual = $stmtSelect->fetchColumn();

    if ($statusAtual === false) {
        return false; 
    }

    $statusAtual = strtolower(trim($statusAtual));

    $novoStatus = ($statusAtual === 'concluída' || $statusAtual === 'concluida')
        ? 'Pendente'
        : 'Concluída';

    $sqlUpdate = "UPDATE {$this->table} SET status = :status WHERE id = :id";
    $stmtUpdate = $this->db->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':status', $novoStatus, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':id', $id, PDO::PARAM_INT);

    return $stmtUpdate->execute();
}




    public function listarPorUsuario(int $idUsuario)
    {
        $sql = "SELECT * FROM $this->table WHERE fkIdUsuario = :fkIdUsuario ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':fkIdUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}