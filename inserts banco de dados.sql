use academic;

-- Usuários
INSERT INTO tb_usuario (cpf_usuario, nome_usuario, senha_usuario, descricao_usuario, foto_usuario, dtCadastro_usuario, tema_usuario, status_usuario, contaStatus_usuario, email_usuario, telefoneFixo_usuario, telefoneCelular_usuario) VALUES
("11111111111", "Bruno Henrique Agostinho da Silva", "123456789", "Olá, meu nome é Bruno", null, "2021-08-14", "White", status, conta status, email, telefone, celular),
("22222222222", "Caue Vicentini Ruiz", "987654321", "Olá, meu nome é Caue", null, "2021-08-14",  "Berry", status, conta status, email, telefone, celular,
("33333333333", "Henrique Queiroz de Paula", "13579", "Olá, meu nome é Henrique", null, "2021-08-14",  "Dark", status, conta status, email, telefone, celular),
("44444444444", "Jonathan Izidoro", "2468", "Olá, meu nome é Jonathan", null, "2021-08-14", "Ionia", status, conta status, email, telefone, celular);

-- Instituições
INSERT INTO tb_instituicao (cnpj_instituicao, nome_instituicao, logotipo_instituicao, dtCadastro_instituicao, senha_instituicao, contaStatus_instituicao, email_instituicao, telefoneFixo_instituicao, telefoneCelular_instituicao, cidade_instituicao) VALUE
("11111111111111", "ETEC Antonio Devisate", null, "2021-08-14", "12345678987654321", ,"etec@gmail.com","1434226098","14789652321","Marília");
("22222222222222", "FATEC", null, "2021-08-14", "98765432123456789", 6);

-- Modelos
INSERT INTO tb_modelo (nome_modelo, arquivo_modelo, dtCriacao_modelo, descricao_modelo, Tb_Instituicao_cnpj_instituicao, margemDireita_trabalho, margemEsquerda_trabalho, margemTopo_trabalho, margemBaixo_trabalho) VALUES
("Resumo Expandido", "Título: Resumo: Palavras-Chave: Introdução: Objetivos: Relevância do estudo: Metodologia: Resultados: Conclusão: Referências:","2021-08-18", "Modelo para o TCC do 3°ETIM DS", "11111111111111","1cm","1cm","1cm","1cm"),
("Resumo", "Título: Resumo: Referências:", "2021-08-18", "", null,"1cm","1cm","1cm","1cm");

-- Trabalho
INSERT INTO tb_trabalho (nome_trabalho, descricao_trabalho, arquivo_trabalho, finalizado_trabalho, dtCriacao_trabalho, dtAlteracao_trabalho, dtPublicacao_trabalho, avaliacao_trabalho, Tb_Modelo_codigo_modelo, Tb_Instituicao_cnpj_instituicao, margemDireita_trabalho, margemEsquerda_trabalho,	margemTopo_trabalho, margemBaixo_trabalho) VALUES
("TCC Academic", "Trabalho de Conclusão de Curso do ETIM DS da Etec Antonio Devisate", "arquivo", 0, "2021-08-26", "2021-08-26", null, null, 1, null,"1cm","1cm","1cm","1cm"),
("Resumo", "Resumo para o 3°ETIM DS", "arquivo", 0, "2021-08-26", "2021-08-26", null, null, 1, null,"1cm","1cm","1cm","1cm");
INSERT INTO tb_trabalho (nome_trabalho, descricao_trabalho, arquivo_trabalho, formatacao_trabalho, finalizado_trabalho, dtCriacao_trabalho, dtAlteracao_trabalho, dtPublicacao_trabalho, avaliacao_trabalho, Tb_Modelo_codigo_modelo, Tb_Instituicao_cnpj_instituicao) VALUES

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

-- Reações dos trabalhos
INSERT INTO reage_usuario_trabalho (Tb_Usuario_cpf_usuario, Tb_Trabalho_codigo_trabalho) VALUES
("11111111111", 1);
INSERT INTO reage_usuario_trabalho (Tb_Usuario_cpf_usuario, Tb_Trabalho_codigo_trabalho) VALUES
("22222222222", 1);
INSERT INTO reage_usuario_trabalho (Tb_Usuario_cpf_usuario, Tb_Trabalho_codigo_trabalho) VALUES
("44444444444", 1);
INSERT INTO reage_usuario_trabalho (Tb_Usuario_cpf_usuario, Tb_Trabalho_codigo_trabalho) VALUES
("22222222222", 2);
INSERT INTO reage_usuario_trabalho (Tb_Usuario_cpf_usuario, Tb_Trabalho_codigo_trabalho) VALUES
("44444444444", 2);

-- Membros dos trabalhos
INSERT INTO desenvolve_usuario_trabalho (Tb_Usuario_cpf_usuario, Tb_Trabalho_codigo_trabalho, cargo_usuario) VALUES
("11111111111", 1, 1),
("22222222222", 1, 1),
("33333333333", 1, 2);
INSERT INTO desenvolve_usuario_trabalho (Tb_Usuario_cpf_usuario, Tb_Trabalho_codigo_trabalho, cargo_usuario) VALUES
("33333333333", 2, 1),
("44444444444", 2, 3),
("11111111111", 2, 2);

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

-- Apresenta_trabalho_tag
INSERT INTO apresenta_trabalho_tag (Tb_Trabalho_codigo_trabalho, Tb_Tag_codigo_tag ) VALUES
(1, 1),
(1, 3),
(1, 5),
(1, 7),
(1, 9),
(2, 2),
(2, 4),
(2, 6),
(2, 8);
















-- Contatos de Usuários
INSERT INTO tb_contato (codigo_contato, email_contato, telefoneFixo_contato, telefoneCelular_contato) VALUE
(1, "bruno@gmail.com", "1133333333", "11999999999"),
(2, "caue@gmail.com", "1144444444", "11222222222"),
(3, "henrique@gmail.com", "1155555555", "11333333333"),
(4, "jonathan@gmail.com", "1166666666", "11444444444");





-- Contatos de Instituições
INSERT INTO tb_contato (codigo_contato, email_contato, telefoneFixo_contato, telefoneCelular_contato) VALUE
(5, "etecAntonioDevisate@gmail.com", "1132323232", "11939393939"),
(6, "fatec@gmail.com", "1121212121", "11212121212");



-- Enderecos
INSERT INTO tb_endereco (Tb_Instituicao_cnpj_instituicao, estado_endereco, cidade_endereco, bairro_endereco, rua_endereco, numero_endereco, complemento_endereco,cep_endereco) VALUE
("11111111111111", "São Paulo", "Marília", "Somenzari", "Avenida Castro Alves", "62", "", "17506000"),
("22222222222222", "Estado1", "Cidade1", "Bairro1", "Rua1", "1234", "", "11222333");












