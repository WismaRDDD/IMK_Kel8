<?php
// Proses pendaftaran pengguna baru
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    
    // Lakukan validasi dan sanitasi data disini
    // Simpan data ke database atau lakukan tindakan lainnya
    
    // Contoh sederhana penyimpanan data
    $data = [
        'username' => $username,
        'password' => password_hash($password, PASSWORD_BCRYPT), // Enkripsi password
        'full_name' => $full_name,
        'email' => $email
    ];
    
    // Misalnya kita simpan ke file, tapi sebaiknya simpan ke database
    file_put_contents('users.txt', json_encode($data) . PHP_EOL, FILE_APPEND);
    
    echo "Registrasi berhasil!"; // Tampilkan pesan sukses atau alihkan ke halaman lain
}
?>
