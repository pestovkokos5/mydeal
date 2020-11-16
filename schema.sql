CREATE DATABASE mydeal;

USE mydeal;

CREATE TABLE `projects` (
	`id` INT AUTO_INCREMENT NOT NULL,
	`user_id` INT NOT NULL,
	`projects` CHAR(128) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE INDEX user_id ON projects(user_id);

CREATE TABLE `tasks` (
	`id` INT AUTO_INCREMENT NOT NULL,
	`user_id` INT NOT NULL,
	`project_id` INT NOT NULL,
	`date_create` datetime NOT NULL,
	`status` INT DEFAULT 0,
	`name` CHAR(128) NOT NULL,
	`file` CHAR(128),
	`srok` date NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE INDEX user_id ON tasks(user_id);
CREATE INDEX project_id ON tasks(project_id);

CREATE TABLE `users` (
	`id` INT AUTO_INCREMENT NOT NULL,
	`date` datetime NOT NULL,
	`email` CHAR(128) UNIQUE NOT NULL,
	`name`  CHAR(128) NOT NULL,
	`password` varchar(40) NOT NULL,
	PRIMARY KEY (`id`)
);