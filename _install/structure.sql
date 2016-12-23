CREATE TABLE `user`
(
  `userId` INT(11) PRIMARY KEY AUTO_INCREMENT,
  `name` char(50),
  `email` char(100),
  `password` CHAR (255)
) ENGINE=InnoDb COLLATE 'utf8_general_ci';