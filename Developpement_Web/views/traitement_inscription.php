<?php
// traitement_inscription.php

require_once '../controllers/UserController.php';
session_start();

$userController = new UserController();
$userController->inscription();
?>