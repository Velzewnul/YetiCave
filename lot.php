<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("models.php");

$categories = get_categories($link);

$page_content = include_template('signup-main.php', [
    'categories' => $categories
]);

$id=filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if ($id) {
    $sql = get_query_lot($id);
} else {
    http_response_code(404);
    die();
}

$res = mysqli_query($link, $sql);
if ($res) {
    $lot = get_arrow($res);
} else {
    $error = mysqli_error($link);
}

if (!$lot) {
    print($layout_content);
    die();
}

$page_content = include_template("lot-main.php", [
    "categories" => $categories,
    "lot" => $lot
]);
$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "categories" => $categories,
    "title" => $lot['lot_title'],
    "is_auth" => $is_auth,
    "user_name" => $user_name
]);

print($layout_content);
