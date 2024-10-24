<?php
// helpers.php

function redirect($url) {
    header("Location: $url");
    exit();
}

function flashMessage($message) {
    $_SESSION['flash_message'] = $message;
}
?>