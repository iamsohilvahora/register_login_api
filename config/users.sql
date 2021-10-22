CREATE TABLE IF NOT EXISTS `users`(
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `firstname` varchar(255) NOT NULL,
 `lastname` varchar(255) NOT NULL,
 `email` varchar(255) NOT NULL,
 `password` varchar(255) NOT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `email` (`email`)
);