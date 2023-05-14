<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/authorise.php'); 

$servername = "localhost";
$username = "admin";
$password = "*************************************";
$dbname = "CITC";
$conn = mysqli_connect($servername, $username, $password, $dbname);
?>