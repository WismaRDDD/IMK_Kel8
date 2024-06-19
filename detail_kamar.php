<?php
include 'config.php';
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT * FROM kost JOIN sewa ON kost.id = sewa.kost_id WHERE sewa.user_id='" . $_SESSION['userid'] . "'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Kamar tidak ditemukan.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<body>

<h2>Detail Kamar</h2>
<p>Nomor Kamar: <?php echo $row['nomor_kamar']; ?></p>
<p>Harga Sewa: <?php echo $row['harga_sewa']; ?></p>
<p>Max Orang: <?php echo $row['max_orang']; ?></p>
<p>Awal Kontrak: <?php echo $row['awal_kontrak']; ?></p>
<p>Jatuh Tempo: <?php echo $row['jatuh_tempo']; ?></p>
<p>Nominal Pembayaran: <?php echo $row['nominal_pembayaran']; ?></p>

</body>
</html>
