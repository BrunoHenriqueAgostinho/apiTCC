/*
B - 123456789
C - 987654321
H - 13579
J - 2468

ETEC - 123456
FATEC - 654321
*/

use academicoetec;

-- Usuários
INSERT INTO Tb_Usuario (cpf_usuario, nome_usuario, senha_usuario, descricao_usuario, foto_usuario, dtCadastro_usuario, tema_usuario, email_usuario) VALUES
("11111111111", "Bruno Henrique Agostinho da Silva", "25f9e794323b453885f5181f1b624d0b", "Olá, meu nome é Bruno", null, "2021-08-14", "White", "bruno@gmail.com"),
("22222222222", "Caue Vicentini Ruiz", "6ebe76c9fb411be97b3b0d48b791a7c9", "Olá, meu nome é Caue", null, "2021-08-14",  "Berry", "caue@gmail.com"),
("33333333333", "Henrique Queiroz de Paula", "e13dd027be0f2152ce387ac0ea83d863", "Olá, meu nome é Henrique", null, "2021-08-14",  "Dark", "henrique@gmail.com"),
("44444444444", "Jonathan Izidoro", "e82c4b19b8151ddc25d4d93baf7b908f", "Olá, meu nome é Jonathan", null, "2021-08-14", "Ionia", "jonathan@gmail.com");

-- Instituições
INSERT INTO Tb_Instituicao (cnpj_instituicao, nome_instituicao, logotipo_instituicao, dtCadastro_instituicao, senha_instituicao, email_instituicao, telefoneFixo_instituicao, telefoneCelular_instituicao, cidade_instituicao) VALUES
("11111111111111", "ETEC Antonio Devisate", null, "2021-08-14", "e10adc3949ba59abbe56e057f20f883e", "etec@gmail.com","1434335467", null, "Marília"),
("22222222222222", "FATEC Marília - Faculdade de Tecnologia", null, "2021-08-14", "c33367701511b4f6020ec61ded352059", "fatec@gmail.com", "1434547540", null, "Marília");

-- Modelos
INSERT INTO Tb_Modelo (nome_modelo, arquivo_modelo, dtCriacao_modelo, descricao_modelo, Tb_Instituicao_cnpj_instituicao, margemDireita_modelo, margemEsquerda_modelo, margemTopo_modelo, margemBaixo_modelo) VALUES
("Resumo Expandido", "Título: Resumo Expandido","2021-08-18", "Modelo para o TCC da ETEC Antonio Devisate", "11111111111111", "1cm","1cm","1cm","1cm"),
("Resumo Acadêmico", "Título: Resumo Acadêmico", "2021-08-18", "Modelo para resumos científicos", null, "1cm","1cm","1cm","1cm"),
("Artigo", "Título: Artigo", "2021-08-18", "Modelo para artigos científicos", null, "1cm","1cm","1cm","1cm");

-- Tags
INSERT INTO Tb_Tag (codigo_tag, categoria_tag) VALUES
(1, "Sustentabilidade"),
(2, "Indústria"),
(3, "Saúde"),
(4, "Educação"),
(5, "Negócios"),
(6, "Alimentação"),
(7, "Limpeza"),
(8, "Justiça"),
(9, "Gestão"),
(10, "Gameficação"),
(11, "Tecnologia"),
(12, "Psicologia");

-- Amizades entre Usuários
INSERT INTO Adiciona_Usuario_Usuario (seguidor_usuario, seguido_usuario) VALUES
("11111111111", "33333333333"),
("33333333333", "11111111111"),
("33333333333", "22222222222"),
("44444444444", "22222222222"),
("22222222222", "11111111111"),
("22222222222", "33333333333");

-- Reações dos trabalhos
/*INSERT INTO Tb_tag (Tb_Usuario_cpf_usuario, Tb_Trabalho_codigo_trabalho) VALUES
("11111111111", 1),
("22222222222", 1),
("44444444444", 1),
("22222222222", 2),
("44444444444", 2);*/

-- Apresenta_trabalho_tag
/*INSERT INTO apresenta_trabalho_tag (Tb_Trabalho_codigo_trabalho, Tb_Tag_codigo_tag ) VALUES
(1, 1),
(1, 3),
(1, 5),
(1, 7),
(1, 9),
(2, 2),
(2, 4),
(2, 6),
(2, 8);*/












