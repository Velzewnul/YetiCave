<?php
require_once('autoload.php');
session_start();
$is_auth = isset($_SESSION["name"]);
if ($is_auth) {
    $user_name = $_SESSION["name"];
}
