<?php

class TokenValidator {

    public static function validate($callback) {

        session_start();

        $token = htmlspecialchars(trim($_POST['token']));

        if (!is_string($token)|| trim($token) === '') {
            header($_SERVER['SERVER_PROTOCOL']. ' 400 Bad Request');
            exit;
        }
        if (!isset($_SESSION['token'])) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden' );
            exit;
        }
        if (!hash_equals($_SESSION['token'], $token)) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
            exit;
        }

        return true;
    }
}
