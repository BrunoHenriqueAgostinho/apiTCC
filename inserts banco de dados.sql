use academic2;
-- Contatos de Usuários
INSERT INTO tb_contato (codigo_contato, email_contato, telefoneFixo_contato, telefoneCelular_contato) VALUE
(1, "bruno@gmail.com", "1133333333", "11999999999"),
(2, "caue@gmail.com", "1144444444", "11222222222"),
(3, "henrique@gmail.com", "1155555555", "11333333333"),
(4, "jonathan@gmail.com", "1166666666", "11444444444");

-- Usuários
INSERT INTO tb_usuario (cpf_usuario, nome_usuario, senha_usuario, descricao_usuario, foto_usuario, dtCadastro_usuario, Tb_Contato_codigo_contato) VALUE
("11111111111", "Bruno Henrique Agostinho da Silva", "123456789", "Olá, meu nome é Bruno", null, "2021-08-14", 1),
("22222222222", "Caue Vicentini Ruiz", "987654321", "Olá, meu nome é Caue", null, "2021-08-14", 2),
("33333333333", "Henrique Queiroz de Paula", "13579", "Olá, meu nome é Henrique", null, "2021-08-14", 3),
("44444444444", "Jonathan Izidoro", "2468", "Olá, meu nome é Jonathan", null, "2021-08-14", 4);

-- Amizades entre Usuários
INSERT INTO adiciona_usuario_usuario (seguidor_usuario, seguido_usuario) VALUE
("11111111111", "33333333333");
INSERT INTO adiciona_usuario_usuario (seguidor_usuario, seguido_usuario) VALUE
("33333333333", "11111111111");
INSERT INTO adiciona_usuario_usuario (seguidor_usuario, seguido_usuario) VALUE
("33333333333", "22222222222");
INSERT INTO adiciona_usuario_usuario (seguidor_usuario, seguido_usuario) VALUE
("44444444444", "22222222222");
INSERT INTO adiciona_usuario_usuario (seguidor_usuario, seguido_usuario) VALUE
("22222222222", "11111111111");
INSERT INTO adiciona_usuario_usuario (seguidor_usuario, seguido_usuario) VALUE
("22222222222", "33333333333");

-- Contatos de Instituições
INSERT INTO tb_contato (codigo_contato, email_contato, telefoneFixo_contato, telefoneCelular_contato) VALUE
(5, "etecAntonioDevisate@gmail.com", "1132323232", "11939393939"),
(6, "fatec@gmail.com", "1121212121", "11212121212");

-- Instituições
INSERT INTO tb_instituicao (cnpj_instituicao, nome_instituicao, logotipo_instituicao, dtCadastro_instituicao, senha_instituicao, Tb_Contato_codigo_contato) VALUE
("11111111111111", "ETEC Antonio Devisate", null, "2021-08-14", "12345678987654321", 5),
("22222222222222", "FATEC", null, "2021-08-14", "98765432123456789", 6);

-- Enderecos
INSERT INTO tb_endereco (Tb_Instituicao_cnpj_instituicao, estado_endereco, cidade_endereco, bairro_endereco, rua_endereco, numero_endereco, complemento_endereco,cep_endereco) VALUE
("11111111111111", "São Paulo", "Marília", "Somenzari", "Avenida Castro Alves", "62", "", "17506000"),
("22222222222222", "Estado1", "Cidade1", "Bairro1", "Rua1", "1234", "", "11222333");

-- Tags
INSERT INTO tb_tag (codigo_tag, categoria_tag) VALUES
(1, "Sustentabilidade"),
(2, "Indústria"),
(3, "Saúde"),
(4,  "Educação"),
(5, "Negócios"),
(6, "Alimentação"),
(7, "Limpeza"),
(8, "Justiça"),
(9, "Gestão");

-- Modelos
-- POR QUE SÓ FUNCIONA QUANDO TEM CNPJ??
INSERT INTO tb_modelo (nome_modelo, arquivo_modelo, formatacao_modelo, dtCriacao_modelo, descricao_modelo, Tb_Instituicao_cnpj_instituicao) VALUES
("Resumo Expandido", "Título: Resumo: Palavras-Chave: Introdução: Objetivos: Relevância do estudo: Metodologia: Resultados: Conclusão: Referências:","8pt", "2021-08-18", "Modelo para o TCC do 3°ETIM DS", "11111111111111"),
("Resumo", "Título: Resumo: Referências:", "9pt", "2021-08-18", "", null);

-- Trabalho
INSERT INTO tb_trabalho (nome_trabalho, descricao_trabalho, arquivo_trabalho, formatacao_trabalho, finalizado_trabalho, dtCriacao_trabalho, dtAlteracao_trabalho, dtPublicacao_trabalho, avaliacao_trabalho, Tb_Modelo_codigo_modelo, Tb_Instituicao_cnpj_instituicao) VALUES
("TCC Academic", "Trabalho de Conclusão de Curso do ETIM DS da Etec Antonio Devisate", "arquivo", "formatação", 0, "2021-08-26", "2021-08-26", null, null, 1, null);