<?php
// Auth.php

class Auth {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
}
?>
