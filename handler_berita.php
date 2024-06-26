<?php
include_once "koneksidb.php";
session_start();
$user = $_SESSION['user'];

if (isset($_POST['add_berita'])) {
    $judul = $_POST['judul'];
    $deksripsi = $_POST['deksripsi'];
    $tanggal_pembuatan = $_POST['tanggal_pembuatan'];
    $user_id = $user['ID'];
    $gambar = $_FILES['gambar']['name'];
    $gambar_tmp_name = $_FILES['gambar']['tmp_name'];
    $gambar_folder = "gambardisini_img/" . basename($gambar);

    if (empty($judul) || empty($deksripsi) || empty($tanggal_pembuatan) || empty($gambar)) {
        echo "<script>alert('Anda belum menambahkan berita');</script>";
        return false;
    } else {
        $insert = "INSERT INTO berita(judul, deksripsi, gambar, tanggal_pembuatan, user_id) VALUES(?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert);
        $stmt->bind_param("ssssi", $judul, $deksripsi, $gambar, $tanggal_pembuatan, $user_id);

        if ($stmt->execute()) {
            if (move_uploaded_file($gambar_tmp_name, $gambar_folder)) {
                echo "<script>alert('Berita berhasil ditambahkan');</script>";
                header('Location: home.php');
                exit;
            } else {
                echo "<script>alert('Gagal mengupload gambar');</script>";
            }
        } else {
            echo "<script>alert('Gagal menambahkan berita');</script>";
        }
        $stmt->close();
    }
}

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $delete = $conn->prepare("DELETE FROM berita WHERE id = ?");
    $delete->bind_param("i", $id);

    if ($delete->execute()) {
        header('Location: profile.php');
        exit;
    } else {
        echo "Data berita gagal dihapus";
    }
    $delete->close();
}

$conn->close();
?>
