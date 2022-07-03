<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");

/**
 * Сделаем проверку поля даты окончания
 */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $required = ['lot_title', 'category', 'lot_description', 'lot_image', 'start_price', 'bet_step', 'end_date'];
    $errors = [];
    $rules = [
        'lot-date' => function($value) {
            return is_date_valid($value);
        }
    ];

    /**
     * Сделаем проверку полей на заполненность
     */
    $lot = filter_input_array(INPUT_POST, ['lot_title' => FILTER_DEFAULT, 'category' => FILTER_DEFAULT,
        'lot_description' => FILTER_DEFAULT, 'lot_image' => FILTER_DEFAULT, 'start_price' => FILTER_DEFAULT, 'bet_step' => FILTER_DEFAULT,
        'end_date' => FILTER_DEFAULT], true);


    foreach ($lot as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule($value);
        }

        if (in_array($key, $required) && empty($value)) {
            $errors[$key] = "Поле $key надо заполнить";
        }
    }

    $errors = array_filter($errors);

    if (!empty($_FILES['lot_img']['name'])) {
        $tmp_name = $_FILES['lot_img']['tmp_name'];
        $path = $_FILES['lot_img']['name'];
        $filename = uniqid() . '.img';

        $file_type = mime_content_type($tmp_name);
        if (($file_type !== "image/gif") && ($file_type !== "image/jpeg")) {
            $errors['file'] = 'Загрузите картинку в формате GIF';
        } else {
            move_uploaded_file($tmp_name, 'uploads/' . $filename);
            $lot['path'] = $filename;
        }

    } else {
        $errors['file'] = 'Вы не загрузили файл';
    }

    if (count($errors)) {
        $page_content = include_template('add.php', ['lot' => $lot, 'errors' => $errors, 'category' => $categories]);
    }
 else {
    $sql = 'INSERT INTO lots('add_date', 'user_id', 'lot_title', 'category', 'lot_description', 'lot_image', 'start_price', 'bet_step', 'end_date')
    VALUES (NOW(), 1, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = db_get_prepare_stmt($link, $sql, $lot);
    $res = mysqli_stmt_execute($stmt);

    if ($res) {
        $lot_id = mysqli_insert_id($link);

        header("Location: add.php?id=" . $lot_id);
    }
}
}
