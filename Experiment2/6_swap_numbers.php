<!DOCTYPE html>
<html>
<head>
    <title>Swap Two Numbers</title>
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
        .step {
            margin: 10px 0;
            text-align: left;
            padding-left: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Swap Two Numbers</h1>
        
        <?php
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the two numbers from the form
            $num1 = $_POST["num1"];
            $num2 = $_POST["num2"];
            
            echo "<div class='result'>";
            echo "<h3>Swapping Process:</h3>";
            echo "<div class='step'>Original values: a = $num1, b = $num2</div>";
            
            // Swapping using a temporary variable
            $temp = $num1;
            $num1 = $num2;
            $num2 = $temp;
            
            echo "<div class='step'>Step 1: Create a temporary variable: temp = $temp</div>";
            echo "<div class='step'>Step 2: Assign b to a: a = $num1</div>";
            echo "<div class='step'>Step 3: Assign temp to b: b = $num2</div>";
            echo "<div class='step'>After swapping: a = $num1, b = $num2</div>";
            
            echo "</div>";
        }
        ?>
        
        <!-- HTML form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <p>
                <label for="num1">Enter First Number (a):</label><br>
                <input type="number" id="num1" name="num1" required>
            </p>
            <p>
                <label for="num2">Enter Second Number (b):</label><br>
                <input type="number" id="num2" name="num2" required>
            </p>
            <p>
                <input type="submit" value="Swap Numbers">
            </p>
        </form>
    </div>
</body>
</html>
