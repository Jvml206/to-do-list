CREATE DATABASE To_do_list;
USE To_do_list;

CREATE TABLE IF NOT EXISTS usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS lista (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tarefa TEXT NOT NULL,
    status ENUM('Concluída', 'Pendente') NOT NULL,
    fkIdUsuario INT NOT NULL,
    FOREIGN KEY (fkIdUsuario)
        REFERENCES usuario (id)
        ON DELETE CASCADE ON UPDATE CASCADE
);