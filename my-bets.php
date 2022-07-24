<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("models.php");

$categories = get_categories($link);

$page_content = include_template('my-bets-main.php', [
    'categories' => $categories
]);

if ($is_auth) {
    $bets = get_bets($link, $_SESSION["id"]);
}

$page_content = include_template('my-bets-main.php', [
    "categories" => $categories,
    "bets" => $bets,
    "is_auth" => $is_auth,
]);

$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "categories" => $categories,
    "title" => $lot["title"],
    "is_auth" => $is_auth,
    "user_name" => $user_name
]);

print($layout_content);
