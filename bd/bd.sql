 DROP DATABASE IF EXISTS  `DB_Chat`;
CREATE DATABASE `DB_Chat`;

CREATE TABLE `tbl_usuarios`(
    `id_usu`  INT(3) PRIMARY KEY AUTO_INCREMENT,
    `nick_usu` VARCHAR(25) NOT NULL,
    `nom_usu` VARCHAR(50) NOT NULL,
    `email_usu` VARCHAR(100) NOT NULL, 
    `pwd_usu` VARCHAR(255) NOT NULL
);

CREATE TABLE `tbl_amistad`(
    `id_amistad` INT(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `id_emisor` INT NOT NULL,
    `id_receptor` INT NOT NULL, 
    `boamistad` bit NOT NULL 
);

CREATE TABLE `tbl_chat`(
    `id_chat` INT(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `id_emisor` INT NOT NULL,
    `id_receptor` INT NOT NULL,
    `mensaje_chat` VARCHAR(255) NOT NULL
);

ALTER TABLE `tbl_amistad` 
ADD CONSTRAINT `fk_amistad_emisor`
FOREIGN KEY (`id_emisor`) REFERENCES `tbl_usuarios`(`id_usu`);


ALTER TABLE `tbl_amistad` 
ADD CONSTRAINT `fk_amistad_receptor`
FOREIGN KEY (`id_receptor`) REFERENCES `tbl_usuarios`(`id_usu`);

ALTER TABLE `tbl_chat` 
ADD CONSTRAINT `fk_chat_emisor`
FOREIGN KEY (`id_emisor`) REFERENCES `tbl_usuarios`(`id_usu`);

ALTER TABLE `tbl_chat` 
ADD CONSTRAINT `fk_chat_receptor`
FOREIGN KEY (`id_receptor`) REFERENCES `tbl_usuarios`(`id_usu`);
