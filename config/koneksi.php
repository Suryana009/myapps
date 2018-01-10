<?php
$username="root";
$password="";
$host="localhost";
$database="akademik";
mysql_connect($host,$username,$password) or die ("koneksi server gagal");
mysql_select_db($database) or die ("koneksi database gagal");

$denda=1000;
?>