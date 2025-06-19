<!DOCTYPE html>
<html>
<head>
    <title>Print Name</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            text-align: center;
            background-color: #f0f0f0;
        }
        h1 {
            color: #4a6fa5;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PHP Name Display</h1>
        <?php
            // Define name variable
            $name = "Saurodip";
            
            // Output the name
            echo "<h2>Hello, my name is $name!</h2>";
        ?>
    </div>
</body>
</html>
