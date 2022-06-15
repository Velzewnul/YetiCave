create database YetiCave
default character set utf8
default collate utf8_general_ci;
USE YetiCave;

CREATE TABLE YetiCave.categories
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name char(64),
    symbolic_name char(64)
);
CREATE TABLE YetiCave.lots
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    add_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    lot_title CHAR(64),
    lot_description TEXT,
    lot_image CHAR(64),
    start_price int,
    end_price int,
    bet_step int
);
CREATE TABLE YetiCave.bets
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    bet_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    bet_sum int
);
CREATE TABLE YetiCave.users
(
    id                INT AUTO_INCREMENT PRIMARY KEY,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email             char(64),
    name              char(10),
    password          char(12),
    contact_info      char(128)
);
