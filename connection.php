<?php

$dsn = 'mysql:host=localhost;port=3306;dbname=';
$password = 'Int3rp0rt_123';
$login = 'interacesso';

$connec = new PDO($dsn, $login, $password);
