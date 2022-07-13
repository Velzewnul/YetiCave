<?php
/**
 * Формирует SQL-запрос для получения списка новых лотов от определенной даты, с сортировкой
 * @param string $date Дата в виде строки, в формате 'YYYY-MM-DD'
 * @return string SQL-запрос
 */
function get_query_list_lots ($date) {
    return "SELECT lots.id, lots.lot_title, lots.start_price, lots.lot_image, lots.end_date, categories.category_name FROM lots
    JOIN categories ON lots.category_id=categories.id
    WHERE end_date > $date ORDER BY end_date DESC";
}

/**
 * Формирует SQL-запрос для показа лота на странице lot.php
 * @param integer $id_lot id лота
 * @return string SQL-запрос
 */
function get_query_lot ($id_lot) {
    return "SELECT lots.lot_title, lots.start_price, lots.lot_image, lots.end_date, categories.category_name FROM lots
    JOIN categories ON lots.category_id=categories.id
    WHERE lots.id = $lot_id";
}
/**
 * Формирует SQL-запрос для создания нового лота
 * @param integer $user_id id пользователя
 * @return string SQL-запрос
 */
function get_query_create_lot ($user_id) {
    return "INSERT INTO lots (lot_title, category_id, lot_description, start_price, bet_step, end_date, lot_image, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, $user_id);";
}
/**
 * Возвращает массив категорий
 * @param $con Подключение к MySQL
 * @return [Array | String] $categuries Ассоциативный массив с категориями лотов из базы данных
 * или описание последней ошибки подключения
 */
function get_categories ($link) {
    if (!$link) {
        $error = mysqli_connect_error();
        return $error;
    } else {
        $sql = "SELECT id, category_name, symbolic_name FROM categories;";
        $result = mysqli_query($link, $sql);
        if ($result) {
            $categories = get_arrow($result);
            return $categories;
        } else {
            $error = mysqli_error($link);
            return $error;
        }
    }
}
//New
/**
 * Возвращает массив данных пользователей: адресс электронной почты и имя
 * @param $link Подключение к MySQL
 * @return [Array | String] $users_data Двумерный массив с именами и емейлами пользователей
 * или описание последней ошибки подключения
 */
function get_users_data($link) {
    if (!$link) {
        $error = mysqli_connect_error();
        return $error;
    } else {
        $sql = "SELECT email, name FROM users;";
        $result = mysqli_query($link, $sql);
        if ($result) {
            $users_data= get_arrow($result);
            return $users_data;
        }
        $error = mysqli_error($link);
        return $error;
    }
}

/**
 * Формирует SQL-запрос для регистрации нового пользователя
 * @param integer $user_id id пользователя
 * @return string SQL-запрос
 */
function get_query_create_user() {
    return "INSERT INTO users (registration_date, email, password, name, contact_info) VALUES (NOW(), ?, ?, ?, ?);";
}


//login
/**
 * Возвращает массив данных пользователя: id адресс электронной почты имя и хеш пароля
 * @param $con Подключение к MySQL
 * @param $email введенный адрес электронной почты
 * @return [Array | String] $users_data Массив с данными пользователя: id адресс электронной почты имя и хеш пароля
 * или описание последней ошибки подключения
 */
function get_login($con, $email) {
    if (!$con) {
        $error = mysqli_connect_error();
        return $error;
    } else {
        $sql = "SELECT id, email, user_name, user_password FROM users WHERE email = '$email'";
        $result = mysqli_query($con, $sql);
        if ($result) {
            $users_data= get_arrow($result);
            return $users_data;
        }
        $error = mysqli_error($con);
        return $error;
    }
}

