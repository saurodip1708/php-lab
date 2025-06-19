<!DOCTYPE html>
<html>
<head>
    <title>Greeting Form</title>
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
            min-width: 400px;
        }
        input[type="text"] {
            padding: 8px;
            width: 200px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 8px 20px;
            background-color: #4a6fa5;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #3a5982;
        }
        .greeting {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PHP Greeting Form</h1>
        
        <?php
        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the name from the form
            $name = $_POST["name"];
            
            // Display greeting message
            echo "<div class='greeting'>Hello, $name! Welcome to our website.</div>";
        }
        ?>
        
        <!-- HTML form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <p>
                <label for="name">Enter Your Name:</label><br>
                <input type="text" id="name" name="name" required>
            </p>
            <p>
                <input type="submit" value="Submit">
            </p>
        </form>
    </div>
</body>
</html>
