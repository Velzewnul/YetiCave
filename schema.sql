drop database if exists YetiCave;
create database YetiCave
default character set utf8
default collate utf8_general_ci;
USE YetiCave;

CREATE TABLE categories
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name char(64) NOT NULL UNIQUE,
    symbolic_name char(64) NOT NULL UNIQUE
);

CREATE TABLE users
(
    id                INT AUTO_INCREMENT PRIMARY KEY,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email             char(64) NOT NULL UNIQUE,
    name              char(10) NOT NULL,
    password          VARCHAR(32) NOT NULL,
    contact_info      char(128) NOT NULL
);

CREATE TABLE lots
(
    id              INT AUTO_INCREMENT PRIMARY KEY,
    add_date        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    lot_title       VARCHAR(64) NOT NULL,
    lot_description TEXT,
    lot_image       VARCHAR(64),
    start_price     int         NOT NULL,
    end_date        DATE,
    bet_step        int,
    user_id         int,
    winner_id       int,
    category_id     int,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (winner_id) REFERENCES users(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE bets
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    bet_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    bet_sum int NOT NULL,
    user_id int,
    lot_id int,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (lot_id) REFERENCES lots(id)
);


