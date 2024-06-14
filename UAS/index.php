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
          font-family: Playfair display;
        }

        body {
            font-family: Arial, sans-serif;
            padding : 0;
            margin: 0;
            overflow : hidden;
            background-color: #fff;
            width: 100%;
        }

        header{
            background-color: #EFEEE7;
            padding: 70px;
        }

        header h1{
            color: #2B2C30;
            text-align: center;
            font-size: 100px;
            font-weight: 400;
        }

        .container {
            padding: 10px;
            display: flex;
            justify-content: center;
            background-color: #fff;
        }

        .container hr { 
            margin-top: 15px;
            margin-bottom: 50px;
            height: 500px;
            border: 1px solid black;
            border-radius: 15px;
        }

        .container .box {
            font-weight: bold;
            font-size: 25px;
        }

        .container .box p {
            margin: 125px 175px;
        }

        .container .box button {
            font-weight: 600;
            display: block;
            width: 400px;
            margin: 60px auto;
            padding: 15px;
            border: 2px solid white;
            border-radius: 35px;
            color: white;
            font-size: 30px;
            cursor: pointer;
        }

        .container .box button.login {
            background: linear-gradient(to right, #825af4, #10B374);
        }

        .container .box button.registration {
            background: linear-gradient(to right, #825af4, #10B374);
        }

        footer{
            text-align: right;
            background-color: #2B2C30;
            color: #EFEEE7;
        }

        footer p{
            font-weight: 400;
            font-size: 25px;
            margin: 0;
            padding-top: 20px;
            padding-right: 50px;
        }

        footer p.cp{
            font-weight: 400;
            font-size: 25px;
            margin: 0;
            padding-top: 5px;
            padding-bottom: 25px;
            padding-right: 50px;
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
        <p>✉ Contact Person</p>
        <p class="cp">✆ Contact Person</p>
    </footer>
</body>
</html>
