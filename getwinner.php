<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("models.php");
require_once("vendor/autoload.php");

$lots = get_lot_date_finish($link);
$win_bets = [];
foreach ($lots as $lot) {
    $id = (int)$lot["id"];
    $bet = get_last_bet($link, $id);
    if (!empty($bet)) {
        $id_lot = $lot["id"];
        $win_bets = $bet;
        $res = add_winner($link, $bet["user_id"], $id);
    }
    if (!empty($win_bets)) {
        $win_users = [];
        foreach ($win_bets as $bet) {
            $id = intval($bet["lot_id"]);
            $data = get_user_win($link, $id);
            $win_users[] = $data;
        }
        $recipients = [];
        foreach ($win_bets as $bet) {
            $id = intval($bet["user_id"]);
            $user_date = get_user_contacts($link, $id);
            $recipients[$user_date["email"]] = $user_date["user_name"];
        }

        $transport = new Swift_SmtpTransport("smtp.mailtrap.io", 2525);
            $transport -> setUsername("7037f3019c601e");
            $transport -> setPassword("f27bbed1e625b7");

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message('Ваша ставка победила'));
            $message -> setFrom(['keks@phpdemo.ru' => 'YetiCave']);
            $message -> setTo($recipients);

            $msg_content = include_template("email.php", [
            "win_users" => $win_users,
            ]);
            $message -> setBody($msg_content, text/html);

            $result = $mailer -> send($message);

            if ($result) {
                print("Рассылка успешно отправлена");
            } else {
                print("Не удалось отправить рассылку");
            }
    }
}




