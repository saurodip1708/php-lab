<!DOCTYPE html>
<html>
<head>
    <title>PHP Calculator</title>
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
        select {
            padding: 8px;
            width: 220px;
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
        .error {
            margin-top: 20px;
            font-size: 18px;
            padding: 10px;
            border-radius: 5px;
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PHP Calculator</h1>
        
        <?php
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the numbers and operation from the form
            $num1 = $_POST["num1"];
            $num2 = $_POST["num2"];
            $operation = $_POST["operation"];
            
            // Perform calculation based on selected operation
            switch ($operation) {
                case "add":
                    $result = $num1 + $num2;
                    $symbol = "+";
                    break;
                case "subtract":
                    $result = $num1 - $num2;
                    $symbol = "-";
                    break;
                case "multiply":
                    $result = $num1 * $num2;
                    $symbol = "×";
                    break;
                case "divide":
                    if ($num2 == 0) {
                        echo "<div class='error'>Error: Division by zero is not allowed!</div>";
                        $result = null;
                        $symbol = "÷";
                    } else {
                        $result = $num1 / $num2;
                        $symbol = "÷";
                    }
                    break;
                case "modulus":
                    if ($num2 == 0) {
                        echo "<div class='error'>Error: Modulus by zero is not allowed!</div>";
                        $result = null;
                        $symbol = "%";
                    } else {
                        $result = $num1 % $num2;
                        $symbol = "%";
                    }
                    break;
                case "power":
                    $result = pow($num1, $num2);
                    $symbol = "^";
                    break;
                default:
                    $result = null;
                    $symbol = "";
            }
            
            // Display result if valid
            if ($result !== null) {
                echo "<div class='result'>$num1 $symbol $num2 = $result</div>";
            }
        }
        ?>
        
        <!-- HTML form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <p>
                <label for="num1">Enter First Number:</label><br>
                <input type="number" id="num1" name="num1" step="any" required>
            </p>
            <p>
                <label for="operation">Select Operation:</label><br>
                <select id="operation" name="operation" required>
                    <option value="add">Addition (+)</option>
                    <option value="subtract">Subtraction (-)</option>
                    <option value="multiply">Multiplication (×)</option>
                    <option value="divide">Division (÷)</option>
                    <option value="modulus">Modulus (%)</option>
                    <option value="power">Power (^)</option>
                </select>
            </p>
            <p>
                <label for="num2">Enter Second Number:</label><br>
                <input type="number" id="num2" name="num2" step="any" required>
            </p>
            <p>
                <input type="submit" value="Calculate">
            </p>
        </form>
    </div>
</body>
</html>
