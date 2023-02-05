<?php
$setup = include 'config/setup.php';
$prefix = $setup['database']['prefix'] ? $setup['database']['prefix'] : '';
?>
--
-- Create user table
--

CREATE TABLE `<?= $prefix ?>users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(255) NOT NULL,
  `roles` varchar(300) DEFAULT 'user',
  `created_at` datetime NOT NULL,
  `reservation_type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `<?= $prefix ?>unique_user_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Create default admin account
--

INSERT INTO `<?= $prefix ?>users` (first_name, email, password, roles, created_at) VALUES ('Admin', 'admin', '$2y$10$GE/Syi9lJJ.k5ZaIbR3ncOyQMqb8yb4k7ji.q/YQ7xz/RqTngqzcq', 'super_admin', NOW());


--
-- Add default reservation type to users
--

UPDATE `<?= $prefix ?>users` SET reservation_type = 'normal';

--
-- Create resource table
--

CREATE TABLE `<?= $prefix ?>resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `short_name` varchar(5) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Create reservation table
--

CREATE TABLE `<?= $prefix ?>reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `user` int(11) NOT NULL,
  `resource` int(11) NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `score` varchar(50) DEFAULT NULL,
  `recurrence` varchar(15) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `<?= $prefix ?>reservation_user_index` (`user`),
  KEY `<?= $prefix ?>reservation_resource` (`resource`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Create reservation <> player link table
--

CREATE TABLE `<?= $prefix ?>reservation_players` (
  `reservation` int(11) NOT NULL,
  `user` int(11) DEFAULT NULL,
  `team` varchar(1) NOT NULL,
  `guest_name` varchar(100) DEFAULT NULL,
  UNIQUE KEY `<?= $prefix ?>reservation` (`reservation`,`user`),
  KEY `<?= $prefix ?>player_reservation` (`reservation`),
  KEY `<?= $prefix ?>player_user` (`user`),
  CONSTRAINT `<?= $prefix ?>reservation_player_reservation_constraint` FOREIGN KEY (`reservation`) REFERENCES `<?= $prefix ?>reservations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `<?= $prefix ?>reservation_player_user_constraint` FOREIGN KEY (`user`) REFERENCES `<?= $prefix ?>users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Create config table
--

CREATE TABLE `<?= $prefix ?>config` (
  `identifier` varchar(50) NOT NULL,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Create picture table
--

CREATE TABLE `<?= $prefix ?>pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `user` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `file` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Create news table
--

CREATE TABLE `<?= $prefix ?>news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `user` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `content` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Create partner table
--

CREATE TABLE `<?= $prefix ?>partners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
