CREATE DATABASE IF NOT EXISTS controleCarro;

USE controleCarro;

CREATE TABLE tbCarro (
    idCarro INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(250) NOT NULL UNIQUE,
    descricao TEXT NOT NULL,
    dataFabricacao DATE NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    foto VARCHAR(250) NULL
);

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(250) NOT NULL UNIQUE,
    senha VARCHAR(250) NOT NULL,
    nome VARCHAR(100)
);
INSERT INTO usuarios (email, senha, nome) VALUES ('admin@email.com', '123', 'Administrador');