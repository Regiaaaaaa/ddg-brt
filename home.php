<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Utama</title>
  <link rel="stylesheet" href="css/home.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
?>
  <header class="header header-background">
    <h1> Esport News </h1> 
    <div class="profile">
      <a href="profile.php" style="text-decoration: none;">
        <div class="profile-initial"><i class='bx bx-user'></i></div>
        <!-- <div class="profile-details">
          <span><?php echo htmlspecialchars($username); ?></span>
        </div> -->
      </a>
    </div>
  </header>
  <br>
  <form method="GET" action="home.php" style="text-align: center;">
    <input type="text" name="cari" value="<?php if(isset($_GET['cari'])){ echo $_GET['cari']; } ?>" placeholder=" Write Your News";>
    <button type="submit"> Search </button>
  </form>

  <main class="main">
    <section class="news">
      <h2> Hot News </h2>
      <div class="news-container">
        <?php
        include_once "koneksidb.php";

        if(isset($_GET['cari'])){
          $pencarian = $conn->real_escape_string($_GET['cari']);
          $query = "SELECT berita.*, users.Username FROM berita JOIN users ON users.ID = berita.user_id WHERE judul LIKE '%$pencarian%' OR Username LIKE '%$pencarian%'";
        } else {
          $query = "SELECT berita.*, users.Username FROM berita JOIN users ON users.ID = berita.user_id";
        }

        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($item = $result->fetch_assoc()) {
                $imageUrl = "gambardisini_img/" . $item['gambar'];
        ?>

        <article class="news-item">
          <h3><?php echo htmlspecialchars($item['judul']); ?></h3>
          <span class="author">Penulis: <?php echo htmlspecialchars($item['Username']); ?></span>
          <h3 class="date"><?php echo htmlspecialchars($item['tanggal_pembuatan']); ?></h3>
          <div class="news-item-inner">
            <img src="<?php echo htmlspecialchars($imageUrl); ?>" alt="<?php echo htmlspecialchars($item['judul']); ?>">
          </div>
          <div class="news-content">
            <?php 
              $paragraphs = explode("\n", $item['deksripsi']);
              foreach ($paragraphs as $paragraph) {
                  echo '<p>' . htmlspecialchars($paragraph) . '</p>';
              }
            ?>
            
          </div>
          <a href="view.php?id=<?php echo $item['id'] ?>">Read more</a>
        </article>
        <?php 
            }
        } else {
            echo "<p> Hayo Ga Ada Mau Nyari Apa??? </p>";
        }

        $conn->close();
        ?>
      </div>
    </section>
  </main>
  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</body>
</html>
