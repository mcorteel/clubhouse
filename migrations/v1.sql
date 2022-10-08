--
-- Create user table
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) CHARACTER SET latin1 NOT NULL,
  `last_name` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(120) CHARACTER SET latin1 NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `roles` varchar(300) CHARACTER SET latin1 DEFAULT 'user',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (first_name, email, password, roles, created_at) VALUES ('Admin', 'admin', '$2y$10$GE/Syi9lJJ.k5ZaIbR3ncOyQMqb8yb4k7ji.q/YQ7xz/RqTngqzcq', 'super_admin', NOW());

--
-- Create resource table
--

CREATE TABLE `resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `short_name` varchar(5) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Create reservation table
--

CREATE TABLE `reservations` (
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
  KEY `reservation_user_index` (`user`),
  KEY `reservation_resource` (`resource`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Create reservation <> player link table
--

CREATE TABLE `reservation_players` (
  `reservation` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `team` varchar(1) CHARACTER SET latin1 NOT NULL,
  UNIQUE KEY `reservation` (`reservation`,`user`),
  KEY `player_reservation` (`reservation`),
  KEY `player_user` (`user`),
  CONSTRAINT `reservation_player_reservation_constraint` FOREIGN KEY (`reservation`) REFERENCES `reservations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `reservation_player_user_constraint` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Create config table
--

CREATE TABLE `config` (
  `identifier` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Create picture table
--

CREATE TABLE `pictures` (
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

CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `user` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `content` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Add default reservation type to users
--

ALTER TABLE users ADD reservation_type varchar(20) NOT NULL;
UPDATE users SET reservation_type = 'normal';

--
-- Create partner table
--

CREATE TABLE `partners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `description` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
