-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 12, 2017 at 04:56 PM
-- Server version: 5.6.34-log
-- PHP Version: 7.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestionpersonal`
--

-- --------------------------------------------------------

--
-- Table structure for table `departament`
--

CREATE TABLE `departament` (
  `id` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `type` tinytext NOT NULL,
  `plant` tinytext NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departament`
--

INSERT INTO `departament` (`id`, `name`, `type`, `plant`, `created_at`, `updated_at`) VALUES
(1, 'stewardship', 'stewardship', '1', '0000-00-00', '0000-00-00'),
(2, 'marketing', 'marketing', '2', '0000-00-00', '0000-00-00'),
(3, 'accounting', 'accounting', '3', '0000-00-00', '0000-00-00'),
(4, 'control', 'stewardship', '4', '0000-00-00', '2017-12-10'),
(5, 'despidos', 'Human Resources', '2', '2017-12-12', '2017-12-12'),
(6, 'registros', 'Human Resources', '2', '2017-12-12', '2017-12-12');

-- --------------------------------------------------------

--
-- Table structure for table `employed`
--

CREATE TABLE `employed` (
  `id` int(11) NOT NULL,
  `idDepartament` int(11) NOT NULL,
  `name` varchar(35) NOT NULL,
  `surnames` varchar(35) NOT NULL,
  `address` varchar(50) DEFAULT NULL,
  `postcode` varchar(15) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `movil` int(11) NOT NULL,
  `image` tinytext NOT NULL,
  `lasted_Job` varchar(50) DEFAULT NULL,
  `lasted_studies` varchar(50) DEFAULT NULL,
  `job_position` varchar(50) NOT NULL,
  `departament` varchar(30) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employed`
--

INSERT INTO `employed` (`id`, `idDepartament`, `name`, `surnames`, `address`, `postcode`, `email`, `movil`, `image`, `lasted_Job`, `lasted_studies`, `job_position`, `departament`, `created_at`, `updated_at`) VALUES
(3, 1, 'manolo', 'felix', 'calleraro', '2542154', 'mjnsds@gmail.com', 786876, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRU-_J1YgLCKwImevwoboXjfcdUg_YlAfvl20HTg8bKHHdvc30s', '', '', 'gestor', 'stewardship', '0000-00-00', '2017-12-05'),
(5, 3, 'manolo', 'ramirez', 'calle cadiz', '3434', 'sdsad@gmail.com', 343243243, 'http://images.mediabiz.de/flbilder/max06/mbiz06/mbiz21/z0621162/w186.jpg', NULL, NULL, 'administrador', 'accounting', '2017-12-06', '2017-12-06'),
(8, 4, 'raul', 'sanchez', 'calle', '231232', 'dsadas@gmaill.com', 4235454, 'https://upload.wikimedia.org/wikipedia/commons/4/4c/Personas_introvertidas_buenos_lideres.jpg', '', '', 'matematicas', 'gestion', '2017-12-27', '2017-12-05'),
(12, 2, 'marco', 'lopez', 'calle', '3243', 'pedro@gmail.com', 3423432, 'https://static.vix.com/es/sites/default/files/styles/large/public/btg/tech.batanga.com/files/Conoce-el-origen-de-la-fortuna-de-las-personas-mas-ricas-del-mundo-tecnologico4.jpg?itok=E7Xm5Zp9', '', 'ingeniero', 'contable', 'marketing', '2017-12-10', '2017-12-12');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(12, 'thinway', 'fran@gmail.com', '$2y$10$EF6PnaJwgiCMHgc20H43uODFKAEkGloMWecOGO3EguBHNG5S5oWhK', '2017-12-12', '2017-12-12'),
(13, 'mustafa', 'musta@gmail.com', '$2y$10$U24utNP0HQ6pb/AAxuXiz.md2GkF1oTaYMBfg7ixqSYPpzxuVu/6W', '2017-12-12', '2017-12-12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departament`
--
ALTER TABLE `departament`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employed`
--
ALTER TABLE `employed`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_USUARIO_idDepartament` (`idDepartament`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departament`
--
ALTER TABLE `departament`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `employed`
--
ALTER TABLE `employed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `employed`
--
ALTER TABLE `employed`
  ADD CONSTRAINT `FK_USUARIO_idDepartament` FOREIGN KEY (`idDepartament`) REFERENCES `departament` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
