<?php
session_start();
include 'koneksidb.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    if (isset($_POST['update_berita'])) {
        $judul = $_POST['judul'];
        $deksripsi = $_POST['deksripsi'];
        $tanggal_pembuatan = $_POST['tanggal_pembuatan'];
        $user_id = $_SESSION['user']['ID'];
        $gambar = $_FILES['gambar']['name'];
        $gambar_tmp_name = $_FILES['gambar']['tmp_name'];
        $gambar_folder = 'gambardisini_img/' . basename($gambar);

        if (!empty($gambar)) {
            $update_data = "UPDATE berita SET judul=?, deksripsi=?, tanggal_pembuatan=?, user_id=?, gambar=? WHERE id=?";
            $stmt = $conn->prepare($update_data);
            $stmt->bind_param("sssssi", $judul, $deksripsi, $tanggal_pembuatan, $user_id, $gambar, $id);
            
            if ($stmt->execute()) {
                if (move_uploaded_file($gambar_tmp_name, $gambar_folder)) {
                    header('Location: profile.php');
                    exit;
                } else {
                    $message[] = 'Failed to upload image!';
                }
            } else {
                $message[] = 'Update failed!';
            }
            $stmt->close();
        } else {
            $update_data = "UPDATE berita SET judul=?, deksripsi=?, tanggal_pembuatan=?, user_id=? WHERE id=?";
            $stmt = $conn->prepare($update_data);
            $stmt->bind_param("ssssi", $judul, $deksripsi, $tanggal_pembuatan, $user_id, $id);
            
            if ($stmt->execute()) {
                header('Location: profile.php');
                exit;
            } else {
                $message[] = 'Update failed!';
            }
            $stmt->close();
        }
    }

    $result = $conn->prepare("SELECT * FROM berita WHERE id=?");
    $result->bind_param("i", $id);
    $result->execute();
    $item = $result->get_result()->fetch_assoc();
    $result->close();
} else {
    header('Location: profile.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Berita</title>
    <link rel="stylesheet" href="css/edit.css">
</head>
<body>
    <?php 
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit;
    }
    ?>

    <div class="container">
        <div class="admin-product-form-container">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="update_berita" value="1">
                <h3> News Edit </h3>
                <input type="text" placeholder="Title" value="<?php echo htmlspecialchars($item['judul']); ?>" name="judul" class="box">
                <textarea placeholder="Description" name="deksripsi" class="box" rows="4" cols="50"><?php echo htmlspecialchars($item['deksripsi']); ?></textarea>
                <input type="date" placeholder="Date" value="<?php echo htmlspecialchars($item['tanggal_pembuatan']); ?>" name="tanggal_pembuatan" class="box">
                <input type="file" accept="image/png, image/jpeg, image/jpg" name="gambar" class="box">
                <input type="submit" value=" Edit " name="update_berita" class="btn">
                <a href="profile.php" class="btn">Back!</a>
            </form>
        </div>
    </div>
</body>
</html>
