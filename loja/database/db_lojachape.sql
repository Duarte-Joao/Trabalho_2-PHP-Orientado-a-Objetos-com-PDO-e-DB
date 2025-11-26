-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           8.0.30 - MySQL Community Server - GPL
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para lojachape
CREATE DATABASE IF NOT EXISTS `lojachape` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `lojachape`;

-- Copiando estrutura para tabela lojachape.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `funcionario_id` int NOT NULL,
  `login` varchar(50) DEFAULT NULL,
  `senha` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__funcionario` (`funcionario_id`) USING BTREE,
  CONSTRAINT `FK__funcionario` FOREIGN KEY (`funcionario_id`) REFERENCES `funcionario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela lojachape.admin: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela lojachape.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `Nome` varchar(50) NOT NULL,
  `Telefone` varchar(20) NOT NULL,
  `Nascimento` date DEFAULT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `CPF` varchar(14) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela lojachape.clientes: ~2 rows (aproximadamente)
INSERT INTO `clientes` (`Nome`, `Telefone`, `Nascimento`, `id`, `CPF`) VALUES
	('joao', '123', '2007-03-02', 1, '111.111.111-00');

-- Copiando estrutura para tabela lojachape.funcionario
CREATE TABLE IF NOT EXISTS `funcionario` (
  `Nome` varchar(50) DEFAULT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `Cargo` varchar(50) DEFAULT NULL,
  `CPF` varchar(14) NOT NULL DEFAULT '',
  `Contato` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `CPF` (`CPF`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela lojachape.funcionario: ~1 rows (aproximadamente)
INSERT INTO `funcionario` (`Nome`, `id`, `Cargo`, `CPF`, `Contato`) VALUES
	('Joao', 1, 'Chefe', '12345555', '123452222');

-- Copiando estrutura para tabela lojachape.produtos
CREATE TABLE IF NOT EXISTS `produtos` (
  `Nome` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Sem nome',
  `id` int NOT NULL AUTO_INCREMENT,
  `Descricao` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela lojachape.produtos: ~0 rows (aproximadamente)
INSERT INTO `produtos` (`Nome`, `id`, `Descricao`) VALUES
	('camisa da chape', 1, 'camisa da chape oficial 2025');

-- Copiando estrutura para tabela lojachape.vendas
CREATE TABLE IF NOT EXISTS `vendas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quantidade` int NOT NULL DEFAULT '0',
  `data` date NOT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL,
  `idProduto` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_vendas_produtos` (`idProduto`),
  CONSTRAINT `FK_vendas_produtos` FOREIGN KEY (`idProduto`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela lojachape.vendas: ~0 rows (aproximadamente)
INSERT INTO `vendas` (`id`, `quantidade`, `data`, `valor_total`, `idProduto`) VALUES
	(1, 2, '0025-11-25', 400.00, 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
