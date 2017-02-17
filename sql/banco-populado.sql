-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 17-Fev-2017 às 03:12
-- Versão do servidor: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `estoque`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedor`
--

CREATE TABLE IF NOT EXISTS `fornecedor` (
  `cnpj` varchar(18) NOT NULL,
  `razao_social` varchar(100) NOT NULL,
  `nome_fantasia` varchar(100) NOT NULL,
  `endereco` varchar(100) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `fornecedor`
--

INSERT INTO `fornecedor` (`cnpj`, `razao_social`, `nome_fantasia`, `endereco`, `telefone`) VALUES
('05238271000527', 'Andrade Materiais de ConstruÃ§Ã£o Ltda', 'Andrade Materiais de ConstruÃ§Ã£o Ltda', 'Av. AtÃ­lio Fontana, Efapi, SC', '49 33297-517'),
('75384404000125', 'Rezzadori & Cia Ltda', 'DistriOeste', 'R Xanxere, 239-E, Lider, Chapeco, SC, CEP 89805-270, Brasil', '49 33310-600'),
('79245296000160', 'MEPAR MERCADO DE PARAFUSOS LTDA', 'MEPAR MERCADO DE PARAFUSOS LTDA', 'Av. Fernando Machado, 3240-D - LÃ­der, SC, 89805-203', '49 33217-777');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecimento`
--

