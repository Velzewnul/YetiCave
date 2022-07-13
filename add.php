<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("models.php");

$categories = get_categories($link);
$categories_id = array_column($categories, "id");

$page_content = include_template("add-lot.php", [
    'categories' => $categories
]);

/**
 * Сделаем проверку поля даты окончания
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required = ['lot_title', 'category', 'lot_description', 'lot_image', 'start_price', 'bet_step', 'end_date'];
    $errors = [];

    $rules = [
        'end_date' => function($value) {
            return validate_date($value);
        },
        'category' => function($value) use ($categories_id) {
            return validate_category($value, $categories_id);
        },
        'start_price' => function($value) {
            return validate_number($value);
        },
        'bet_step' => function($value) {
            return validate_number($value);
        }
    ];

    /**
     * Сделаем проверку полей на заполненность
     */
    $lot = filter_input_array(INPUT_POST, [
        'lot_title' => FILTER_DEFAULT,
        'category' => FILTER_DEFAULT,
        'lot_description' => FILTER_DEFAULT,
        'lot_image' => FILTER_DEFAULT,
        'start_price' => FILTER_DEFAULT,
        'bet_step' => FILTER_DEFAULT,
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

    if (!empty($_FILES['lot_image']['name'])) {
        $tmp_name = $_FILES['lot_image']['tmp_name'];
        $path = $_FILES['lot_image']['name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type === "image/png") {
            $ext=".png";
        } else if ($file_type !== "image/jpeg") {
            $ext=".jpg";
        }
        if ($ext) {
            $filename = uniqid() . $ext;
            $lot["path"] = 'uploads/' . $filename;
            move_uploaded_file($_FILES['lot_image']['tmp_name'], 'uploads/' . $filename);
        } else {
            $errors['lot_image'] = 'Допустимые форматы файлов: jpg, jpeg, png';
        }
    } else {
        $errors['lot_image'] = 'Вы не загрузили пикчу';
        }


    if (count($errors)) {
        $page_content = include_template('add-lot.php', [
            'lot' => $lot,
            'errors' => $errors,
            'categories' => $categories]);
    } else {
    $sql = 'INSERT INTO lots(add_date, user_id, lot_title, category_id, lot_description, lot_image, start_price, bet_step, end_date)
    VALUES (NOW(), 1, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = db_get_prepare_stmt($link, $sql, $lot);
    $res = mysqli_stmt_execute($stmt);

    if ($res) {
        $lot_id = mysqli_insert_id($link);
        header("Location: /lot.php?id=" . $lot_id);
    } else {
    $error = mysqli_error($link);
    }
    }
}


$page_head = include_template("head.php", [
    'title' => "Добавить лот"
]);
$layout_content = include_template("layout.php", [
    'content' => $page_content,
    'categories' => $categories,
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);

print($page_head);
print($layout_content);
