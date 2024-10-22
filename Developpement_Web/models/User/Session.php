<?php
// Session.php

class Session {
    public static function isLoggedInUser() {
        return isset($_SESSION['user_id']);
    }

    public static function logoutUser() {
        session_start();
        session_destroy();
    }
}
?>