CREATE TABLE IF NOT EXISTS `fornecimento` (
  `cod` bigint(20) unsigned NOT NULL,
  `cnpj` varchar(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `fornecimento`
--

INSERT INTO `fornecimento` (`cod`, `cnpj`) VALUES
(10001, '05238271000527'),
(30001, '79245296000160');

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo`
--

CREATE TABLE IF NOT EXISTS `grupo` (
`codg` bigint(20) unsigned NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `grupo`
--

INSERT INTO `grupo` (`codg`, `nome`) VALUES
(1, 'Materiais e UtensÃ­lios Diversos para InstalaÃ§Ãµes, ManutenÃ§Ã£o e Reparo'),
(2, 'Dispositivos e AcessÃ³rios para InstalaÃ§Ãµes HidrÃ¡ulicas'),
(3, 'AcessÃ³rios e Componentes ElÃ©trico / EletrÃ´nico / Telefonia'),
(4, 'Ferragens e Suprimentos para InstalaÃ§Ãµes ElÃ©tricas'),
(5, 'Materiais de Expediente e EscritÃ³rio');

-- --------------------------------------------------------

--
-- Estrutura da tabela `insercao`
--

CREATE TABLE IF NOT EXISTS `insercao` (
  `codp` varchar(20) NOT NULL,
  `qtd` int(11) NOT NULL,
  `data` date NOT NULL,
  `cnpj` varchar(18) DEFAULT NULL,
  `vlr` decimal(10,0) NOT NULL,
  `nfe` varchar(30) DEFAULT NULL,
  `tipo` varchar(10) NOT NULL,
  `local` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `insercao`
--

INSERT INTO `insercao` (`codp`, `qtd`, `data`, `cnpj`, `vlr`, `nfe`, `tipo`, `local`) VALUES
('00010001', 10, '2017-02-01', '05238271000527', '100', '1221', 'Compra', 1),
('00010001', 10, '2017-02-02', '05238271000527', '100', '111', 'Compra', 2),
('00010001', 5, '2017-03-01', NULL, '0', NULL, 'TransferÃª', 4),
('00030001', 10, '2017-04-14', '79245296000160', '0', '111', 'Compra', 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `local`
--

CREATE TABLE IF NOT EXISTS `local` (
`codl` bigint(20) unsigned NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `local`
--

INSERT INTO `local` (`codl`, `nome`) VALUES
(1, 'Campus ChapecÃ³'),
(2, 'Campus Cerro Largo'),
(3, 'Campus Passo Fundo'),
(4, 'Campus Laranjeiras do Sul'),
(5, 'Campus Realeza'),
(6, 'Campus Erechim'),
(7, 'Reitoria');

-- --------------------------------------------------------

--
-- Estrutura da tabela `localizacao`
--

CREATE TABLE IF NOT EXISTS `localizacao` (
  `codl` bigint(20) unsigned NOT NULL,
  `codp` varchar(20) NOT NULL,
  `qtd` int(11) DEFAULT NULL,
  `qtdmin` int(11) DEFAULT NULL,
  `alarm` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `localizacao`
--

INSERT INTO `localizacao` (`codl`, `codp`, `qtd`, `qtdmin`, `alarm`) VALUES
(1, '00010001', 10, 5, 1),
(2, '00010001', 5, 0, 1),
(4, '00010001', 5, 0, 1),
(1, '00030001', 0, 1, 1),
(5, '00030001', 10, 0, 1),
(1, '00040001', 0, 10, 1),
(7, '00050001', 0, 20, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE IF NOT EXISTS `produto` (
  `cod` varchar(20) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `medida` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`cod`, `nome`, `medida`) VALUES
('00010001', 'Massa para Calafetar, Embalagem 350 g', 'Unidade'),
('00030001', 'Mini Disjuntor 20 A / 1 P, Monofasico', 'Unidade'),
('00040001', 'Fio FlexÃ­Â­vel, 2,5mm, Verde', 'Unidade'),
('00050001', 'Caneta EsferogrÃ¡fica, Cor Azul', 'Unidade');

-- --------------------------------------------------------

--
-- Estrutura da tabela `remocao`
--

CREATE TABLE IF NOT EXISTS `remocao` (
  `data` date NOT NULL,
  `qtd` int(11) NOT NULL,
  `codp` varchar(20) NOT NULL,
  `destino` varchar(100) NOT NULL,
  `chamado` varchar(100) DEFAULT NULL,
  `local` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `remocao`
--

INSERT INTO `remocao` (`data`, `qtd`, `codp`, `destino`, `chamado`, `local`) VALUES
('2017-03-01', 5, '00010001', 'TransferÃªncia', '-', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
`cod` bigint(20) unsigned NOT NULL,
  `nome` varchar(16) NOT NULL,
  `funcao` varchar(50) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `codl` varchar(3) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`cod`, `nome`, `funcao`, `senha`, `codl`) VALUES
(1, 'ketly', 'Administrador', '58fd9f8fa442d83bc7ede1f2d7ae7792', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fornecedor`
--
ALTER TABLE `fornecedor`
 ADD PRIMARY KEY (`cnpj`);

--
-- Indexes for table `fornecimento`
--
ALTER TABLE `fornecimento`
 ADD PRIMARY KEY (`cod`,`cnpj`);

--
-- Indexes for table `grupo`
--
ALTER TABLE `grupo`
 ADD PRIMARY KEY (`codg`);

--
-- Indexes for table `insercao`
--
ALTER TABLE `insercao`
 ADD PRIMARY KEY (`codp`,`data`), ADD KEY `insercao_ibfk_2` (`cnpj`);

--
-- Indexes for table `local`
--
ALTER TABLE `local`
 ADD PRIMARY KEY (`codl`);

--
-- Indexes for table `localizacao`
--
ALTER TABLE `localizacao`
 ADD PRIMARY KEY (`codp`,`codl`), ADD KEY `localizacao_ibfk_2` (`codl`);

--
-- Indexes for table `produto`
--
ALTER TABLE `produto`
 ADD PRIMARY KEY (`cod`), ADD UNIQUE KEY `cod` (`cod`);

--
-- Indexes for table `remocao`
--
ALTER TABLE `remocao`
 ADD PRIMARY KEY (`data`,`codp`), ADD KEY `remocao_ibfk_1` (`codp`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
 ADD PRIMARY KEY (`cod`), ADD UNIQUE KEY `cod` (`cod`), ADD KEY `codl` (`codl`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `grupo`
--
ALTER TABLE `grupo`
MODIFY `codg` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `local`
--
ALTER TABLE `local`
MODIFY `codl` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
MODIFY `cod` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `insercao`
--
ALTER TABLE `insercao`
ADD CONSTRAINT `insercao_ibfk_1` FOREIGN KEY (`codp`) REFERENCES `produto` (`cod`),
ADD CONSTRAINT `insercao_ibfk_2` FOREIGN KEY (`cnpj`) REFERENCES `fornecedor` (`cnpj`);

--
-- Limitadores para a tabela `localizacao`
--
ALTER TABLE `localizacao`
ADD CONSTRAINT `localizacao_ibfk_1` FOREIGN KEY (`codp`) REFERENCES `produto` (`cod`),
ADD CONSTRAINT `localizacao_ibfk_2` FOREIGN KEY (`codl`) REFERENCES `local` (`codl`);

--
-- Limitadores para a tabela `remocao`
--
ALTER TABLE `remocao`
ADD CONSTRAINT `remocao_ibfk_1` FOREIGN KEY (`codp`) REFERENCES `produto` (`cod`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
