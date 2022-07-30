<?php
/**
 * Формирует SQL-запрос для получения списка новых лотов от определенной даты, с сортировкой
 * @param string $date Дата в виде строки, в формате 'YYYY-MM-DD'
 * @return string SQL-запрос
 */
function get_query_list_lots($date)
{
    return "SELECT lots.id, lots.lot_title, lots.start_price, lots.lot_image, lots.end_date, categories.category_name FROM lots
    JOIN categories ON lots.category_id=categories.id
    WHERE end_date > $date ORDER BY end_date DESC";
}

/**
 * Формирует SQL-запрос для показа лота на странице lot.php
 * @param integer $id_lot id лота
 * @return string SQL-запрос
 */
function get_query_lot($id_lot)
{
    return "SELECT lots.lot_title, lots.start_price, lots.lot_image, lots.end_date, categories.category_name FROM lots
    JOIN categories ON lots.category_id=categories.id
    WHERE lots.id = $id_lot";
}

/**
 * Формирует SQL-запрос для создания нового лота
 * @param integer $user_id id пользователя
 * @return string SQL-запрос
 */
function get_query_create_lot($user_id)
{
    return "INSERT INTO lots (lot_title, category_id, lot_description, start_price, bet_step, end_date, lot_image, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, $user_id);";
}

/**
 * Возвращает массив категорий
 * @param $con Подключение к MySQL
 * @return [Array | String] $categuries Ассоциативный массив с категориями лотов из базы данных
 * или описание последней ошибки подключения
 */
function get_categories($link)
{
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
function get_users_data($link)
{
    if (!$link) {
        $error = mysqli_connect_error();
        return $error;
    } else {
        $sql = "SELECT email, name FROM users;";
        $result = mysqli_query($link, $sql);
        if ($result) {
            $users_data = get_arrow($result);
            return $users_data;
        }
        $error = mysqli_error($link);
        return $error;
    }
}

/**
 * Возвращает все лоты без победителей, дата истечения которых меньше или равна текущей дате.
 * @param $link Подключение к MySQL
 * @return [Array | String] $users_data Двумерный массив с именами и емейлами пользователей
 * или описание последней ошибки подключения
 */
function get_lot_date_finish($link)
{
    if (!$link) {
        $error = mysqli_connect_error();
        return $error;
    } else {
        $sql = "SELECT * FROM lots WHERE winner_id IS null && end_date <= now();";
        $result = mysqli_query($link, $sql);
        if ($result) {
            $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $lots;
        }
        $error = mysqli_error($link);
        return $error;
    }
}

/**
 * Возвращает последнюю ставку на лот
 * @param $link Подключение к MySQL
 * @param $id int id лота
 * @return [Array | String] $users_data Двумерный массив с именами и емейлами пользователей
 * или описание последней ошибки подключения
 */
function get_last_bet($link, $id)
{
    if (!$link) {
        $error = mysqli_connect_error();
        return $error;
    } else {
        $sql = "SELECT * FROM bets "
            . "WHERE lot_id = $id"
            . "ORDER BY bet_date DESC LIMIT 1";
        $result = mysqli_query($link, $sql);
        if ($result) {
            $bet = get_arrow($result);
            return $bet;
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
function get_query_create_user()
{
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
function get_login($link, $email)
{
    if (!$link) {
        $error = mysqli_connect_error();
        return $error;
    } else {
        $sql = "SELECT id, email, name, password FROM users WHERE email = '$email'";
        $result = mysqli_query($link, $sql);
        if ($result) {
            $users_data = get_arrow($result);
            return $users_data;
        }
        $error = mysqli_error($link);
        return $error;
    }
}

/**
 * Возвращает массив лотов соответствующих поисковым словам
 * @param $link mysqli Ресурс соединения
 * @param string $words ключевые слова введенные ползователем в форму поиска
 * @return [Array | String] $goods Двумерный массив лотов, в названии или описании которых есть такие слова
 * или описание последней ошибки подключения
 */
function get_found_lots($link, $words, $limit, $offset)
{
    $sql = "SELECT lots.id, lots.lot_title, lots.start_price, lots.lot_image, lots.end_date, categories.category_name FROM lots
    JOIN categories ON lots.category_id=categories.id
    WHERE MATCH(lot_title, lot_description) AGAINST(?) ORDER BY add_date DESC LIMIT $limit OFFSET $offset;";

    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, 's', $words);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        $goods = get_arrow($res);
        return $goods;
    }
    $error = mysqli_error($link);
    return $error;
}

/**
 * Возвращает количество лотов соответствующих поисковым словам
 * @param $link mysqli Ресурс соединения
 * @param string $words ключевые слова введенные ползователем в форму поиска
 * @return [int | String] $count Количество лотов, в названии или описании которых есть такие слова
 * или описание последней ошибки подключения
 */
function get_count_lots($link, $words)
{
    $sql = "SELECT COUNT(*) as cnt FROM lots
    WHERE MATCH(lot_title, lot_description) AGAINST(?);";

    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, 's', $words);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        $count = mysqli_fetch_assoc($res)["cnt"];
        return $count;
    }
    $error = mysqli_error($link);
    return $error;
}

/**
 * Записывает в БД сделанную ставку
 * @param $link mysqli Ресурс соединения
 * @param int $sum Сумма ставки
 * @param int $user_id ID пользователя
 * @param int $lot_id ID лота
 * @return bool $res Возвращает true в случае успешной записи
 */
function add_bet_database($link, $sum, $user_id, $lot_id)
{
    $sql = "INSERT INTO bets (bet_date, bet_sum, user_id, lot_id) VALUE (NOW(), ?, $user_id, $lot_id);";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $sum);
    $res = mysqli_stmt_execute($stmt);
    if ($res) {
        return $res;
    }
    $error = mysqli_error($link);
    return $error;
}

