<!DOCTYPE html>
<html>
<head>
    <title>Maximum of Three Numbers</title>
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
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Maximum of Three Numbers</h1>
        
        <?php
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the three numbers from the form
            $num1 = $_POST["num1"];
            $num2 = $_POST["num2"];
            $num3 = $_POST["num3"];
            
            // Find the maximum number
            $max = max($num1, $num2, $num3);
            
            // Display the result
            echo "<div class='result'>The maximum number among $num1, $num2, and $num3 is: $max</div>";
        }
        ?>
        
        <!-- HTML form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <p>
                <label for="num1">Enter First Number:</label><br>
                <input type="number" id="num1" name="num1" required>
            </p>
            <p>
                <label for="num2">Enter Second Number:</label><br>
                <input type="number" id="num2" name="num2" required>
            </p>
            <p>
                <label for="num3">Enter Third Number:</label><br>
                <input type="number" id="num3" name="num3" required>
            </p>
            <p>
                <input type="submit" value="Find Maximum">
            </p>
        </form>
    </div>
</body>
</html>
