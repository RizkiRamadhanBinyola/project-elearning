<?php
$dbHost="localhost";
$dbUser="root";
$dbPass="";
$dbName="project-elearning";

$connect=mysqli_connect ($dbHost, $dbUser, $dbPass, $dbName);
if (!$connect) die("koneksi gagal : ". mysqli_connect_error());
?>