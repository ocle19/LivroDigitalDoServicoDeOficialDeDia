-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18-Maio-2021 às 21:06
-- Versão do servidor: 10.4.17-MariaDB
-- versão do PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `livros`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agua`
--

CREATE TABLE `agua` (
  `id` int(11) NOT NULL,
  `atual` varchar(20) NOT NULL,
  `anterior` varchar(20) NOT NULL,
  `consumo` varchar(20) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `agua`
--

INSERT INTO `agua` (`id`, `atual`, `anterior`, `consumo`, `data`) VALUES
(1, '10', '0', '10.00', '2021-05-17');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aosubcmt`
--

CREATE TABLE `aosubcmt` (
  `id` int(11) NOT NULL,
  `doDia` date NOT NULL,
  `paraoDia` date NOT NULL,
  `vistoScmt` varchar(20) NOT NULL DEFAULT 'NO',
  `vistoFiscal` varchar(20) NOT NULL DEFAULT 'NO',
  `vistoS1` varchar(2) NOT NULL DEFAULT 'NO',
  `recebiDo` varchar(30) NOT NULL,
  `pessoalDeSv` varchar(100) NOT NULL,
  `paradaDiaria` varchar(5000) NOT NULL,
  `RevistadoRecolher` varchar(5000) NOT NULL,
  `passeiAo` varchar(30) NOT NULL DEFAULT '',
  `diaPassagem` timestamp NOT NULL DEFAULT current_timestamp(),
  `assinaturaOfDia` varchar(200) NOT NULL DEFAULT '',
  `assinaturaAdj` varchar(50) NOT NULL DEFAULT 'Adj',
  `ofdia` varchar(30) NOT NULL,
  `vistoS2` varchar(3) DEFAULT 'NO',
  `vistoPO` varchar(3) DEFAULT 'NO',
  `vistoAprov` varchar(3) DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `aosubcmt`
--

INSERT INTO `aosubcmt` (`id`, `doDia`, `paraoDia`, `vistoScmt`, `vistoFiscal`, `vistoS1`, `recebiDo`, `pessoalDeSv`, `paradaDiaria`, `RevistadoRecolher`, `passeiAo`, `diaPassagem`, `assinaturaOfDia`, `assinaturaAdj`, `ofdia`, `vistoS2`, `vistoPO`, `vistoAprov`) VALUES
(1, '2021-05-17', '2021-05-18', 'NO', 'NO', 'NO', 'Asp Of OFDIA', '001 de 16 de maio de 2021 da OM', 'Bateria Comando: Sem altera&ccedil;&atilde;o.\r\nPrimeira Bateria: Sem altera&ccedil;&atilde;o.\r\nSegunda Bateria: Sem altera&ccedil;&atilde;o.\r\nTerceira Bateria: Sem altera&ccedil;&atilde;o.', 'Sem altera&ccedil;&atilde;o', 'Asp Of OFDIA', '2021-05-17 13:41:25', 'A', 'adj', 'Asp Of OFDIA', 'NO', 'NO', 'NO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cadeadosguarda`
--

CREATE TABLE `cadeadosguarda` (
  `id` int(11) NOT NULL,
  `descricao` varchar(5000) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `cadeadosguarda`
--

INSERT INTO `cadeadosguarda` (`id`, `descricao`, `data`) VALUES
(1, 'Cadeado do PA: Sem altera&ccedil;&atilde;o.\r\nCadeado do PL: Sem altera&ccedil;&atilde;o.\r\nCadeado do ARM&Aacute;RIO DOS FUZIS: Sem altera&ccedil;&atilde;o.\r\nCadeados das ARMARIAS: Sem altera&ccedil;&atilde;o.\r\nCadeado da LIXEIRA: Sem altera&ccedil;&atilde;o.\r\n                    ', '2021-05-17');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcao`
--

CREATE TABLE `funcao` (
  `id` int(11) NOT NULL,
  `descricao` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `funcao`
--

INSERT INTO `funcao` (`id`, `descricao`) VALUES
(1, 'Militar'),
(2, 'Furriel'),
(3, 'Aprov');

-- --------------------------------------------------------

--
-- Estrutura da tabela `instalacoes`
--

CREATE TABLE `instalacoes` (
  `id` int(11) NOT NULL,
  `descricao` varchar(50000) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `instalacoes`
--

INSERT INTO `instalacoes` (`id`, `descricao`, `data`) VALUES
(1, 'Sem altera&ccedil;&atilde;o.', '2021-05-17');

-- --------------------------------------------------------

--
-- Estrutura da tabela `luz03`
--

CREATE TABLE `luz03` (
  `id` int(11) NOT NULL,
  `atual` varchar(20) NOT NULL,
  `anterior` varchar(20) DEFAULT NULL,
  `consumo` varchar(20) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `luz03`
--

INSERT INTO `luz03` (`id`, `atual`, `anterior`, `consumo`, `data`) VALUES
(1, '15', '0', '15.00', '2021-05-17');

-- --------------------------------------------------------

--
-- Estrutura da tabela `luz24`
--

CREATE TABLE `luz24` (
  `id` int(11) NOT NULL,
  `atual` varchar(20) NOT NULL,
  `anterior` varchar(20) DEFAULT NULL,
  `consumo` varchar(20) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `luz24`
--

INSERT INTO `luz24` (`id`, `atual`, `anterior`, `consumo`, `data`) VALUES
(1, '20', '0', '20.00', '2021-05-17');

-- --------------------------------------------------------

--
-- Estrutura da tabela `luz52`
--

CREATE TABLE `luz52` (
  `id` int(11) NOT NULL,
  `atual` varchar(20) NOT NULL,
  `anterior` varchar(20) NOT NULL,
  `consumo` varchar(20) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `luz52`
--

INSERT INTO `luz52` (`id`, `atual`, `anterior`, `consumo`, `data`) VALUES
(1, '25', '0', '25.00', '2021-05-17');

-- --------------------------------------------------------

--
-- Estrutura da tabela `municao`
--

CREATE TABLE `municao` (
  `id` int(11) NOT NULL,
  `descricao` varchar(5000) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `municao`
--

INSERT INTO `municao` (`id`, `descricao`, `data`) VALUES
(1, 'Sem altera&ccedil;&atilde;o.', '2021-05-17');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ocorrenciasaofiscal`
--

CREATE TABLE `ocorrenciasaofiscal` (
  `id` int(11) NOT NULL,
  `descricao` varchar(50000) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `ocorrenciasaofiscal`
--

INSERT INTO `ocorrenciasaofiscal` (`id`, `descricao`, `data`) VALUES
(1, 'Sem altera&ccedil;&atilde;o.', '2021-05-17');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ocorrenciasaoscmt`
--

CREATE TABLE `ocorrenciasaoscmt` (
  `id` int(11) NOT NULL,
  `descricao` varchar(5000) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `ocorrenciasaoscmt`
--

INSERT INTO `ocorrenciasaoscmt` (`id`, `descricao`, `data`) VALUES
(1, 'Sem altera&ccedil;&atilde;o.', '2021-05-17');

-- --------------------------------------------------------

--
-- Estrutura da tabela `punidos`
--

CREATE TABLE `punidos` (
  `id` int(11) NOT NULL,
  `graduacao` varchar(10) NOT NULL DEFAULT 'SD',
  `numero` varchar(5) NOT NULL,
  `nomecompleto` varchar(500) NOT NULL,
  `su` varchar(20) NOT NULL,
  `inicio` date NOT NULL,
  `liberdade` date NOT NULL,
  `dias` int(5) NOT NULL DEFAULT 0,
  `punicao` varchar(150) NOT NULL,
  `bi` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `punidos`
--

INSERT INTO `punidos` (`id`, `graduacao`, `numero`, `nomecompleto`, `su`, `inicio`, `liberdade`, `dias`, `punicao`, `bi`) VALUES
(1, 'Sd Ef Vrl', '50', 'FULANO', 'BC', '2021-05-16', '2021-05-18', 0, '1', '001');

-- --------------------------------------------------------

--
-- Estrutura da tabela `reservabc`
--

CREATE TABLE `reservabc` (
  `id` int(11) NOT NULL,
  `gdhfechamento` varchar(50) NOT NULL,
  `gdhabertura` varchar(50) NOT NULL,
  `lacre` varchar(50) NOT NULL,
  `cadeados` varchar(100) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `reservabc`
--

INSERT INTO `reservabc` (`id`, `gdhfechamento`, `gdhabertura`, `lacre`, `cadeados`, `data`) VALUES
(1, '1', '1', '1', '1', '2021-05-17');

-- --------------------------------------------------------

--
-- Estrutura da tabela `reservaprimeira`
--

CREATE TABLE `reservaprimeira` (
  `id` int(11) NOT NULL,
  `gdhfechamento` varchar(50) NOT NULL,
  `gdhabertura` varchar(50) NOT NULL,
  `lacre` varchar(50) NOT NULL,
  `cadeados` varchar(50) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `reservaprimeira`
--

INSERT INTO `reservaprimeira` (`id`, `gdhfechamento`, `gdhabertura`, `lacre`, `cadeados`, `data`) VALUES
(1, '2', '2', '2', '2', '2021-05-17');

-- --------------------------------------------------------

--
-- Estrutura da tabela `reservasegunda`
--

CREATE TABLE `reservasegunda` (
  `id` int(11) NOT NULL,
  `gdhfechamento` varchar(50) NOT NULL,
  `gdhabertura` varchar(50) NOT NULL,
  `lacre` varchar(50) NOT NULL,
  `cadeados` varchar(50) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `reservasegunda`
--

INSERT INTO `reservasegunda` (`id`, `gdhfechamento`, `gdhabertura`, `lacre`, `cadeados`, `data`) VALUES
(1, '3', '3', '3', '3', '2021-05-17');

-- --------------------------------------------------------

--
-- Estrutura da tabela `reservaterceira`
--

CREATE TABLE `reservaterceira` (
  `id` int(11) NOT NULL,
  `gdhfechamento` varchar(50) NOT NULL,
  `gdhabertura` varchar(50) NOT NULL,
  `lacre` varchar(50) NOT NULL,
  `cadeados` varchar(50) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `reservaterceira`
--

INSERT INTO `reservaterceira` (`id`, `gdhfechamento`, `gdhabertura`, `lacre`, `cadeados`, `data`) VALUES
(1, '4', '4', '4', '4', '2021-05-17');

-- --------------------------------------------------------

--
-- Estrutura da tabela `rondaofdia`
--

CREATE TABLE `rondaofdia` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `ronda1` varchar(5) DEFAULT NULL,
  `ronda2` varchar(5) DEFAULT NULL,
  `ronda3` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `rondaofdia`
--

INSERT INTO `rondaofdia` (`id`, `data`, `ronda1`, `ronda2`, `ronda3`) VALUES
(1, '2021-05-17', '09:00', '22:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `salacombc`
--

CREATE TABLE `salacombc` (
  `id` int(11) NOT NULL,
  `lacre` int(50) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `salacombc`
--

INSERT INTO `salacombc` (`id`, `lacre`, `data`) VALUES
(1, 5, '2021-05-17');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sobraseresiduos`
--

CREATE TABLE `sobraseresiduos` (
  `id` int(11) NOT NULL,
  `sobra` int(11) NOT NULL DEFAULT 0,
  `residuos` int(11) NOT NULL DEFAULT 0,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `sobraseresiduos`
--

INSERT INTO `sobraseresiduos` (`id`, `sobra`, `residuos`, `data`) VALUES
(1, 10, 3, '2021-05-17');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `user_id` int(11) NOT NULL,
  `user_nome` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `grad` varchar(10) NOT NULL,
  `user_nomecompleto` varchar(50) NOT NULL,
  `user_senha` varchar(30) NOT NULL,
  `user_nivel` int(1) NOT NULL,
  `assinatura` varchar(100) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'ATIVADO',
  `grad2` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`user_id`, `user_nome`, `grad`, `user_nomecompleto`, `user_senha`, `user_nivel`, `assinatura`, `status`, `grad2`) VALUES
(1, 'admin', 'Cb', 'Administrador do Sistema', '123', 6, 'adm', 'ATIVADO', 'Cb'),
(4, 'adj', '1º Sgt', 'Adjunto ao Of Dia', '123', 1, 'adj', 'ATIVADO', '1º Sgt'),
(37, 'consulta', '', 'Usuário para consultas', '123', 4, 'consulta', 'ATIVADO', '2º Ten'),
(67, 'fiscal', '', 'Fiscal Administrativo', '123', 3, 'fiscal', 'ATIVADO', 'Maj'),
(72, 'ofdia', 'Asp Of', 'Oficial de Dia á', '123', 2, 'ofdia', 'ATIVADO', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `agua`
--
ALTER TABLE `agua`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `aosubcmt`
--
ALTER TABLE `aosubcmt`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `doDia` (`doDia`);

--
-- Índices para tabela `cadeadosguarda`
--
ALTER TABLE `cadeadosguarda`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `funcao`
--
ALTER TABLE `funcao`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices para tabela `instalacoes`
--
ALTER TABLE `instalacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `DODIA` (`data`),
  ADD KEY `data` (`data`),
  ADD KEY `data_2` (`data`);

--
-- Índices para tabela `luz03`
--
ALTER TABLE `luz03`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `data` (`data`);

--
-- Índices para tabela `luz24`
--
ALTER TABLE `luz24`
  ADD PRIMARY KEY (`id`),
  ADD KEY `DODIAluz24` (`data`);

--
-- Índices para tabela `luz52`
--
ALTER TABLE `luz52`
  ADD PRIMARY KEY (`id`),
  ADD KEY `DODIAluz52` (`data`);

--
-- Índices para tabela `municao`
--
ALTER TABLE `municao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `DODIAmunicao` (`data`);

--
-- Índices para tabela `ocorrenciasaofiscal`
--
ALTER TABLE `ocorrenciasaofiscal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `DODIAocorrenciasaofiscal` (`data`);

--
-- Índices para tabela `ocorrenciasaoscmt`
--
ALTER TABLE `ocorrenciasaoscmt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `DODIAocorrenciasaoscmt` (`data`);

--
-- Índices para tabela `punidos`
--
ALTER TABLE `punidos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `reservabc`
--
ALTER TABLE `reservabc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `DODIAreservabc` (`data`);

--
-- Índices para tabela `reservaprimeira`
--
ALTER TABLE `reservaprimeira`
  ADD PRIMARY KEY (`id`),
  ADD KEY `DODIAreservaprimeira` (`data`);

--
-- Índices para tabela `reservasegunda`
--
ALTER TABLE `reservasegunda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `DODIAreservasegunda` (`data`);

--
-- Índices para tabela `reservaterceira`
--
ALTER TABLE `reservaterceira`
  ADD PRIMARY KEY (`id`),
  ADD KEY `DODIAreservaterceira` (`data`);

--
-- Índices para tabela `rondaofdia`
--
ALTER TABLE `rondaofdia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `DODIArondaOfdia` (`data`);

--
-- Índices para tabela `salacombc`
--
ALTER TABLE `salacombc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `DODIAsalacombc` (`data`);

--
-- Índices para tabela `sobraseresiduos`
--
ALTER TABLE `sobraseresiduos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `DODIAsobraseresiduos` (`data`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agua`
--
ALTER TABLE `agua`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `aosubcmt`
--
ALTER TABLE `aosubcmt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `cadeadosguarda`
--
ALTER TABLE `cadeadosguarda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `funcao`
--
ALTER TABLE `funcao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `instalacoes`
--
ALTER TABLE `instalacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `luz03`
--
ALTER TABLE `luz03`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `luz24`
--
ALTER TABLE `luz24`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `luz52`
--
ALTER TABLE `luz52`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `municao`
--
ALTER TABLE `municao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `ocorrenciasaofiscal`
--
ALTER TABLE `ocorrenciasaofiscal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `ocorrenciasaoscmt`
--
ALTER TABLE `ocorrenciasaoscmt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `punidos`
--
ALTER TABLE `punidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `reservabc`
--
ALTER TABLE `reservabc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `reservaprimeira`
--
ALTER TABLE `reservaprimeira`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `reservasegunda`
--
ALTER TABLE `reservasegunda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `reservaterceira`
--
ALTER TABLE `reservaterceira`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `rondaofdia`
--
ALTER TABLE `rondaofdia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `salacombc`
--
ALTER TABLE `salacombc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `sobraseresiduos`
--
ALTER TABLE `sobraseresiduos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
