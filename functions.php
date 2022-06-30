<?php
/**
 * Форматирует цену лота - разделяет проблем тысячи
 * @param_integer $num Цена лота
 * @return_string Как цена будет отображена
 */
    function format_price($price) {
            $price=ceil($price);
            $price=number_format($price, "0", "", " ");
            return "$price Р";
        }
/**
 * Подсчитывает оставшееся для лота время аукциона
 * @param integer $date Дата окончания
 * @return array
 */
    function get_time_left($date) {
        date_default_timezone_set('Europe/Moscow');
        $final_date = date_create($date);
        $cur_date = date_create("now");
        $diff = date_diff($final_date, $cur_date);
        $format_diff = date_interval_format($diff, "%d %H %I");
        $arr = explode(" ", $format_diff);

        $hours = $arr[0] * 24 + $arr[1];
        $minutes = intval($arr[2]);
        $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
        $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);
        $res[] = $hours;
        $res[] = $minutes;

        return $res;
    }

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
 * Формирует SQL-запрос для показа лота по ID на странице lot.php
 * @param integer $lot_id айд лота
 * @return string SQL-запрос
 */
function get_query_lot($lot_id)
{
    return "SELECT lots.lot_title, lots.start_price, lots.lot_image, lots.end_date, categories.category_name FROM lots
    JOIN categories ON lots.category_id=categories.id
    WHERE lots.id = $lot_id";
}
