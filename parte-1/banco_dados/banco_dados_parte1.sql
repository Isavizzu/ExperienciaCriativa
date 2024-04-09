/* Lógico_parte1: */

DROP DATABASE clinical_here;
CREATE DATABASE clinical_here;
USE clinical_here;

CREATE TABLE medico (
    crm varchar(7) UNIQUE NOT NULL,
    medico_cpf varchar(15) PRIMARY KEY,
    especialidade_id int,
    ativo boolean
);

CREATE TABLE recepcionista (
    recepcionista_cpf varchar(15) PRIMARY KEY,
    ativo boolean
);

CREATE TABLE especialidade (
    id int PRIMARY KEY,
    nome_especialidade varchar(100)
);

CREATE TABLE usuario (
    cpf varchar(15) PRIMARY KEY,
    nome varchar(100),
    data_nascimento date,
    senha varchar(20)
);

CREATE TABLE paciente (
    telefone varchar(14),
    paciente_cpf varchar(15) PRIMARY KEY,
    altura varchar(10),
    peso varchar(10),
    sexo varchar(10)
);
 
ALTER TABLE medico ADD CONSTRAINT FK_medico_2
    FOREIGN KEY (medico_cpf)
    REFERENCES usuario (cpf)
    ON DELETE CASCADE
    ON UPDATE CASCADE;
 
ALTER TABLE medico ADD CONSTRAINT FK_medico_3
    FOREIGN KEY (especialidade_id)
    REFERENCES especialidade (id)
	ON DELETE CASCADE
    ON UPDATE CASCADE;
  
ALTER TABLE recepcionista ADD CONSTRAINT FK_recepcionista_2
    FOREIGN KEY (recepcionista_cpf)
    REFERENCES usuario (cpf)
	ON DELETE CASCADE
    ON UPDATE CASCADE;
 
ALTER TABLE paciente ADD CONSTRAINT FK_paciente_2
    FOREIGN KEY (paciente_cpf)
    REFERENCES usuario (cpf)
	ON DELETE CASCADE
    ON UPDATE CASCADE;
 