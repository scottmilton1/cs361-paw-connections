<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

	$host = 'localhost';
	$user = 'ericiann_pawcon';
	$pwd = 'pawconnections';
	$db = 'ericiann_pawconnections';

//new database
$mysqli = new mysqli($host, $user, $pwd, $db);
if(!$mysqli || $mysqli->connect_errno){
  echo "Connection Error" . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
?>