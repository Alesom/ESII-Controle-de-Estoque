-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 06-Dez-2016 às 08:54
-- Versão do servidor: 10.1.13-MariaDB
-- PHP Version: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `estoque`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `cnpj` varchar(18) NOT NULL,
  `razao_social` varchar(30) NOT NULL,
  `nome_fantasia` varchar(30) NOT NULL,
  `endereco` varchar(40) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecimento`
--

CREATE TABLE `fornecimento` (
  `cod` bigint(20) UNSIGNED NOT NULL,
  `cnpj` varchar(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo`
--

CREATE TABLE `grupo` (
  `codg` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `insercao`
--

CREATE TABLE `insercao` (
  `codp` varchar(20) NOT NULL,
  `qtd` int(11) NOT NULL,
  `data` date NOT NULL,
  `cnpj` varchar(18) DEFAULT NULL,
  `vlr` decimal(10,0) NOT NULL,
  `nfe` varchar(30) DEFAULT NULL,
  `tipo` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `local`
--

CREATE TABLE `local` (
  `codl` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `localizacao`
--

CREATE TABLE `localizacao` (
  `codl` bigint(20) UNSIGNED NOT NULL,
  `codp` varchar(20) NOT NULL,
  `qtd` int(11) DEFAULT NULL,
  `qtdmin` int(11) DEFAULT NULL,
  `alarm` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `cod` varchar(20) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `medida` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `remocao`
--

CREATE TABLE `remocao` (
  `data` date NOT NULL,
  `qtd` int(11) NOT NULL,
  `codp` varchar(20) NOT NULL,
  `destino` varchar(100) NOT NULL,
  `chamado` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `cod` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(16) NOT NULL,
  `funcao` varchar(50) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `codl` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  ADD PRIMARY KEY (`codp`,`data`),
  ADD KEY `insercao_ibfk_2` (`cnpj`);

--
-- Indexes for table `local`
--
ALTER TABLE `local`
  ADD PRIMARY KEY (`codl`);

--
-- Indexes for table `localizacao`
--
ALTER TABLE `localizacao`
  ADD PRIMARY KEY (`codp`,`codl`),
  ADD KEY `localizacao_ibfk_2` (`codl`);

--
-- Indexes for table `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`cod`),
  ADD UNIQUE KEY `cod` (`cod`);

--
-- Indexes for table `remocao`
--
ALTER TABLE `remocao`
  ADD PRIMARY KEY (`data`,`codp`),
  ADD KEY `remocao_ibfk_1` (`codp`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`cod`),
  ADD UNIQUE KEY `cod` (`cod`),
  ADD KEY `codl` (`codl`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `grupo`
--
ALTER TABLE `grupo`
  MODIFY `codg` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `local`
--
ALTER TABLE `local`
  MODIFY `codl` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `cod` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
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