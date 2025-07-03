-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03/07/2025 às 21:53
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
(98, 10, 4, '2025-07-02 19:42:48'),
(99, 10, 2, '2025-07-01 19:42:48'),
(100, 10, 5, '2025-06-30 19:42:48'),
(101, 33, 3, '2025-07-02 19:42:48'),
(102, 33, 4, '2025-07-01 19:42:48'),
(103, 33, 4, '2025-06-30 19:42:48'),
(104, 34, 2, '2025-07-02 19:42:48'),
(105, 34, 4, '2025-07-01 19:42:48'),
(106, 34, 4, '2025-06-30 19:42:48'),
(107, 35, 4, '2025-07-02 19:42:48'),
(108, 35, 1, '2025-07-01 19:42:48'),
(109, 35, 2, '2025-06-30 19:42:48'),
(110, 36, 2, '2025-07-02 19:42:48'),
(111, 36, 3, '2025-07-01 19:42:48'),
(112, 36, 3, '2025-06-30 19:42:48'),
(113, 37, 1, '2025-07-02 19:42:48'),
(114, 37, 4, '2025-07-01 19:42:48'),
(115, 37, 2, '2025-06-30 19:42:48'),
(116, 38, 2, '2025-07-02 19:42:48'),
(117, 38, 1, '2025-07-01 19:42:48'),
(118, 38, 2, '2025-06-30 19:42:48'),
(119, 10, 2, '2025-07-03 19:52:56');

-- --------------------------------------------------------

--
-- Estrutura para tabela `premios`
--

CREATE TABLE `premios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `chance` int(11) NOT NULL,
  `pontos` int(11) NOT NULL DEFAULT 0,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `premios`
--

INSERT INTO `premios` (`id`, `nome`, `chance`, `pontos`, `criado_em`) VALUES
(1, 'Vale Bombom', 40, 5, '2025-06-25 22:48:18'),
(2, 'Vale 1 bala', 30, 1, '2025-06-25 22:48:18'),
(3, 'Vale 2 balas', 20, 2, '2025-06-25 22:48:18'),
(4, 'Vale 3 balas', 8, 3, '2025-06-25 22:48:18'),
(5, 'Nada! Tente de novo 😅', 2, 0, '2025-06-25 22:48:18');

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
  `foto_perfil` varchar(255) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `tipo`, `foto_perfil`, `criado_em`) VALUES
(10, 'Felipe Admin', 'felipe@admin.com', '$2y$10$wu0ouR.Yww3796N88bZiROWNtQDavfh6LXWMYcdTehOXItTuXzuX.', 'admin', 'felipe.png', '2025-06-30 19:22:45'),
(33, ' Arthur Mazzardo Naue', 'arthur.naue@ifsc.edu.br', '$2y$10$1Cn64Qe0hzpK0Gc30Kdy2uloqIWaYe5bY21H/pPMaw8FzMCKNSeNO', 'usuario', 'arthur.png', '2025-07-03 19:28:27'),
(34, 'Daniel Diefenthaeler Santos', 'daniel.ds2005@aluno.ifsc.edu.br', '$2y$10$JHuH7UXyMno1moFro8R3nuPG0KkH1y14ldWGuaMzKzhWVt82ho1bq', 'usuario', 'daniel.jpeg', '2025-07-03 19:34:58'),
(35, 'Pedro Jaremczuk Zanoni Silveira', 'pedro.j2005@aluno.ifsc.edu.br', '$2y$10$q.7y/09QopaG0JVRwM/bF.BrugojaoLA3WtNrZZG8s/e42tjQjNla', 'usuario', 'pedro.jpg', '2025-07-03 19:35:14'),
(36, 'Higor Rodrigues Estevão', 'higor.e11@aluno.ifsc.edu.br', '$2y$10$VRf3H3VOmROR3QT9OpKnluMollf0Fe6SoYkK8GfjGodNnS4ILQ4EW', 'usuario', 'higor.jpg', '2025-07-03 19:35:27'),
(37, 'Michel David De Souza', 'michel.ds05@aluno.ifsc.edu.br', '$2y$10$lURkOrSEPFyYaMg6GIsivuf21CRxQ1Y52JIaNbjpAmwcoYOgqJo/u', 'usuario', 'michel.png', '2025-07-03 19:35:52'),
(38, 'Victor Leonardo Fagundes Dos Santos', 'victor.lf09@aluno.ifsc.edu.br', '$2y$10$N9FFhz62t2F5kikOmdywcuGjdFryrJJqYIWr6m.040vbdlI6xGave', 'usuario', 'victor.jpg', '2025-07-03 19:36:18');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT de tabela `premios`
--
ALTER TABLE `premios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

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
