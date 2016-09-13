-- DROP DATABASE estoque;
-- CREATE DATABASE estoque;

-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 16, 2016 at 08:04 
-- Server version: 10.1.11-MariaDB
-- PHP Version: 7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


-- alterando o formato da data de yyyy-mm-dd para dd-mm-yyyy [en_US]->[pt_br]
SET GLOBAL lc_time_names=pt_BR;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `estoque`
--

-- --------------------------------------------------------

--
-- Table structure for table `grupo`
--

CREATE TABLE `grupo` (
  `codg` varchar(3) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `insercao`
--

CREATE TABLE `insercao` (
  `codp` bigint(20) UNSIGNED NOT NULL,
  `qtd` int(11) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `local`
--

CREATE TABLE `local` (
  `codl` varchar(3) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `produto`
--

CREATE TABLE `produto` (
  `cod` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(50) NOT NULL,
  `qtd` int(11) DEFAULT NULL,
  `codg` varchar(3) DEFAULT NULL,
  `codl` varchar(3) DEFAULT NULL,
  `qtdmin` int(11) DEFAULT NULL,
  `alarm` boolean DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `remocao`
--

CREATE TABLE `remocao` (
  `data` date NOT NULL,
  `qtd` int(11) NOT NULL,
  `codp` bigint(20) UNSIGNED NOT NULL,
  `destino` varchar(100) NOT NULL,
  `chamado` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
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
-- Indexes for table `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`codg`);

--
-- Indexes for table `insercao`
--
ALTER TABLE `insercao` ADD PRIMARY KEY (`codp`,`data`);
  

--
-- Indexes for table `local`
--
ALTER TABLE `local` ADD PRIMARY KEY (`codl`);

--
-- Indexes for table `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`cod`),
  ADD UNIQUE KEY `cod` (`cod`),
  ADD KEY `codg` (`codg`),
  ADD KEY `codl` (`codl`);

--
-- Indexes for table `remocao`
--
ALTER TABLE `remocao`ADD PRIMARY KEY (`data`,`codp`);

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
-- AUTO_INCREMENT for table `insercao`
--
ALTER TABLE `insercao`
  MODIFY `codp` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `produto`
--
ALTER TABLE `produto`
  MODIFY `cod` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `remocao`
--
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `cod` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `insercao`
--
ALTER TABLE `insercao`
  ADD CONSTRAINT `insercao_ibfk_1` FOREIGN KEY (`codp`) REFERENCES `produto` (`cod`);

--
-- Constraints for table `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`codg`) REFERENCES `grupo` (`codg`),
  ADD CONSTRAINT `produto_ibfk_2` FOREIGN KEY (`codl`) REFERENCES `local` (`codl`);

--
-- Constraints for table `remocao`
--
ALTER TABLE `remocao`
  ADD CONSTRAINT `remocao_ibfk_1` FOREIGN KEY (`codp`) REFERENCES `produto` (`cod`);

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`codl`) REFERENCES `local` (`codl`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
