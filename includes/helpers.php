<?php
class CSRF {
    private $token_key = 'csrf_token_hash';

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function generate() {
        if (empty($_SESSION[$this->token_key])) {
            $_SESSION[$this->token_key] = bin2hex(random_bytes(32));
        }
        return $_SESSION[$this->token_key];
    }

    public function input() {
        $token = $this->generate();
        return '<input type="hidden" name="' . $this->token_key . '" value="' . $token . '">';
    }

    public function verify($raw_token) {
        if(!isset($_SESSION[$this->token_key])) return false;
        return hash_equals($_SESSION[$this->token_key], $raw_token);
    }

    public function refresh() {
        $_SESSION[$this->token_key] = bin2hex(random_bytes(32));
    }
}
?>

