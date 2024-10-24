<?php
// ResetPassword_process.php

require_once '../controllers/UserController.php';
session_start();

$userController = new UserController();
$userController->resetPassword();
?>