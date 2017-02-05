INSERT INTO 'grupo' ('nome') 
VALUES ('Materiais e Utensílios Diversos para Instalações, Manutenção e Reparo'), 
('Dispositivos e Acessórios para Instalações Hidráulicas'), 
('Acessórios e Componentes Elétrico / Eletrônico / Telefonia'), 
('Ferragens e Suprimentos para Instalações Elétricas');

INSERT INTO 'local' ('codl', 'nome') VALUES (1, 'Campus Chapecó'), 
(2, 'Unidade Reitoria');

INSERT INTO 'fornecedor' ('cnpj', 'razao_social', 'nome_fantasia', 'endereco', 'telefone') 
VALUES (79245296000160, 'MEPAR MERCADO DE PARAFUSOS LTDA', 'MEPAR MERCADO DE PARAFUSOS LTDA', 'Av. Fernando Machado, 3240-D - Líder, SC, 89805-203', '(49) 3321-7777'), 
(05238271000527, 'Andrade Materiais de Construção Ltda', 'Andrade Materiais de Construção Ltda', 'Av. Atílio Fontana, Efapi, SC', '(49) 3329-7517');

INSERT INTO 'produto' ('cod', 'nome', 'qtd', 'codg', 'codl', 'qtdmin') 
VALUES (1000001, 'Massa para Calafetar, Embalagem 350 g', 15, 100, 1, 5), 
(1010001, 'Adesivo conexão hidráulica, para Cano PVC, Tubo 75 g', 18, 101, 1, 5), 
(1020001, 'Mini Disjuntor 20 A / 1 P, Monofasico', 25, 102, 1, 3), 
(1030001, 'Adaptador de Condulete PVC, 3/4, Cor Branco', 150, 103, 1, 50), 
(1030002, 'Eletroduto, Condulete, 3/4 ", PVC, Peça 3 M, Cinza', 11, 103, 2, 0), 
(1010002, 'Bucha de Redução, PVC, 1" 1/2" p/ 1" 1/4"', 8, 101, 2, 5), 
(1000002, 'Espuma Expansiva, Tubo 500 Ml', 18, 100, 1, 2),
(1000003, 'Silicone - Adesivo Vedacalha, Tubo 280 g, Cor Cinza', 62, 100, 1, 15);

INSERT INTO 'insercao' ('codp', 'qtd', 'data') 
VALUES (1000001, 10, '2016-10-24'),
(1000002, 10, '2016-10-24'),
(1000002, 10, '2016-10-24'),
(1010001, 10, '2016-10-24'),
(1010002, 10, '2016-10-24'),
(1020001, 10, '2016-10-24'),
(1030001, 10, '2016-10-24'),
(1030002, 10, '2016-10-24');

INSERT INTO 'remocao' ('data', 'qtd', 'codp', 'destino') 
VALUES ('2016-10-24', 2, 1000001, 'Testes'),
VALUES ('2016-09-24', 2, 1010001, 'Bloco A'),
VALUES ('2016-08-24', 2, 1020001, 'Bloco de Professores'),
VALUES ('2016-07-24', 2, 1030001, 'General Osório'),
VALUES ('2016-06-24', 2, 1010002, 'Laboratório 01');
