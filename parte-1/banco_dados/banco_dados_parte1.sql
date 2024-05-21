DROP DATABASE clinical_here;
CREATE DATABASE clinical_here;
USE clinical_here;

CREATE TABLE medico (
    crm varchar(7) UNIQUE NOT NULL,
    medico_cpf varchar(15) PRIMARY KEY,
    especialidade_id int NOT NULL,
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
    senha varchar(40)
);

CREATE TABLE paciente (
    telefone varchar(14),
    paciente_cpf varchar(15) PRIMARY KEY,
    altura varchar(10),
    peso varchar(10),
    sexo varchar(10)
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
	id INT PRIMARY KEY auto_increment,
    horario time,
    data date,
    medico_crm varchar(7) NOT NULL,
    paciente_cpf varchar(15) NOT NULL,
    presenca boolean default false
);
 
 CREATE TABLE registro (
	id INT PRIMARY KEY auto_increment,
    descricao TEXT,
    id_agendamento int NOT NULL
);

CREATE TABLE prescricao (
	id INT PRIMARY KEY auto_increment,
    medicamento VARCHAR(100),
    orientacao TEXT,
    id_registro INT NOT NULL
    );
ALTER TABLE registro ADD CONSTRAINT FK_id_agendamento
	FOREIGN KEY(id_agendamento)
    REFERENCES agendamento (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE;
    
ALTER TABLE prescricao ADD CONSTRAINT FK_id_registro
	FOREIGN KEY(id_registro)
    REFERENCES registro (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

        
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
    
 -- Inserção de 10 especialidades
INSERT INTO especialidade (id, nome_especialidade) VALUES 
(1, 'Cardiologia'),
(2, 'Dermatologia'),
(3, 'Ortopedia'),
(4, 'Pediatria'),
(5, 'Oftalmologia'),
(6, 'Psiquiatria'),
(7, 'Ginecologia'),
(8, 'Urologia'),
(9, 'Neurologia'),
(10, 'Endocrinologia');

-- Inserção de 10 usuários de médico
INSERT INTO usuario (cpf, nome, data_nascimento, senha) VALUES 
('913.118.130-98', 'Julia Helena', '1990-01-01', '4542d8f0b2562d983104a332b16b6cbb'),
('964.120.220-07', 'Maria Fernanda', '1991-02-02', 'b247e6522b4264081a5b3263642ffdb0'),
('070.933.230-06', 'Tony Stark', '1970-04-30', 'f6539c4d12b08e0d3b90512884e3ed9b'),
('840.683.210-00', 'Natasha Romanoff', '1983-09-11', '40981705e32c8d1ae60483b612e1fa38'),
('796.838.260-24', 'José', '1991-07-20', '675d84804925992501c45858c7cd4118'),
('604.130.440-92', 'Rodrigo', '1992-11-02', '2e564066e3b4d9bba757a8cd5eed8fdc'),
('841.359.750-11', 'Elisa', '1985-12-23', 'a375168671ef3637fd006569b854df75'),
('669.895.680-54', 'Sofia', '1987-09-28', '7cb45808d16d5c9c60fdb984d7392510'),
('868.505.680-27', 'Cristina', '1996-10-29', '56cb6419f9240cf191fd5d204beff4a2'),
('605.828.910-60', 'Peter Park', '1989-08-21', 'bf7e1650411a1cfa8ba504c41673b087'),
('046.647.190-43', 'Isabelle Vizzu', '1992-03-03', '5dae746f560eb5c4ab4c425fded69031');


-- Inserção de 10 médicos
INSERT INTO medico (crm, medico_cpf, especialidade_id) VALUES 
('6666666', '841.359.750-11', 3),
('5555555', '868.505.680-27', 3),
('4444444', '604.130.440-92', 7),
('3333333', '796.838.260-24', 2),
('2222222', '669.895.680-54', 1),
('1111111', '046.647.190-43', 1);


-- Inserção de 9 pacientes
INSERT INTO paciente (telefone, peso, altura, paciente_cpf) VALUES 
('123456789', '60', '1.70', '070.933.230-06'),
('123456789', '70', '1.73', '840.683.210-00'),
('123456789', '55', '1.65', '605.828.910-60'),
('111222333', '70', '170', '913.118.130-98'),
('222333444', '65', '165', '964.120.220-07');



-- Inserção de 1 usuário recepcionista
INSERT INTO usuario (cpf, nome, data_nascimento, senha) VALUES ('431.628.700-11', 'Nome do Recepcionista', '1980-01-01', '535f2994ee5d06430c7c1093551081fd');
 
 -- Inserção de 1 recepcionista
INSERT INTO recepcionista (recepcionista_cpf) VALUES
 ('431.628.700-11');

-- Inserção de 7 agendas para o médico 1
INSERT INTO agenda (dia_semana, trabalha, trabalha_manha, trabalha_tarde, horario_inicio_manha, horario_fim_manha, horario_inicio_tarde, horario_fim_tarde, medico_crm) VALUES 
(1, true, true, true, '09:00:00', '12:00:00', '14:00:00', '18:00:00', '1111111'),
(2, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '1111111'),
(3, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '1111111'),
(4, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '1111111'),
(5, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '1111111'),
(6, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '1111111'),
(0, false, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '1111111');

-- Inserção de 7 agendas para o médico 2
INSERT INTO agenda (dia_semana, trabalha, trabalha_manha, trabalha_tarde, horario_inicio_manha, horario_fim_manha, horario_inicio_tarde, horario_fim_tarde, medico_crm) VALUES 
(1, true, true, true, '09:00:00', '12:00:00', '14:00:00', '18:00:00', '2222222'),
(2, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2222222'),
(3, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2222222'),
(4, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2222222'),
(5, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2222222'),
(6, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2222222'),
(0, false, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2222222');

-- Inserção de 7 agendas para o médico 3
INSERT INTO agenda (dia_semana, trabalha, trabalha_manha, trabalha_tarde, horario_inicio_manha, horario_fim_manha, horario_inicio_tarde, horario_fim_tarde, medico_crm) VALUES 
(1, true, true, true, '09:00:00', '12:00:00', '14:00:00', '18:00:00', '3333333'),
(2, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '3333333'),
(3, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '3333333'),
(4, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '3333333'),
(5, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '3333333'),
(6, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '3333333'),
(0, false, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '3333333');

-- Inserção de 7 agendas para o médico 4
INSERT INTO agenda (dia_semana, trabalha, trabalha_manha, trabalha_tarde, horario_inicio_manha, horario_fim_manha, horario_inicio_tarde, horario_fim_tarde, medico_crm) VALUES 
(1, true, true, true, '09:00:00', '12:00:00', '14:00:00', '18:00:00', '4444444'),
(2, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '4444444'),
(3, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '4444444'),
(4, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '4444444'),
(5, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '4444444'),
(6, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '4444444'),
(0, false, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '4444444');

-- Inserção de 7 agendas para o médico 5
INSERT INTO agenda (dia_semana, trabalha, trabalha_manha, trabalha_tarde, horario_inicio_manha, horario_fim_manha, horario_inicio_tarde, horario_fim_tarde, medico_crm) VALUES 
(1, true, true, true, '09:00:00', '12:00:00', '14:00:00', '18:00:00', '5555555'),
(2, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '5555555'),
(3, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '5555555'),
(4, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '5555555'),
(5, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '5555555'),
(6, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '5555555'),
(0, false, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '5555555');

-- Inserção de 7 agendas para o médico 6
INSERT INTO agenda (dia_semana, trabalha, trabalha_manha, trabalha_tarde, horario_inicio_manha, horario_fim_manha, horario_inicio_tarde, horario_fim_tarde, medico_crm) VALUES 
(1, true, true, true, '09:00:00', '12:00:00', '14:00:00', '18:00:00', '6666666'),
(2, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '6666666'),
(3, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '6666666'),
(4, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '6666666'),
(5, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '6666666'),
(6, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '6666666'),
(0, false, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '6666666');



-- Inserção de 5 agendamentos para o médico 
INSERT INTO agendamento (horario, data, medico_crm, paciente_cpf) VALUES 
('09:30:00', '2024-04-01', '2222222', '913.118.130-98'),
('08:30:00', '2024-04-01', '3333333', '913.118.130-98'),
('10:30:00', '2024-04-01', '1111111', '913.118.130-98'),
('14:30:00', '2024-04-01', '1111111', '913.118.130-98'),
('15:30:00', '2024-04-01', '1111111', '913.118.130-98');

-- Inserção de 5 agendamentos para o médico 
INSERT INTO agendamento (horario, data, medico_crm, paciente_cpf) VALUES 
('11:30:00', '2024-04-01', '2222222', '964.120.220-07'),
('10:30:00', '2024-04-01', '3333333', '964.120.220-07'),
('14:30:00', '2024-04-01', '1111111', '964.120.220-07'),
('15:30:00', '2024-04-01', '1111111', '964.120.220-07'),
('08:30:00', '2024-04-01', '1111111', '964.120.220-07');



INSERT INTO registro (descricao, id_agendamento) VALUES
-- Registro para o médico 1 e paciente 1
('Consulta de rotina', 1),
('Consulta de rotina', 2),
('Consulta de rotina', 3);



INSERT INTO prescricao (medicamento, orientacao, id_registro) VALUES
('Paracetamol', 'Tomar 1 comprimido a cada 8 horas', 1),
('Ibuprofeno', 'Tomar 1 comprimido a cada 12 horas', 1),
('Dipirona', 'Tomar 1 comprimido a cada 6 horas', 1),
('Doril', 'Tomar 1 comprimido a cada 6 horas', 1),
('Advil', 'Tomar 1 comprimido a cada 6 horas', 1);