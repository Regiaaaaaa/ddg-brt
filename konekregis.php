<?php
include_once 'koneksidb.php';

$usr = $_POST['username'];
$pw = $_POST['password'];
$email = $_POST['email'];

$datas = $conn->query("INSERT INTO users VALUES ('','$usr','$pw','$email')");

if(isset($_POST['register']) > 0){
    header("Location: login.php");
}



?>