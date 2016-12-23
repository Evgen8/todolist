CREATE DATABASE phpadvanced COLLATE utf8_general_ci;
use phpadvanced;
CREATE USER 'phpadvanced'@'localhost' IDENTIFIED BY  'phpadvanced';
GRANT ALL PRIVILEGES ON  `phpadvanced` . * TO  'phpadvanced'@'localhost';