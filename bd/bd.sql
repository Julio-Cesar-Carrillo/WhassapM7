-- Eliminar la base de datos si ya existe
DROP DATABASE IF EXISTS `DB_Chat`;

-- Crear base de datos con codificación UTF-8
CREATE DATABASE `DB_Chat` DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_unicode_ci;

-- Seleccionar la base de datos
USE `DB_Chat`;

-- Crear tabla de usuarios con codificación UTF-8
CREATE TABLE `tbl_usuarios` (
    `id_usu` INT(3) PRIMARY KEY AUTO_INCREMENT,
    `nick_usu` VARCHAR(25) NOT NULL,
    `nom_usu` VARCHAR(50) NOT NULL,
    `email_usu` VARCHAR(100) NOT NULL,
    `pwd_usu` VARCHAR(255) NOT NULL -- Contraseña más larga para mayor seguridad
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

-- Crear tabla de amistad con claves foráneas y codificación UTF-8
CREATE TABLE `tbl_amistad` (
    `id_amistad` INT(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `id_emisor` INT(3) NOT NULL,
    `id_receptor` INT(3) NOT NULL,
    `boamistad` BOOLEAN NOT NULL,
    CONSTRAINT `fk_amistad_emisor` FOREIGN KEY (`id_emisor`) REFERENCES `tbl_usuarios`(`id_usu`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_amistad_receptor` FOREIGN KEY (`id_receptor`) REFERENCES `tbl_usuarios`(`id_usu`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

-- Crear tabla de chat con claves foráneas y codificación UTF-8
CREATE TABLE `tbl_chat` (
    `id_chat` INT(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `id_emisor` INT(3) NOT NULL,
    `id_receptor` INT(3) NOT NULL,
    `mensaje_chat` VARCHAR(255) NOT NULL,
    `fecha_hora_chat` DATETIME NOT NULL,
    CONSTRAINT `fk_chat_emisor` FOREIGN KEY (`id_emisor`) REFERENCES `tbl_usuarios`(`id_usu`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_chat_receptor` FOREIGN KEY (`id_receptor`) REFERENCES `tbl_usuarios`(`id_usu`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

-- INSERT USUARIOS
INSERT INTO
    `tbl_usuarios`
VALUES
    (
        NULL,
        'Darckfer',
        'julio',
        'julio@gmail.com',
        -- pwd: qweQWE123
        '$2y$10$kblAysOfzXAC22VbXsH/5enRooF5m1ShZEEazPbeGV7HqvdyuzECS'
    ),
    (
        NULL,
        'Don Cangrejo',
        'Daniel',
        'daniel@gmail.com',
        -- pwd: qweQWE123
        '$2y$10$kblAysOfzXAC22VbXsH/5enRooF5m1ShZEEazPbeGV7HqvdyuzECS'
    ),
    (
        NULL,
        'Drax',
        'Wilson',
        'wilson@gmail.com',
        -- pwd: qweQWE123
        '$2y$10$kblAysOfzXAC22VbXsH/5enRooF5m1ShZEEazPbeGV7HqvdyuzECS'
    );

-- INSER AMIGOS
INSERT INTO
    `tbl_amistad`
VALUES
    (NULL, '1', '2', 1),
    (NULL, '1', '3', 0);

-- INSERT CHATS
INSERT INTO
    `tbl_chat`
VALUES
    (NULL, '2', '1', 'hola', NOW()),
    (NULL, '1', '2', 'Wenas', NOW()),
    (NULL, '1', '3', 'Hola', NOW());