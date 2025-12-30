<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "disdukcapil";

$koneksi = mysqli_connect($hostname, $username, $password, $database);

if ($koneksi) {
    // echo "Koneksi Berhasil";
} 
?>