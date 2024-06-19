<!DOCTYPE html>
<html>
<head>
    <title>KOSTGAS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            outline: none;
            border: none;
            text-decoration: none;
            box-sizing: border-box; /* Tambahkan ini untuk memastikan padding dan border termasuk dalam ukuran elemen */
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #fff;
            width: 100%;
            height: 100vh; /* Pastikan body mengambil seluruh tinggi viewport */
            display: flex;
            flex-direction: column;
            overflow: auto; /* Tambahkan overflow auto untuk mengizinkan scrolling */
        }

        header {
            background-color: #EFEEE7;
            padding: 20px;
            flex: 0 0 auto;
        }

        header h1 {
            color: #2B2C30;
            text-align: center;
            font-size: 5vw; /* Menggunakan vw untuk skala font yang responsif */
            font-weight: 400;
        }

        .container {
            flex: 1 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fff;
            padding: 10px;
        }

        .container hr {
            height: 80%;
            border: 1px solid black;
            border-radius: 15px;
            margin: 0 20px;
        }

        .container .box {
            font-weight: bold;
            font-size: 2vw; /* Menggunakan vw untuk skala font yang responsif */
            text-align: center;
            min-width: 200px; /* Menambahkan min-width untuk memastikan elemen tidak terlalu kecil */
        }

        .container .box p {
            margin: 20px;
        }

        .container .box button {
            font-weight: 600;
            display: block;
            width: 20vw; /* Menggunakan vw untuk lebar yang responsif */
            margin: 20px auto;
            padding: 10px;
            border: 2px solid white;
            border-radius: 35px;
            color: white;
            font-size: 2vw; /* Menggunakan vw untuk skala font yang responsif */
            cursor: pointer;
            background: linear-gradient(to right, #825af4, #10B374);
            min-width: 150px; /* Menambahkan min-width untuk tombol */
        }

        footer {
            text-align: right;
            background-color: #2B2C30;
            color: #EFEEE7;
            flex: 0 0 auto;
        }

        footer p {
            font-weight: 400;
            font-size: 2vw; /* Menggunakan vw untuk skala font yang responsif */
            margin: 0;
            padding: 10px 50px;
        }

        footer p.cp {
            padding-top: 5px;
            padding-bottom: 25px;
        }
    </style>
</head>
<body>
    <header>
        <h1>KOSTGAS</h1>
    </header>    
    <div class="container">
        <div class="box">
            <p><i>if you're a tenant or landlord</i></p>
            <button class="button login" onclick="window.location.href='login.php'">L O G I N</button>
        </div>
        <hr>
        <div class="box">
            <p><i>if you're a guest who want to rent</i></p>
            <button class="button registration" onclick="window.location.href='registration.php'">R E G I S T R A T I O N</button>
        </div>
    </div>
    <footer>
        <p>✉ <a href="mailto:2210511166@mahasiswa.upnvj.ac.id" target="_blank">KOSTGAS</a></p>
        <p class="cp">✆ <a href="https://wa.me/6282125221351" target="_blank">KOSTGAS</a></p>
    </footer>
</body>
</html>