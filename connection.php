<?php

$dsn = 'mysql:host=localhost;port=3306;dbname=';
$password = '12345678';
$login = 'test';

$connec = new PDO($dsn, $login, $password);
