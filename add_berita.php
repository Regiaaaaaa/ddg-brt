<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita</title>
    <link rel="stylesheet" href="css/tambah.css">
</head>
<body>
<?php 
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>
<div class="container">

    <!-- Form untuk menambahkan berita -->
    <div class="admin-product-form-container centered">
        <form action="handler_berita.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="add_berita" value="1">
            <h3> Create News </h3>
            <input type="text" placeholder=" Title " name="judul" class="box">
            <textarea placeholder="Description" name="deksripsi" class="box" rows="4" cols="50"></textarea>
            <input type="date" placeholder=" Date " name="tanggal_pembuatan" class="box">
            <input type="file" accept="image/png, image/jpeg, image/jpg" name="gambar" class="box">
            <input type="submit" class="btn" name="add_product" value="Add News">
            <a href="profile.php" class="btn"> Go Back! </a>
        </form>
    </div>

</div>
</body>
</html>
