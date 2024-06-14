<!DOCTYPE html>
<html>
<head>
    <title>KOSTGAS - Login</title>
    <style>
        * {
            font-family: 'Playfair Display', serif;
        }

        body {
            text-align: center;
            padding: 0;
            margin: 0;
            background: #EFEEE7;
        }

        body h1 {
            font-size: 6rem;
            font-weight: 600;
            padding: 2rem;
        }

        .container {
            display: flex;
            justify-content: center;
            margin: 1rem 12rem;
            font-size: 1.2rem;
        }

        .container hr {
            border: 0.1rem solid black;
            border-radius: 1rem;
        }

        .container .box {
            margin: 0;
            padding: 0;
        }

        .container .box input[type="text"], .container .box input[type="password"] {
            width: 75%;
            padding: 1rem;
            margin: 1rem 2rem;
            border: 0.2rem solid black;
            border-radius: 0.2rem;
            font-weight: bold;
        }

        .container .box .button {
            background: none;
            display: block;
            border: none;
            border-radius: 1rem;
            color: white;
            font-size: 1rem;
            cursor: pointer;
        }

        .container .box .forgot-password {
            text-decoration: none;
            color: black;
            margin: 1rem;
            padding: 1rem;
            cursor: pointer;
        }

        .container .box .confirmation {
            background: linear-gradient(to right, #825af4, #10B374);
            width: 10rem;
            margin: 1rem auto;
            padding: 1rem;
        }
        
        .exit-button {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 1.5rem;
            padding: 0;
            width: 100%;
            height: 100%;
        }
        
        .exit {
            position: absolute;
            bottom: 1.5rem;
            right: 1.5rem;
            background: linear-gradient(to right, #825af4, #10B374);
            height: 3rem;
            width: 9.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
        }
    </style>
    <script>
        function forgotPassword() {
            var room_number = '101'; // Example room number, replace as necessary
            var username = 'tenant101'; // Example username, replace as necessary
            var mailto_link = "https://mail.google.com/mail/?view=cm&fs=1&to=2210511130@mahasiswa.upnvj.ac.id&su=" + encodeURIComponent("Password Reset " + room_number) + "&body=" + encodeURIComponent(
                "Dear Admin,\n\n" +
                "I hope this message finds you well. I am writing this to inform you that I have forgotten my password, and require a password reset.\n\n" +
                "Thank you for your attention to this matter.\n\n" +
                "Sincerely,\n" +
                username
            );
            window.location.href = mailto_link;
        }
    </script>
</head>
<body>
    <h1>KOSTGAS</h1>
    <div class="container">
        <div class="box">
            <h2>Login as Tenant</h2>
            <form method="post" action="tenant_login.php">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <a href="#" class="forgot-password" onclick="forgotPassword()">FORGET PASSWORD?</a>
                <button class="button confirmation" type="submit">CONFIRMATION</button>
            </form>
        </div>
        <hr>
        <div class="box">
            <h2>Login as Landlord</h2>
            <form method="post" action="landlord_login.php">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <a href="#" class="forgot-password" onclick="forgotPassword()">FORGET PASSWORD?</a>
                <button class="button confirmation" type="submit">CONFIRMATION</button>
            </form>
        </div>
    </div>
    <div class="exit">
        <form method="get" action="index.php">
            <button class="exit-button" type="submit">EXIT</button>
        </form>
    </div>
</body>
</html>

