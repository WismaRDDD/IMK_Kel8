<?php
include 'config.php';

$sql = "SELECT id, nomor_kamar FROM kost";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $kost_id = $row['id'];
        $sql_check = "SELECT * FROM sewa WHERE kost_id='$kost_id'";
        $result_check = $conn->
query($sql_check);

        if ($result_check->num_rows > 0) {
            echo "Kamar " . $row["nomor_kamar"] . " penuh<br>";
        } else {
            echo "Kamar " . $row["nomor_kamar"] . " kosong<br>";
        }
    }
} else {
    echo "Tidak ada data kamar.";
}

$conn->close();
?>
