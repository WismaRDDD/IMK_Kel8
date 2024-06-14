<!DOCTYPE html>
<html>
<head>
    <title>KOSTGAS - Choose Room</title>
    <style>

        *{
            font-family: playfair Display, Arial, sans-serif;
        }

        body {
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #EFEEE7;
        }

        header h1{
            color: #2B2C30;
            text-align: center;
            font-size: 6rem;
            font-weight: 400;
            padding: 5rem 0 2rem 0;
            margin: 0 20rem 0 20rem;
            border-bottom: 0.2rem solid black;
        }

        .container {
            font-size: 2rem;
            padding: 2rem;
            margin: 2rem auto;
            width: 80rem;
            display: flex;
        }

        .container .container-room{
            padding: 1rem;
            width: 28rem;
            justify-content: center;
        }

        .container .container-room h2{
            padding: 1rem;
            border-bottom: 0.2rem solid black;
        }

        .container .container-room button {
            font-weight: 600;
            display: block;
            width: 12rem;
            margin: 3rem auto;
            padding: 15px;
            border: 2px solid white;
            border-radius: 2.5rem;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            background: linear-gradient(to right, #825af4, #10B374);
        }     

        .container .container-room .room-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center; /* Center align rooms */
            color: white;
        }
        .container .container-room .room {
            width: 60px;
            height: 60px;
            margin: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 5px;
            cursor: pointer;
            background-color: lightblue; /* Default room color */
        }
        .container .container-room .available {
            background-color: green;
        }
        .container .container-room .occupied {
            background-color: red;
        }
        .container .container-room .selected {
            border: 2px solid blue;
        }

        .container hr{
            border: 0.1rem solid black;
            border-radius: 1rem;
        }

        .container .container-info{
            padding: 1rem;
            margin: 1rem auto;
        }   

        .container .container-info h2{
            padding: 1rem;
        }

        .container .container-info p{
            font-size: 1.2rem;
        }

        .container .container-info input[type="number"]::placeholder{
            color: #000000;
            font-weight: 400;
        }

        .container .container-info input[id="total"]{
            margin-left: 7rem;
        }


    </style>
</head>
<body>
    <header>
        <h1>KOSTGAS</h1>
    </header>

    <div class="container">
        <div class="container-room">
            <h2>Choose your room</h2>
            <form method="post" action="registration_step3.php">
                <div class="room-grid">
                    <?php
                    $conn = new mysqli('localhost', 'root', '', 'kostgas');

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    
                    $result = $conn->query("SELECT id, room_number, is_occupied, is_reserved FROM rooms");

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $room_number = $row['room_number'];
                            $is_occupied = $row['is_occupied'];
                            $is_reserved = $row['is_reserved'];
                            $class = 'room';
                            if ($is_occupied || $is_reserved) {
                                $class .= ' occupied';
                            } else {
                                $class .= ' available';
                            }
                            echo "<div class='$class' data-room-id='" . $row['id'] . "'>$room_number</div>";
                        }
                    } else {
                        echo "No rooms available.";
                    }

                    $conn->close();
                    ?>
                </div>
                <button type="submit">NEXT</button>
            </form>
        </div>

        <hr>

        <div class="container-info">
        <h2>Room Details</h2>
        <p>Room 4 x 5 M <br>
            Full Furniture ( with air conditioner ) <br>
            Rent fee : Rp 1.200.000/Month</p>
        <input type="hidden" id="selected_room" name="room_id">
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($_GET['username'] ?? ''); ?>">
            <input type="hidden" name="password" value="<?php echo htmlspecialchars($_GET['password'] ?? ''); ?>">
            <div>
                <label for="months">How many months :</label>
                <input type="number" id="months" name="months" min="1" placeholder="Number" required>
            </div>
            <div>
                <label for="total">Total Price :</label>
                <input type="number" id="total" name="total" readonly>
            </div>
        </div>            
    </div>

    <script>
        document.querySelectorAll('.room').forEach(room => {
            room.addEventListener('click', function() {
                if (this.classList.contains('occupied')) return;
                document.querySelectorAll('.room').forEach(r => r.classList.remove('selected'));
                this.classList.add('selected');
                document.getElementById('selected_room').value = this.dataset.roomId;
            });
        });

        document.getElementById('months').addEventListener('input', function() {
            const pricePerMonth = 1200000; // Example price per month
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