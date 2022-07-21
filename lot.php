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

$history = get_bets_history($link, $id);
$current_price = max($lot["start_price"], $history[0]["bet_sum"]);
$min_bet = $current_price + $lot['bet_step'];

$page_content = include_template("lot-main.php", [
    "categories" => $categories,
    "lot" => $lot,
    "is_auth" => $is_auth,
    "user_name" => $user_name,
    "current_price" => $current_price,
    "min_bet" => $min_bet,
    "id" => $id,
    "history" => $history
]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bet = filter_input(INPUT_POST, 'cost', FILTER_VALIDATE_INT);

    if ($bet < $min_bet) {
        $error = "Ставка не должна быть меньше $min_bet";
    }
    if (empty($bet)) {
        $error = "Ставка должна быть целым числом больше нуля";
    }

    if ($error) {
        $page_content = include_template("lot-main.php",[
            "categories" => $categories,
            "lot" => $lot,
            "is_auth" => $is_auth,
            "user_name" => $user_name,
            "current_price" => $current_price,
            "min_bet" => $min_bet,
            "id" => $id,
            "history" => $history,
            "error" => $error
        ]);
    } else {
        $res = add_bet_database($link, $bet, $_SESSION["id"], $id);
        header("Location: /lot.php?id= . $id");
    }
}

$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "categories" => $categories,
    "title" => $lot['lot_title'],
    "is_auth" => $is_auth,
    "user_name" => $user_name
]);

print($layout_content);
