/*
Neste arquivo contém querys responsáveis pela criação do banco de dados, tabelas e registros essenciais para funcionamento da versao 2.0 da aplicação.
O arquivo 'conexao.php' é utilizado para conexao ao BD, sendo que nele contém os dados correspondentes aos que serão criados com este SQL.

O sql abaixo deve ser utilizado após criar o servidor e a base de dados com as configurações abaixo:
- ATENÇÃO: caso crie o BD com configurações diferentes, basta adequar o arquivo 'conexao.php'.
*/

-- configurações da base de dados
CREATE DATABASE "GTX3"
    WITH
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'Portuguese_Brazil.1252'
    LC_CTYPE = 'Portuguese_Brazil.1252'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1
    IS_TEMPLATE = False;

/*
Executar o sql no ADM do BD
*/
-- Cria as tabelas
CREATE TABLE statusmembro (
    status_solicit INT PRIMARY KEY UNIQUE,
    descricao TEXT NOT NULL
);
CREATE TABLE plataformagame (
    id INT PRIMARY KEY UNIQUE,
    descricao TEXT
);
CREATE TABLE membros (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(30) NOT NULL,
    nick VARCHAR(20) UNIQUE NOT NULL,
    plataforma INT NOT NULL,
    status_solicit INT NOT NULL,
    senha TEXT NOT NULL,
    FOREIGN KEY (status_solicit) REFERENCES statusmembro(status_solicit),
    FOREIGN KEY (plataforma) REFERENCES plataformagame(id)
);
CREATE TABLE plataformastream (
    id INT PRIMARY KEY UNIQUE,
    descricao TEXT
);
CREATE TABLE canalstream (
    id INT UNIQUE NOT NULL,
    plataforma INT,
    link_canal VARCHAR(50),
    nickstream VARCHAR(20),
    FOREIGN KEY (id) REFERENCES membros(id),
    FOREIGN KEY (plataforma) REFERENCES plataformastream(id)
);
CREATE TABLE statussenha(
    solicit_senha INT PRIMARY KEY NOT NULL,
    descricao TEXT NOT NULL
);
CREATE TABLE recuperasenha(
    id INT NOT NULL,
    nick VARCHAR(20) NOT NULL,
    novasenha TEXT NOT NULL,
    solicit_senha INT NOT NULL,
    data_solicit DATE NOT NULL,
    id_unico SERIAL,
    FOREIGN KEY (solicit_senha) REFERENCES statussenha(solicit_senha)
);

-- Insere os dados constantes da aplicação
INSERT INTO statusmembro (status_solicit, descricao) VALUES 
(0, 'Pendente'),
(1, 'Membro'),
(2, 'Rejeitado'),
(3, 'Expulso'),
(4, 'Administrador');

INSERT INTO statussenha (solicit_senha, descricao) VALUES
(0, 'Aprovado'),
(1, 'Solicitado'),
(2,'Reprovado');

INSERT INTO plataformastream (id, descricao) VALUES
(1, 'Youtube'),
(2, 'Twitch'),
(3, 'TikTok'),
(4, 'Facebook'),
(5, 'Kwai');

INSERT INTO plataformagame (id, descricao) VALUES
(1, 'PC'),
(2, 'Xbox Séries'),
(3, 'Ps5');

-- cria um usuário administrador com o rash da senha '1234567890' (que deve ser alterada posteriormente)
INSERT INTO membros (nome, nick, plataforma, status_solicit, senha) VALUES 
('Administrador', 'adm', 1, 4, '$2y$10$PHBLahBLh4F0oX4iBcpUmef7o1TzdA6x3dIGYkR3v3xWrrRWRYwyS');

INSERT INTO canalstream (id, plataforma, link_canal, nickstream) VALUES
(1, NULL, NULL, NULL);
