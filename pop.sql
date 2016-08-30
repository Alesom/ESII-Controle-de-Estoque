-- populando o banco 

INSERT INTO local VALUES ('XAP','Chapecó') ;
INSERT INTO local VALUES ('XXE','Xanxerê') ;
INSERT INTO local VALUES ('ITG','Itapiranga') ;
INSERT INTO local VALUES ('ITA','Ita') ;
INSERT INTO local VALUES ('BJO','Bom Jesus do Oeste') ;
INSERT INTO local VALUES ('BLV','Bela Vista') ;

INSERT INTO grupo VALUES ('TI','Materiais de Tecnologia');
INSERT INTO grupo VALUES ('ELE','Materiais Eletricos');
INSERT INTO grupo VALUES ('HID','Materiais Hidraulicos');
INSERT INTO grupo VALUES ('SAN','Materiais de Saneamento');


INSERT INTO produto VALUES(1,'Bomba de Água',10,'HID','XAP',5,1);
INSERT INTO produto VALUES(2,'Chave Teste',10,'ELE','XXE',5,1);
INSERT INTO produto VALUES(3,'Cabo de Força',35,'ELE','BJO',25,1);
INSERT INTO produto VALUES(4,'Mouse',50,'TI','XAP',10,1);
INSERT INTO produto VALUES(5,'Teclado',50,'TI','XAP',10,1);
INSERT INTO produto VALUES(6,'Monitor 32"',30,'TI','XAP',10,1);
INSERT INTO produto VALUES(7,'Detergente',50,'SAN','ITA',20,1);
INSERT INTO produto VALUES(8,'Água Sanitária',50,'SAN','ITA',20,1);
INSERT INTO produto VALUES(9,'Mangueira 1/2"',20,'HID','BLV',15,1);
INSERT INTO produto VALUES(10,'Mangueira 1"',30,'HID','BLV',10,1);
INSERT INTO produto VALUES(11,'Redutor de Pressão 1"',20,'HID','BLV',15,1);


INSERT INTO insercao VALUES ( 1, 20, '2016-04-12');
INSERT INTO insercao VALUES ( 5, 20, '2016-01-10');
INSERT INTO insercao VALUES ( 10,30 , '2016-02-03' );
INSERT INTO insercao VALUES ( 3, 40, '2016-03-01');
INSERT INTO insercao VALUES ( 2, 30, '2016-04-28');
INSERT INTO insercao VALUES ( 1, 50, '2016-05-21');
INSERT INTO insercao VALUES ( 7, 100, '2016-06-19');
INSERT INTO insercao VALUES ( 6, 200, '2016-08-15');

