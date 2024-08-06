-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06/08/2024 às 16:53
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `supermercado`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `entradas`
--

CREATE TABLE `entradas` (
  `id` int(11) NOT NULL,
  `promotor_id` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `hora_entrada` time DEFAULT NULL,
  `responsavel_entrada` int(11) DEFAULT NULL,
  `hora_saida` time DEFAULT NULL,
  `responsavel_saida` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `entradas`
--

INSERT INTO `entradas` (`id`, `promotor_id`, `data`, `hora_entrada`, `responsavel_entrada`, `hora_saida`, `responsavel_saida`) VALUES
(73, 29, '2024-08-05', '13:42:21', 29, '13:42:00', 28),
(74, 30, '2024-08-05', '13:42:41', 28, '13:42:00', 28);

-- --------------------------------------------------------

--
-- Estrutura para tabela `promotores`
--

CREATE TABLE `promotores` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `sexo` enum('M','F') NOT NULL,
  `empresa` varchar(255) NOT NULL,
  `dias_semana` varchar(255) NOT NULL,
  `telefone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `promotores`
--

INSERT INTO `promotores` (`id`, `nome`, `cpf`, `sexo`, `empresa`, `dias_semana`, `telefone`) VALUES
(29, 'Marcos Vinicius', '434.009.778-02', 'M', 'Zomper supermercados', 'Seg, Ter, Qua', '(19) 9106-1037'),
(30, 'João Da Silva', '123.525.668-51', 'M', 'Zomper supermercados', 'Seg, Qui, Sab', '(19) 9106-1037'),
(31, 'Vitor Da Silva Junior ', '065.925.369-00', 'M', 'pepsi', 'Seg, Qua', '(19) 99677-6726');

-- --------------------------------------------------------

--
-- Estrutura para tabela `responsaveis`
--

CREATE TABLE `responsaveis` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `sexo` enum('M','F') DEFAULT NULL,
  `setor` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `responsaveis`
--

INSERT INTO `responsaveis` (`id`, `nome`, `cpf`, `sexo`, `setor`) VALUES
(28, 'Marcos Vinicius Ferreira', '123.525.668-51', 'M', 'Mercearia'),
(29, 'Mauricio De Souza ', '434.009.778-02', 'M', 'Prevenção de Perdas');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`) VALUES
(1, 'prevencao', '*435D20ACF6EB5563E805DBD1C9A69EC273A32418');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promotor_id` (`promotor_id`),
  ADD KEY `responsavel_saida` (`responsavel_saida`),
  ADD KEY `fk_responsavel_entrada` (`responsavel_entrada`);

--
-- Índices de tabela `promotores`
--
ALTER TABLE `promotores`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `responsaveis`
--
ALTER TABLE `responsaveis`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `entradas`
--
ALTER TABLE `entradas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de tabela `promotores`
--
ALTER TABLE `promotores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de tabela `responsaveis`
--
ALTER TABLE `responsaveis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `entradas`
--
ALTER TABLE `entradas`
  ADD CONSTRAINT `entradas_ibfk_1` FOREIGN KEY (`promotor_id`) REFERENCES `promotores` (`id`),
  ADD CONSTRAINT `entradas_ibfk_2` FOREIGN KEY (`responsavel_entrada`) REFERENCES `responsaveis` (`id`),
  ADD CONSTRAINT `entradas_ibfk_3` FOREIGN KEY (`responsavel_saida`) REFERENCES `responsaveis` (`id`),
  ADD CONSTRAINT `fk_responsavel_entrada` FOREIGN KEY (`responsavel_entrada`) REFERENCES `responsaveis` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
