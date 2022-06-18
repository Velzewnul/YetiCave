INSERT INTO categories(category_name, symbolic_name)
VALUES ('Доски и лыжи', 'boards'),
       ('Крепления', 'attachment'),
       ('Ботинки', 'boots'),
       ('Одежда', 'clothing'),
       ('Инструменты', 'tools'),
       ('Разное', 'other');

INSERT INTO users(registration_date, email, name, password, contact_info)
    VALUES ('27.08.1996','oslan@mail.ru', 'Nekitos', '123456', 'Zvonite na mobilu vsegda otve4u'),
           ('16.03.1998','nepishi@gmail.com', 'Unknown', '123456', 'Menya tut net')
;

INSERT INTO lots(lot_title, lot_image, start_price, end_date, bet_step, user_id, category_id)
VALUES ('2014 Rossignol District Snowboard','img/lot-1.jpg', 10999, '2022-09-11', 600, 1, 1),
       ('DC Ply Mens 2016/2017 Snowboard', 'img/lot-2.jpg', 159999, '2022-07-11', 1000, 1, 1),
       ('Крепления Union Contact Pro 2015 года размер L/XL', 'img/lot-3.jpg', 8000, '2022-08-25', 300, 2, 2),
       ('Ботинки для сноуборда DC Mutiny Charocal', 'img/lot-4.jpg', 10999, '2022-07-17', 500, 2, 3),
       ('Куртка для сноуборда DC Mutiny Charocal', 'img/lot-5.jpg', 7500, '2023-01-11', 450, 2, 4),
       ('Маска Oakley Canopy', 'img/lot-6.jpg', 5400, '2022-10-12', 700, 2, 6)
       ;

/**
  получить все категории;
 */

SELECT *
FROM categories;

/**
  получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение, цену, название категории;
 */

SELECT lots.lot_title, lots.start_price, lots.lot_image, categories.category_name
FROM lots
JOIN categories ON lots.category_id = categories.id;

/**
  показать лот по его ID. Получите также название категории, к которой принадлежит лот;
 */

SELECT lots.lot_title, lots.start_price, lots.lot_image, categories.category_name
FROM lots JOIN categories ON lots.category_id = categories.id
WHERE lots.id = 5;

/**
  обновить название лота по его идентификатору;
 */

UPDATE lots
SET lot_title = 'Беспонтовая штука, хотел выкинуть но решил продать тут'
WHERE id = 5;

/**
  получить список ставок для лота по его идентификатору с сортировкой по дате.
 */

SELECT bets.bet_date, bets.bet_sum, bets.user_id, bets.lot_id
FROM bets
JOIN users ON bets.id = users.user_id
JOIN lots ON bets.lot_id = lots.id
WHERE lots.id = 5
ORDER BY bets.bet_date DESC;
