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
?>
