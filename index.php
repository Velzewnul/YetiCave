<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("models.php");
require_once("getwinner.php");
require_once("vendor/autoload.php");

$categories = get_categories($link);

$sql = get_query_list_lots('2022-07-15');

$res = mysqli_query($link, $sql);
if ($res) {
    $goods = get_arrow($res);
} else {
    $error = mysqli_error($link);
}

$page_content = include_template("main.php", [
    "categories" => $categories,
    "goods" => $goods
]);
$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "categories" => $categories,
    "title" => "Главная",
    "is_auth" => $is_auth,
    "user_name" => $user_name
]);

print($layout_content);
