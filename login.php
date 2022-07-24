<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("models.php");

$categories = get_categories($link);

$page_content = include_template('login-main.php', [
    'categories' => $categories
]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $req_fields = ['email', 'password'];
    $errors = [];

    $rules = [
        "email" => function ($value) {
            return validate_email($value);
        },
        "password" => function ($value) {
            return validate_length($value, 6, 8);
        }
    ];

    $user = filter_input_array(INPUT_POST,
        [
            "email" => FILTER_DEFAULT,
            "password" => FILTER_DEFAULT
        ], true);

    foreach ($user as $field => $value) {
        if (isset($rules[$field])) {
            $rule = $rules[$field];
            $errors[$field] = $rule($value);
        }
        if (in_array($field, $req_fields) && empty($value)) {
            $errors[$field] = "Поле $field нужно заполнить";
        }
    }

    $errors = array_filter($errors);

    if (count($errors)) {
        $page_content = include_template('login-main.php', [
            'categories' => $categories,
            'errors' => $errors,
            'user' => $user
        ]);
    } else {
        $users_data = get_login($link, $user['email']);
        if ($users_data) {
            if (password_verify(($user['password']), $users_data['password'])) {
                $issession = session_start();
                $_SESSION['name'] = $users_data['name'];
                $_SESSION['id'] = $users_data['id'];

                header("Location: /index.php");
            } else {
                $errors['password'] = "Вы ввели неверный пароль";
            }
        } else {
            $errors['email'] = "Пользователь с таким email не зарегистрирован";
        }
        if (count($errors)) {
            $page_content = include_template("main-login.php", [
                "categories" => $categories,
                "user" => $user,
                "errors" => $errors
            ]);
        }
    }
}


$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'YetiCave авторизация',
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);

print($layout_content);
