<!DOCTYPE html>
<html>
<head>
    <title>Odd or Even</title>
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
        input[type="number"] {
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
        .result {
            margin-top: 20px;
            font-size: 18px;
            padding: 10px;
            border-radius: 5px;
        }
        .even {
            background-color: #d4edda;
            color: #155724;
        }
        .odd {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Odd or Even Number Checker</h1>
        
        <?php
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the number from the form
            $number = $_POST["number"];
            
            // Check if number is odd or even
            if ($number % 2 == 0) {
                echo "<div class='result even'>$number is an Even number.</div>";
            } else {
                echo "<div class='result odd'>$number is an Odd number.</div>";
            }
        }
        ?>
        
        <!-- HTML form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <p>
                <label for="number">Enter a Number:</label><br>
                <input type="number" id="number" name="number" required>
            </p>
            <p>
                <input type="submit" value="Check">
            </p>
        </form>
    </div>
</body>
</html>
