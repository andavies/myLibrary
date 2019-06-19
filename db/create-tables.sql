CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
);

CREATE TABLE IF NOT EXISTS `books` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT, 
  `isbn` varchar(13),
  `title` varchar(255),
  `author` varchar(255),
  `ownername` varchar(255),
  `ownerid` int(10),
  `thumb` varchar(255),
  `description` varchar(1023),
  PRIMARY KEY (`id`)
);