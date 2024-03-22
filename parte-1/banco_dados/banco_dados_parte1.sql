/* Lógico_parte1: */

DROP DATABASE clinical_here;
CREATE DATABASE clinical_here;
USE clinical_here;

CREATE TABLE medico (
    crm varchar(7) PRIMARY KEY,
    medico_cpf varchar(15),
    especialidade_id int
);

CREATE TABLE recepcionista (
    recepcionista_cpf varchar(15) PRIMARY KEY
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
    peso varchar(10)
);
 
ALTER TABLE medico ADD CONSTRAINT FK_medico_2
    FOREIGN KEY (medico_cpf)
    REFERENCES usuario (cpf)
    ON DELETE CASCADE;
 
ALTER TABLE medico ADD CONSTRAINT FK_medico_3
    FOREIGN KEY (especialidade_id)
    REFERENCES especialidade (id)
    ON DELETE CASCADE;
 
ALTER TABLE recepcionista ADD CONSTRAINT FK_recepcionista_2
    FOREIGN KEY (recepcionista_cpf)
    REFERENCES usuario (cpf)
    ON DELETE CASCADE;
 
ALTER TABLE paciente ADD CONSTRAINT FK_paciente_2
    FOREIGN KEY (paciente_cpf)
    REFERENCES usuario (cpf)
    ON DELETE CASCADE;