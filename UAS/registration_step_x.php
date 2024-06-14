<!DOCTYPE html>
<html>
<head>
    <title>KOSTGAS - Choose Room</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        .container {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
            width: 800px;
        }
        .room-grid {
            display: flex;
            flex-wrap: wrap;
        }
        .room {
            width: 60px;
            height: 60px;
            margin: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 5px;
            cursor: pointer;
        }
        .available {
            background-color: green;
        }
        .occupied {
            background-color: red;
        }
        .selected {
            border: 2px solid blue;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Choose your room</h2>
        <form id="room_form" method="post" action="registration_step4.php">
            <div class="room-grid">
                <?php
               $conn = new mysqli('localhost', 'root', '', 'kostgas');

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $result = $conn->query("SELECT room_number, is_occupied, is_reserved FROM rooms");

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $room_number = $row['room_number'];
                        $is_occupied = $row['is_occupied'];
                        $is_reserved = $row['is_reserved'];
                        $class = 'available';
                        if ($is_occupied || $is_reserved) {
                            $class = 'occupied';
                        }
                        echo "<div class='room $class' data-room='$room_number'>$room_number</div>";
                    }
                }

                $conn->close();
                ?>
            </div>
            <input type="hidden" id="selected_room" name="selected_room">
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($_POST['username']); ?>">
            <input type="hidden" name="password" value="<?php echo htmlspecialchars($_POST['password']); ?>">
            <div>
                <label for="months">How many months</label>
                <input type="number" id="months" name="months" min="1" required>
            </div>
            <div>
                <label for="total">Total Price</label>
                <input type="number" id="total" name="total" readonly>
            </div>
            <button type="submit">NEXT</button>
        </form>
    </div>

    <script>
        document.querySelectorAll('.room').forEach(room => {
            room.addEventListener('click', function() {
                if (this.classList.contains('occupied')) return;
                document.querySelectorAll('.room').forEach(r => r.classList.remove('selected'));
                this.classList.add('selected');
                document.getElementById('selected_room').value = this.dataset.room;
            });
        });

        document.getElementById('months').addEventListener('input', function() {
            const pricePerMonth = 1200000;
            document.getElementById('total').value = this.value * pricePerMonth;
        });

        document.getElementById('room_form').addEventListener('submit', function(e) {
            if (!document.getElementById('selected_room').value) {
                e.preventDefault();
                alert("Please select a room.");
            }
        });
    </script>
</body>
</html>
