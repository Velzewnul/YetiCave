<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("models.php");

$categories = get_categories($link);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;
    $req_fields = ['email', 'password'];
    $errors = [];

    $user = filter_input_array(INPUT_POST,
        [
            "email" => FILTER_DEFAULT,
            "password" => FILTER_DEFAULT,
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

    $email = mysqli_real_escape_string($link, $form['email']);
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($link, $sql);

    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

    if (!count($errors) and $user) {
        if (password_verify($form['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        } else {
            $errors['password'] = 'Неверный пароль';
        }
    } else {
        $errors['email'] = 'Такой пользователь не найден';
    }

    if (count($errors)) {
        $page_content = include_template('login.php', ['form' => $form, 'errors' => $errors]);
    } else {
        header("Location: /index.php");
        exit();
    }
} else {
    $page_content = include_template('login.php', []);

    if (isset($_SESSION['user'])) {
        header("Location: /index.php");
        exit();
    }
}

$page_content = include_template('login-main.php', [
    'categories' => $categories,
    'email' => $email,
    'password' => $password
]);

$layout_content = include_template('layout.php', [
    'content'    => $page_content,
    'categories' => [],
    'title'      => 'YetiCave авторизация'
]);

print($layout_content);
