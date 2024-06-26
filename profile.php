<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Utama</title>
  <link rel="stylesheet" href="css/me.css">
</head>
<body>
<?php 
    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit;
    }

    $username = $_SESSION['user']['Username'];
    $initial = strtoupper($username[0]);
    $userId = $_SESSION['user']['ID'];
?>
  <header class="header">
    <div class="profile">
      <div class="profile-initial"><?php echo $initial; ?></div>
      <div class="profile-details">
        <span><?php echo htmlspecialchars($username); ?></span>
      </div>
      <a href='home.php' class="btn_back"> Go Home</a>
      <a href="add_berita.php" class="btn"> Create News </a>
      <a href="logout.php" class="btnn logout"> Logout </a>
    </div>
  </header>

  <main class="main">
    <section class="news">
      <h2> Your News  </h2>
      <div class="news-container">
        <?php
        include_once "koneksidb.php";
        // Mengambil berita yang hanya dibuat oleh pengguna yang sedang login
        $data_berita = $conn->query(
          "SELECT berita.*, users.username FROM `berita` 
           JOIN users ON users.id = berita.user_id 
           WHERE berita.user_id = $userId"
        );

        foreach ($data_berita as $item) {
          $imageUrl = "gambardisini_img/" . $item['gambar'];
        ?>

        <article class="news-item">
          <h3><?php echo htmlspecialchars($item['judul']); ?></h3>
          <span class="author">Penulis: <?php echo htmlspecialchars($item['username']); ?></span>
          <h3 class="date"><?php echo htmlspecialchars($item['tanggal_pembuatan']); ?></h3>
          <div class="news-item-inner">
            <img src="<?php echo htmlspecialchars($imageUrl); ?>" alt="<?php echo htmlspecialchars($item['judul']); ?>">
          </div>
          <div class="news-content">
            <a href="view.php?id=<?php echo $item['id'] ?>">Read more</a> 
            <?php 
              $paragraphs = explode("\n", $item['deksripsi']);
              foreach ($paragraphs as $paragraph) {
                  echo '<p>' . htmlspecialchars($paragraph) . '</p>';
              }
            ?>
          </div>
            <a class="btn" href="edit_berita.php?edit=<?php echo $item['id']; ?>">Edit</a>
            <a href="handler_berita.php?delete_id=<?php echo $item['id']; ?>" class="btnn">Delete</a>
        </article>
        <?php } ?>
      </div>
    </section>
  </main>


</body>
</html>
