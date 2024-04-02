DROP DATABASE clinical_here;
CREATE DATABASE clinical_here;
USE clinical_here;


CREATE TABLE recepcionista (
    recepcionista_cpf varchar(15) PRIMARY KEY
);

CREATE TABLE medico (
    crm varchar(7) PRIMARY KEY,
    medico_cpf varchar(15),
    especialidade_id int
);

CREATE TABLE paciente (
    telefone varchar(14),
    peso varchar(10),
    altura varchar(10),
    paciente_cpf varchar(15) PRIMARY KEY
);

CREATE TABLE usuario (
    cpf varchar(15) PRIMARY KEY,
    nome varchar(100),
    data_nascimento date,
    senha varchar(20)
);

CREATE TABLE especialidade (
    id int PRIMARY KEY,
    nome_especialidade varchar(100)
);

CREATE TABLE agenda (
    dia_semana int,
    trabalha boolean,
    trabalha_manha boolean,
    trabalha_tarde boolean,
    horario_inicio_manha time,
    horario_fim_manha time,
    horario_inicio_tarde time,
    horario_fim_tarde time,
    medico_crm varchar(7),
    PRIMARY KEY (dia_semana, medico_crm)
);

CREATE TABLE agendamento (
    horario time,
    data date,
    medico_crm varchar(7),
    paciente_cpf varchar(15),
    PRIMARY KEY (horario, data, medico_crm, paciente_cpf)
);
 
ALTER TABLE recepcionista ADD CONSTRAINT FK_recepcionista_2
    FOREIGN KEY (recepcionista_cpf)
    REFERENCES usuario (cpf)
    ON DELETE CASCADE
    ON UPDATE CASCADE;
 
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
 
ALTER TABLE paciente ADD CONSTRAINT FK_paciente_2
    FOREIGN KEY (paciente_cpf)
    REFERENCES usuario (cpf)
    ON DELETE CASCADE
    ON UPDATE CASCADE;
 
ALTER TABLE agenda ADD CONSTRAINT FK_agenda_1
    FOREIGN KEY (medico_crm)
    REFERENCES medico (crm)
    ON DELETE CASCADE
    ON UPDATE CASCADE;
 
ALTER TABLE agendamento ADD CONSTRAINT FK__agendamento_1
    FOREIGN KEY (medico_crm)
    REFERENCES medico (crm)
    ON DELETE CASCADE
    ON UPDATE CASCADE;
 
ALTER TABLE agendamento ADD CONSTRAINT FK__agendamento_2
    FOREIGN KEY (paciente_cpf)
    REFERENCES paciente (paciente_cpf)
    ON DELETE CASCADE
    ON UPDATE CASCADE;
    
-- Inserir usuários (genéricos)

-- Inserir especialidades
INSERT INTO especialidade (id, nome_especialidade)
VALUES 
    (1, 'Cardiologia'),
    (2, 'Dermatologia'),
    (3, 'Pediatria'),
    (4, 'Neurologia'),
    (5, 'Ortopedia'),
    (6, 'Endocrinologia');

INSERT INTO usuario (cpf, nome, senha, data_nascimento)
VALUES 
    ('12345678901', 'Paciente 1', 'senha1', '1990-01-01'),
    ('23456789012', 'Paciente 2', 'senha2', '1990-01-02'),
    ('99345678901', 'Paciente 3', 'senha1', '1990-01-01'),
    ('99456789012', 'Paciente 4', 'senha2', '1990-01-02'),
    ('98345678901', 'Paciente 5', 'senha1', '1990-01-01'),
    ('34567890123', 'Médico 1', 'senha3', '1980-01-01'),
    ('45678901234', 'Médico 2', 'senha4', '1980-01-02'),
    ('56789012345', 'Recepcionista 1', 'senha5', '1970-01-01');

-- Inserir pacientes
INSERT INTO paciente (telefone, peso, altura, paciente_cpf)
VALUES 
    ('(11) 1111-1111', '54', '1.64', '12345678901'),
    ('(22) 2222-2222', '55', '1.54', '23456789012'),
    ('(33) 1111-1111', '56', '1.64', '99345678901'),
    ('(44) 2222-2222', '57', '1.94', '99456789012'),
    ('(55) 1111-1111', '58', '1.84', '98345678901');

-- Inserir médicos
INSERT INTO medico (crm, medico_cpf, especialidade_id)
VALUES 
    ('1234567', '34567890123', 1),
    ('2345678', '45678901234', 2);

-- Inserir recepcionista
INSERT INTO recepcionista (recepcionista_cpf)
VALUES ('56789012345');

-- Adicionar os sete dias da semana na tabela agenda para um único médico (supondo que o médico tenha CRM '1234567')
-- Deixando sábado e domingo livres
INSERT INTO agenda (dia_semana, trabalha, trabalha_manha, trabalha_tarde, horario_inicio_manha, horario_fim_manha, horario_inicio_tarde, horario_fim_tarde, medico_crm)
VALUES 
    (1, 1, 1, 1, '08:00:00', '11:00:00', '14:00:00', '18:00:00', '1234567'),
    (2, 1, 1, 1, '09:00:00', '12:00:00', '15:00:00', '19:00:00', '1234567'),
    (3, 1, 1, 1, '10:00:00', '11:00:00', '16:00:00', '20:00:00', '1234567'),
    (4, 1, 1, 1, '11:00:00', '11:00:00', '17:00:00', '21:00:00', '1234567'),
    (5, 1, 1, 1, '12:00:00', '11:00:00', '18:00:00', '22:00:00', '1234567'),
    (6, 0, 0, 0, NULL, NULL, NULL, NULL, '1234567'), -- Sábado livre
    (0, 0, 0, 0, NULL, NULL, NULL, NULL, '1234567'); -- Domingo livre

-- Adicionar mais dois registros de agendamento (supondo que os pacientes tenham CPF '12345678901' e '23456789012')
INSERT INTO agendamento (horario, data, medico_crm, paciente_cpf)
VALUES 
    ('09:00:00', '2024-07-01', '1234567', '12345678901'),
    ('10:00:00', '2024-07-01', '1234567', '23456789012');
