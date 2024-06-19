<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KOSTGAS - Landlord Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }
        .container {
            display: flex;
        }
        .sidebar {
            position: relative;
        }
        .menu-button {
            font-size: 24px;
            cursor: pointer;
            padding: 10px;
            background: none;
            border: none;
        }
        .menu {
            display: none;
            position: absolute;
            top: 40px;
            right: 0;
            background: #f0f0f0;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .menu a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #000;
            border-bottom: 1px solid #ccc;
        }
        .menu a:hover {
            background: #e0e0e0;
        }
        .main {
            flex: 1;
            padding: 20px;
            text-align: center;
        }
        h1 {
            margin: 0;
            padding: 10px 0;
            font-size: 36px;
        }
        .section-header {
            margin: 20px 0 10px;
            font-size: 24px;
            font-weight: bold;
        }
        .room-status {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .room {
            padding: 20px;
            background-color: red;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border-radius: 5px;
            width: 80px;
            height: 80px;
        }
        .room.available {
            background-color: green;
        }
        .room span {
            display: block;
            text-align: center;
        }
        .action-button {
            margin: 10px;
            padding: 10px 20px;
            background: linear-gradient(45deg, #7b42f6, #b69deb);
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 20px;
            font-size: 16px;
            transition: background 0.3s;
        }
        .action-button:hover {
            background: linear-gradient(45deg, #b69deb, #7b42f6);
        }
        .legend {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .legend div {
            display: flex;
            align-items: center;
            margin: 0 10px;
        }
        .legend div span {
            width: 20px;
            height: 20px;
            display: inline-block;
            margin-right: 5px;
        }
        .legend .available span {
            background-color: green;
        }
        .legend .occupied span {
            background-color: red;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .overlay-content {
            background: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }
        .overlay-button {
            margin: 5px;
            padding: 10px 20px;
            background-color: purple;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        #qrReader {
            width: 100%;
            max-width: 500px;
            height: 300px;
            position: relative;
        }
        #qrReader video {
            width: 100%;
            height: 100%;
        }
        #qrReader .square {
            border: 3px solid red;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <button id="menuButton" class="menu-button">☰</button>
            <div id="menu" class="menu">
                <a href="profile_landlord.php">Profile</a>
                <a href="login.php">Logout</a>
            </div>
        </div>
        <div class="main">
            <h1>KOSTGAS</h1>

            <!-- Header Lantai 1 -->
            <div class="section-header">Lantai 1</div>
            <div class="room-status">
                <?php
                $rooms_1xx = [
                    ["number" => 101, "status" => "available"],
                    ["number" => 102, "status" => "available"],
                    ["number" => 103, "status" => "occupied", "date" => "31/12/2024"],
                    ["number" => 104, "status" => "occupied", "date" => "31/12/2024"],
                    ["number" => 105, "status" => "occupied", "date" => "31/12/2024"]
                ];

                foreach ($rooms_1xx as $room) {
                    $statusClass = $room['status'] === 'available' ? 'available' : '';
                    $date = isset($room['date']) ? "<span>{$room['date']}</span>" : '';
                    echo "<div class='room $statusClass' data-room='{$room['number']}'>$date</div>";
                }
                ?>
            </div>

            <!-- Header Lantai 2 -->
            <div class="section-header">Lantai 2</div>
            <div class="room-status">
                <?php
                $rooms_2xx = [
                    ["number" => 201, "status" => "available"],
                    ["number" => 202, "status" => "available"],
                    ["number" => 203, "status" => "occupied", "date" => "31/12/2024"],
                    ["number" => 204, "status" => "occupied", "date" => "31/12/2024"]
                ];

                foreach ($rooms_2xx as $room) {
                    $statusClass = $room['status'] === 'available' ? 'available' : '';
                    $date = isset($room['date']) ? "<span>{$room['date']}</span>" : '';
                    echo "<div class='room $statusClass' data-room='{$room['number']}'>$date</div>";
                }
                ?>
            </div>

            <button id="scanQRButton" class="action-button">Scan QR</button>

            <div class="legend">
                <div class="available"><span></span> Available</div>
                <div class="occupied"><span></span> Occupied</div>
            </div>
        </div>
    </div>
    <div id="qrOverlay" class="overlay">
        <div class="overlay-content">
            <div id="qrReader">
                <video id="video" autoplay></video>
                <canvas id="canvas" class="square"></canvas>
            </div>
            <button id="closeQrOverlay" class="overlay-button">Close</button>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuButton = document.getElementById('menuButton');
            const menu = document.getElementById('menu');
            const scanQRButton = document.getElementById('scanQRButton');
            const qrOverlay = document.getElementById('qrOverlay');
            const closeQrOverlay = document.getElementById('closeQrOverlay');
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const canvasContext = canvas.getContext('2d');
            let stream;

            menuButton.addEventListener('click', () => {
                menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
            });

            scanQRButton.addEventListener('click', async () => {
                qrOverlay.style.display = 'flex';
                stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
                video.srcObject = stream;

                video.addEventListener('play', () => {
                    const drawFrame = () => {
                        if (video.paused || video.ended) {
                            return;
                        }

                        canvasContext.drawImage(video, 0, 0, canvas.width, canvas.height);
                        const imageData = canvasContext.getImageData(0, 0, canvas.width, canvas.height);
                        const code = jsQR(imageData.data, imageData.width, imageData.height, {
                            inversionAttempts: 'dontInvert',
                        });

                        if (code) {
                            alert(`QR Code detected: ${code.data}`);
                            qrOverlay.style.display = 'none';
                            stream.getTracks().forEach(track => track.stop());
                        } else {
                            requestAnimationFrame(drawFrame);
                        }
                    };
                    drawFrame();
                });
            });

            closeQrOverlay.addEventListener('click', () => {
                qrOverlay.style.display = 'none';
                stream.getTracks().forEach(track => track.stop());
            });
        });
    </script>
</body>
</html>
