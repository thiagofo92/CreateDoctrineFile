<?php

require_once 'connection.php';
require_once 'GenerateDoctrine.php';
require_once 'CreateFileDoctrine.php';

$table = 'area_comum';
// $query = "SHOW COLUMNS FROM $table";
$query = "SHOW TABLES";

$state = $connec->prepare($query);

$state->execute();

$result = $state->fetchAll(PDO::FETCH_CLASS);

// $gm = new GenerateDoctrine();
$gm = new CreateFileDoctrine();

// $gm->Generate($table, $result);
foreach ($result as $key => $value) 
{
    $query = "SHOW COLUMNS FROM $value->Tables_in_interacesso";
    $state = $connec->prepare($query);

    $state->execute();

    $colum = $state->fetchAll(PDO::FETCH_CLASS);

    $gm->Create($value->Tables_in_interacesso, $colum);

}





