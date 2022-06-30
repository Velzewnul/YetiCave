<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");

if (!$link) {
    $error = mysqli_connect_error();
} else {
    $sql = "SELECT category_name, symbolic_name FROM categories";
    $result = mysqli_query($link, $sql);
    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($link);
    }
}

$id=filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if ($id) {
    $sql = get_query_lot($id);
} else {
    http_response_code(404);
    die();
}

$res = mysqli_query($link, $sql);
if ($res) {
    $lot = mysqli_fetch_assoc($res);
} else {
    $error = mysqli_error($link);
}

if (!$lot) {
    http_response_code(404);
    die();
}

$page_content = include_template("lot-main.php", [
    "categories" => $categories,
    "lot" => $lot
]);
$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "categories" => $categories,
    "title" => "Главная",
    "is_auth" => $is_auth,
    "user_name" => $user_name
]);

print($layout_content);
