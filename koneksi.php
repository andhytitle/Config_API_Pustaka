<?php
$db_Host = '127.0.0.1:3307';
$db_Uname = 'root';
$db_Pass = '';
$db_DbName = 'perpustakaan';

$connection = mysqli_connect($db_Host, $db_Uname, $db_Pass, $db_DbName);

if (!$connection) {
  die("Koneksi gagal!!" . mysqli_connect_error());
}