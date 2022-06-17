INSERT INTO YetiCave.categories(category_name, symbolic_name)
VALUES ('Доски и лыжи', 'boards'),
       ('Крепления', 'attachment'),
       ('Ботинки', 'boots'),
       ('Одежда', 'clothing'),
       ('Инструменты', 'tools'),
       ('Разное', 'other');

INSERT INTO YetiCave.users(registration_date, email, name, password, contact_info)
    VALUES ('27.08.1996','oslan@mail.ru', 'Nekitos', '123456', 'Zvonite na mobilu vsegda otve4u'),
           ('16.03.1998','nepishi@gmail.com', 'Unknown', '123456', 'Menya tut net')
;

INSERT INTO YetiCave.lots(lot_title, lot_image, start_price, end_date, bet_step, user_id, category_id)
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
FROM YetiCave.categories;

/**
  получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение, цену, название категории;
 */



/**
  показать лот по его ID. Получите также название категории, к которой принадлежит лот;
 */



/**
  обновить название лота по его идентификатору;
 */



/**
  получить список ставок для лота по его идентификатору с сортировкой по дате.
 */
