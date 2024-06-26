<?php


include_once 'koneksidb.php';

$Username = $_POST['username'];
$Password = $_POST['password'];

$datas = $conn->query(
  "SELECT * FROM users where
  Username = '$Username'
  AND Password = '$Password'"
);
$check_login = $datas->fetch_array();
if ($check_login[0])  {
  session_start();
  $_SESSION['user'] = $check_login;
  header('Location: home.php');
  exit;
} else {
    header('Location: login.php');
}
?>