/**
 * Записывает в БД победителя аукциона за лот.
 * @param $link mysqli Ресурс соединения
 * @param int $sum Сумма ставки
 * @param int $user_id ID пользователя
 * @param int $lot_id ID лота
 * @return bool $res Возвращает true в случае успешной записи
 */
function add_winner($link, $winner_id, $lot_id)
{
    if (!link) {
        $error = mysqli_connect_error();
        return $error;
    } else {
        $sql = UPDATE lots SET winner_id = $winner_id where id = $lot_id;
        $result = mysqli_query($link, $sql);
        if ($result) {
            return $result;
        } else {
            $error = mysqli_connect_error();
            return $error;
        }
    }
}

/**
 * Возвращает массив из десяти последних ставок на этот лот
 * @param $link Подключение к MySQL
 * @param int $id_lot Id лота
 * @return [Array | String] $list_bets Ассоциативный массив со списком ставок на этот лот из базы данных
 * или описание последней ошибки подключения
 */
function get_bets_history($link, $id_lot)
{
    if (!$link) {
        $error = mysqli_connect_error();
        return $error;
    } else {
        $sql = "SELECT users.name, bets.bet_sum, DATE_FORMAT(bet_date, '%d.%m.%y %H:%i') AS bet_date
        FROM bets
        JOIN lots ON bets.lot_id=lots.id
        JOIN users ON bets.user_id=users.id
        WHERE lots.id=$id_lot
        ORDER BY bets.bet_date DESC LIMIT 10;";
        $result = mysqli_query($link, $sql);
        if ($result) {
            $list_bets = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $list_bets;
        }
        $error = mysqli_error($link);
        return $error;
    }
}

/**
 * Возвращает массив ставок пользователя
 * @param $link Подключение к MySQL
 * @param int $id Id пользователя
 * @return [Array | String] $list_bets Ассоциативный массив ставок
 *  пользователя из базы данных
 * или описание последней ошибки подключения
 */
function get_bets($link, $id)
{
    if (!$link) {
        $error = mysqli_connect_error();
        return $error;
    } else {
        $sql = "SELECT DATE_FORMAT(bets.bet_date, '%d.%m.%y %H:%i') AS date_bet, bets.bet_sum, lots.lot_title, lots.lot_description, lots.lot_image, lots.end_date, lots.id, categories.category_name
        FROM bets
        JOIN lots ON bets.lot_id=lots.id
        JOIN users ON bets.user_id=users.id
        JOIN categories ON lots.category_id=categories.id
        WHERE bets.user_id=$id
        ORDER BY bets.bet_date DESC;";
        $result = mysqli_query($link, $sql);
        if ($result) {
            $list_bets = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $list_bets;
        }
        $error = mysqli_error($link);
        return $error;
    }
}

/**
 * Записывает в БД данные пользователя из формы
 * @param $link mysqli Ресурс соединения
 * @param array $data Данные пользователя, полученные из формы
 * @return bool $res Возвращает true в случае успешного выполнения
 */
function add_user_database($link, $data = [])
{
    $sql = "INSERT INTO users (registration_date, email, password, name, contact_info) VALUES (NOW(), ?, ?, ?, ?);";
    $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);

    $stmt = db_get_prepare_stmt_version($link, $sql, $data);
    $res = mysqli_stmt_execute($stmt);
    return $res;
}


/**
 * Возвращает email, телефон и имя пользователя по id
 * @param $link Подключение к MySQL
 * @param $id ID пользователя
 * @return [Array | String] $user_date массив
 * или описание последней ошибки подключения
 */
function get_user_contacts ($link, $id) {
    if (!$link) {
        $error = mysqli_connect_error();
        return $error;
    } else {
        $sql = "SELECT users.name, users.email, users.contact_info FROM users
        WHERE id=$id;";
        $result = mysqli_query($link, $sql);
        if ($result) {
            $user_date = get_arrow($result);
            return $user_date;
        }
        $error = mysqli_error($link);
        return $error;
    }
}
