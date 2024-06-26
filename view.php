<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
<?php 
include_once "koneksidb.php";
    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit;
    }

    $username = $_SESSION['user']['Username'];
    $initial = strtoupper($username[0]);

    $id = $_GET['id'];
    $item = $conn->query("SELECT * FROM berita WHERE id = $id ")->fetch_assoc();
?>
<header class="header header-background">
    <h1 class="haha"> Esport News </h1> 
    <div class="profile">
      <a href="profile.php" style="text-decoration: none;">
        <div class="profile-initial"><?php echo $initial; ?></div>
        <!-- <div class="profile-details">
          <span><?php echo htmlspecialchars($username); ?></span>
        </div> -->
      </a>
    </div>
  </header>

  
  <h1 class="jdl"><?= $item['judul'] ?></h1>
  <p class="datev"><?= $item['tanggal_pembuatan'] ?></p>
  <img src="./gambardisini_img/<?php echo $item['gambar'] ?>" alt="" class="imgv"  >
  <p class="dks" ><?= $item['deksripsi'] ?></p>
  <a href="home.php"> Read Other News </a>

</body>
</html>