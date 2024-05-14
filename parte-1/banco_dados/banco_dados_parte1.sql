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
('11111111111', 'Usuário 1', '1990-01-01', 'Senha1@'),
('22222222222', 'Usuário 2', '1991-02-02', 'Senha2@'),
('33333333333', 'Usuário 3', '1992-03-03', 'Senha3@'),
('44444444444', 'Usuário 4', '1993-04-04', 'Senha4@'),
('55555555555', 'Usuário 5', '1994-05-05', 'Senha5@'),
('66666666666', 'Usuário 6', '1995-06-06', 'Senha6@'),
('77777777777', 'Usuário 7', '1996-07-07', 'Senha7@'),
('88888888888', 'Usuário 8', '1997-08-08', 'Senha8@'),
('99999999999', 'Usuário 9', '1998-09-09', 'Senha9@'),
('10101010101', 'Usuário 10', '1999-10-10', 'Senha10@');

-- Inserção de 10 médicos
INSERT INTO medico (crm, medico_cpf, especialidade_id) VALUES 
('1111111', '11111111111', 1),
('2222222', '22222222222', 2),
('3333333', '33333333333', 3),
('4444444', '44444444444', 1),
('5555555', '55555555555', 2),
('6666666', '66666666666', 3),
('7777777', '77777777777', 1),
('8888888', '88888888888', 2),
('9999999', '99999999999', 3),
('1010101', '10101010101', 9);

-- Inserção de 9 usuários de paciente
INSERT INTO usuario (cpf, nome, data_nascimento, senha) VALUES 
('12121212121', 'Usuário 11', '1990-11-11', 'Senha11@'),
('13131313131', 'Usuário 12', '1991-12-12', 'Senha12@'),
('14141414141', 'Usuário 13', '1992-01-13', 'Senha13@'),
('15151515151', 'Usuário 14', '1993-02-14', 'Senha14@'),
('16161616161', 'Usuário 15', '1994-03-15', 'Senha15@'),
('17171717171', 'Usuário 16', '1995-04-16', 'Senha16@'),
('18181818181', 'Usuário 17', '1996-05-17', 'Senha17@'),
('19191919191', 'Usuário 18', '1997-06-18', 'Senha18@'),
('20202020202', 'Usuário 19', '1998-07-19', 'Senha19@');

-- Inserção de 9 pacientes
INSERT INTO paciente (telefone, peso, altura, paciente_cpf) VALUES 
('11122233344', '70', '170', '12121212121'),
('22233344455', '65', '165', '13131313131'),
('33344455566', '80', '180', '14141414141'),
('44455566677', '75', '175', '15151515151'),
('55566677788', '68', '168', '16161616161'),
('66677788899', '85', '175', '17171717171'),
('77788899900', '72', '172', '18181818181'),
('88899900011', '78', '178', '19191919191'),
('99900011122', '90', '185', '20202020202');


-- Inserção de 1 usuário recepcionista
INSERT INTO usuario (cpf, nome, data_nascimento, senha) VALUES ('31313131313', 'Nome do Recepcionista', '1980-01-01', 'Senharecep12@');
 
 -- Inserção de 1 recepcionista
INSERT INTO recepcionista (recepcionista_cpf) VALUES
 ('31313131313');

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
(1, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2222222'),
(2, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2222222'),
(3, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2222222'),
(4, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2222222'),
(5, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2222222'),
(6, true, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2222222'),
(0, false, true, true, '08:00:00', '12:00:00', '14:00:00', '18:00:00', '2222222');

-- Inserção de 5 agendamentos para o médico 1 com pacientes existentes
INSERT INTO agendamento (horario, data, medico_crm, paciente_cpf) VALUES 
('08:30:00', '2024-04-01', '1111111', '12121212121'),
('09:30:00', '2024-04-02', '1111111', '13131313131'),
('10:30:00', '2024-04-03', '1111111', '14141414141'),
('11:30:00', '2024-04-04', '1111111', '15151515151'),
('14:00:00', '2024-04-06', '1111111', '16161616161');

-- Inserção de 5 agendamentos para o médico 2 com pacientes existentes
INSERT INTO agendamento (horario, data, medico_crm, paciente_cpf) VALUES 
('08:30:00', '2024-04-01', '2222222', '17171717171'),
('09:30:00', '2024-04-02', '2222222', '18181818181'),
('10:30:00', '2024-04-03', '2222222', '19191919191'),
('11:30:00', '2024-04-04', '2222222', '20202020202'),
('14:00:00', '2024-04-05', '2222222', '12121212121');



INSERT INTO registro (descricao, id_agendamento) VALUES
-- Registro para o médico 1 e paciente 1
('Consulta de rotina', 1),

-- Registro para o médico 1 e paciente 2
('Exame de sangue', 2);

INSERT INTO prescricao (medicamento, orientacao, id_registro) VALUES
('Paracetamol', 'Tomar 1 comprimido a cada 6 horas', 1),
('Dipirona', 'Tomar 1 comprimido após as refeições', 2);

