<!DOCTYPE html>
<html>
<head>
    <title>Armstrong Number Checker</title>
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
            padding: 15px;
            border-radius: 5px;
        }
        .armstrong {
            background-color: #d4edda;
            color: #155724;
        }
        .not-armstrong {
            background-color: #f8d7da;
            color: #721c24;
        }
        .steps {
            margin-top: 20px;
            text-align: left;
            padding-left: 20px;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        .info-box {
            margin-top: 20px;
            padding: 15px;
            background-color: #e2f0fe;
            border-radius: 5px;
            border: 1px solid #bee5eb;
            color: #0c5460;
            font-size: 14px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Armstrong Number Checker</h1>
        
        <?php
        // Function to check if a number is Armstrong
        function isArmstrong($num) {
            // Convert number to string to count digits
            $numStr = (string)$num;
            $numLength = strlen($numStr);
            $sum = 0;
            
            // Calculate sum of digits raised to the power of the number of digits
            for ($i = 0; $i < $numLength; $i++) {
                $digit = (int)$numStr[$i];
                $sum += pow($digit, $numLength);
            }
            
            // Return true if sum equals the original number
            return $sum === $num;
        }
        
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get number from the form
            $number = $_POST["number"];
            $originalNumber = $number;
            
            // Check if number is Armstrong
            $isArmstrong = isArmstrong($number);
            
            // Display result
            if ($isArmstrong) {
                echo "<div class='result armstrong'><strong>$originalNumber is an Armstrong Number!</strong></div>";
            } else {
                echo "<div class='result not-armstrong'><strong>$originalNumber is NOT an Armstrong Number.</strong></div>";
            }
            
            // Show the calculation process
            $numStr = (string)$originalNumber;
            $numLength = strlen($numStr);
            $calculations = array();
            $sum = 0;
            
            for ($i = 0; $i < $numLength; $i++) {
                $digit = (int)$numStr[$i];
                $power = pow($digit, $numLength);
                $sum += $power;
                $calculations[] = "$digit<sup>$numLength</sup> = $power";
            }
            
            echo "<div class='steps'>";
            echo "<h3>Verification Process:</h3>";
            echo "<ol>";
            echo "<li>Number: $originalNumber</li>";
            echo "<li>Number of digits: $numLength</li>";
            echo "<li>Raising each digit to the power of $numLength:</li>";
            echo "<ul>";
            foreach ($calculations as $calc) {
                echo "<li>$calc</li>";
            }
            echo "</ul>";
            echo "<li>Sum of all powers: " . implode(" + ", array_map(function($calc) {
                $parts = explode(" = ", $calc);
                return $parts[1];
            }, $calculations)) . " = $sum</li>";
            echo "<li>Comparison: " . ($isArmstrong ? 
                                       "$sum equals $originalNumber, so it's an Armstrong number." : 
                                       "$sum does not equal $originalNumber, so it's not an Armstrong number.") . "</li>";
            echo "</ol>";
            echo "</div>";
        }
        ?>
        
        <!-- HTML form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <p>
                <label for="number">Enter a Number:</label><br>
                <input type="number" id="number" name="number" min="1" required>
            </p>
            <p>
                <input type="submit" value="Check Armstrong Number">
            </p>
        </form>
        
        <div class="info-box">
            <strong>What is an Armstrong Number?</strong>
            <p>An Armstrong number (also known as a narcissistic number) is a number where the sum of each digit raised to the power of the number of digits equals the original number.</p>
            <p>For example:</p>
            <ul>
                <li>153 = 1<sup>3</sup> + 5<sup>3</sup> + 3<sup>3</sup> = 1 + 125 + 27 = 153</li>
                <li>370 = 3<sup>3</sup> + 7<sup>3</sup> + 0<sup>3</sup> = 27 + 343 + 0 = 370</li>
                <li>1634 = 1<sup>4</sup> + 6<sup>4</sup> + 3<sup>4</sup> + 4<sup>4</sup> = 1 + 1296 + 81 + 256 = 1634</li>
            </ul>
        </div>
    </div>
</body>
</html>
