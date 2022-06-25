<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");

// $page_content = include_template("main.php", [
//    "categories" => $categories,
//    "goods" => $goods
//]);
//$layout_content = include_template("layout.php", [
//    "content" => $page_content,
//    "categories" => $categories,
//    "title" => "YetiCave"
//]);

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
$sql = get_query_list_lots('2022-07-15');

$res = mysqli_query($link, $sql);
    if ($res) {
        $goods = mysqli_fetch_all($res, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($link);
    }

$page_content = include_template("main.php",[
    "categories" => $categories,
    "goods" => $goods
]);
$layout_content = include_template("layout.php",[
    "content" => $page_content,
    "categories" => $categories,
    "title" => "Главная",
    "is_auth" => $is_auth,
    "user_name" => $user_name
]);

print($layout_content);
