-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30/06/2025 às 22:51
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
-- Banco de dados: `projeto_roleta`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `historico_giros`
--

CREATE TABLE `historico_giros` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `premio_id` int(11) NOT NULL,
  `data_giro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `historico_giros`
--

INSERT INTO `historico_giros` (`id`, `usuario_id`, `premio_id`, `data_giro`) VALUES
(44, 10, 1, '2025-06-30 19:24:49'),
(53, 10, 1, '2025-06-30 19:58:22'),
(54, 10, 2, '2025-06-30 19:58:36'),
(55, 10, 2, '2025-06-30 19:58:41'),
(56, 10, 1, '2025-06-30 19:59:28'),
(57, 10, 2, '2025-06-30 19:59:42'),
(58, 10, 1, '2025-06-30 20:00:21'),
(59, 10, 1, '2025-06-30 20:00:34'),
(60, 10, 3, '2025-06-30 20:01:44'),
(61, 10, 2, '2025-06-30 20:01:55'),
(62, 10, 1, '2025-06-30 20:05:18'),
(63, 10, 1, '2025-06-30 20:05:20'),
(64, 10, 1, '2025-06-30 20:05:21'),
(65, 10, 1, '2025-06-30 20:05:23'),
(67, 10, 1, '2025-06-30 20:18:26'),
(68, 10, 3, '2025-06-30 20:18:31'),
(69, 10, 3, '2025-06-30 20:18:32'),
(70, 10, 2, '2025-06-30 20:18:47'),
(71, 10, 3, '2025-06-30 20:18:52'),
(72, 10, 4, '2025-06-30 20:19:16'),
(73, 10, 1, '2025-06-30 20:21:00'),
(74, 10, 2, '2025-06-30 20:21:09'),
(75, 10, 3, '2025-06-30 20:21:12'),
(76, 10, 1, '2025-06-30 20:21:18'),
(77, 10, 2, '2025-06-30 20:21:50'),
(78, 10, 1, '2025-06-30 20:22:33'),
(79, 10, 2, '2025-06-30 20:24:28'),
(80, 10, 3, '2025-06-30 20:25:25'),
(81, 10, 3, '2025-06-30 20:25:27'),
(82, 10, 4, '2025-06-30 20:25:34'),
(83, 10, 1, '2025-06-30 20:25:37'),
(86, 10, 1, '2025-06-30 20:28:33'),
(87, 10, 2, '2025-06-30 20:28:54');

-- --------------------------------------------------------

--
-- Estrutura para tabela `premios`
--

CREATE TABLE `premios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `chance` int(11) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `premios`
--

INSERT INTO `premios` (`id`, `nome`, `chance`, `criado_em`) VALUES
(1, 'Vale Bombom', 40, '2025-06-25 22:48:18'),
(2, 'Vale 1 bala', 30, '2025-06-25 22:48:18'),
(3, 'Vale 2 balas', 20, '2025-06-25 22:48:18'),
(4, 'Vale 3 balas', 8, '2025-06-25 22:48:18'),
(5, 'Nada! Tente de novo 😅', 2, '2025-06-25 22:48:18');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` enum('usuario','admin') DEFAULT 'usuario',
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `tipo`, `criado_em`) VALUES
(10, 'felipe admin', 'felipe@admin.com', '$2y$10$wu0ouR.Yww3796N88bZiROWNtQDavfh6LXWMYcdTehOXItTuXzuX.', 'admin', '2025-06-30 19:22:45');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `historico_giros`
--
ALTER TABLE `historico_giros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `premio_id` (`premio_id`);

--
-- Índices de tabela `premios`
--
ALTER TABLE `premios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `historico_giros`
--
ALTER TABLE `historico_giros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT de tabela `premios`
--
ALTER TABLE `premios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `historico_giros`
--
ALTER TABLE `historico_giros`
  ADD CONSTRAINT `historico_giros_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `historico_giros_ibfk_2` FOREIGN KEY (`premio_id`) REFERENCES `premios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
