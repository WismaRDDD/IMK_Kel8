<?php
include 'config.php';
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

$sql = "SELECT nomor_kamar FROM sewa WHERE user_id='" . $_SESSION['userid'] . "'";
$result = $conn->query($sql);
$nomor_kamar = ($result->num_rows > 0) ? $result->fetch_assoc()['nomor_kamar'] : 'Belum ada kamar';

$conn->close();
?>

<!DOCTYPE html>
<html>
<body>

<h2>Home</h2>
<p>Selamat datang, <?php echo $username; ?></p>
<p>Nomor Kamar: <?php echo $nomor_kamar; ?></p>
<p><a href="detail_kamar.php">Detail Kamar</a></p>
<p><a href="https://example.com/qrcode">QR</a></p>
<p><a href="help.php">Help</a></p>

</body>
</html>
