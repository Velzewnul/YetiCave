drop database if exists YetiCave;
create database YetiCave
default character set utf8
default collate utf8_general_ci;
USE YetiCave;

CREATE TABLE categories
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(128) NOT NULL UNIQUE,
    symbolic_name VARCHAR(128)
);

CREATE TABLE users
(
    id                INT AUTO_INCREMENT PRIMARY KEY,
    registration_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    email             VARCHAR(128) NOT NULL UNIQUE,
    name              VARCHAR(128),
    password          VARCHAR(255),
    contact_info      TEXT
);

CREATE TABLE lots
(
    id              INT AUTO_INCREMENT PRIMARY KEY,
    add_date        DATETIME DEFAULT CURRENT_TIMESTAMP,
    lot_title       VARCHAR(255),
    lot_description TEXT,
    lot_image       VARCHAR(255),
    start_price     int,
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
    bet_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    bet_sum int,
    user_id int,
    lot_id int,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (lot_id) REFERENCES lots(id)
);


