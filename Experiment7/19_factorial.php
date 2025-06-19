<!DOCTYPE html>
<html>
<head>
    <title>Factorial Calculator</title>
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
            padding: 15px;
            border-radius: 5px;
            background-color: #d4edda;
            color: #155724;
        }
        .steps {
            margin-top: 20px;
            text-align: left;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        .warning {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            background-color: #fff3cd;
            color: #856404;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .formula {
            font-family: "Times New Roman", Times, serif;
            font-style: italic;
            margin: 20px 0;
            font-size: 18px;
        }
        .info-box {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            background-color: #e2f0fe;
            color: #0c5460;
            font-size: 14px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Factorial Calculator</h1>
        
        <div class="formula">
            n! = n × (n-1) × (n-2) × ... × 2 × 1
        </div>
        
        <?php
        // Function to calculate factorial
        function calculateFactorial($n) {
            // Only calculate for non-negative integers
            if ($n < 0) {
                return "Undefined (Factorial is only defined for non-negative integers)";
            }
            
            // Special cases
            if ($n == 0 || $n == 1) {
                return 1;
            }
            
            // Calculate factorial for n > 1
            $factorial = 1;
            for ($i = 2; $i <= $n; $i++) {
                $factorial *= $i;
            }
            
            return $factorial;
        }
        
        // Create a step-by-step calculation sequence
        function factorialSteps($n) {
            $steps = [];
            $product = 1;
            
            for ($i = 1; $i <= $n; $i++) {
                $product *= $i;
                $steps[$i] = $product;
            }
            
            return $steps;
        }
        
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the number from the form
            $number = $_POST["number"];
            
            // Validate input: must be a non-negative integer
            if ($number < 0) {
                echo "<div class='warning'>Factorial is only defined for non-negative integers.</div>";
            } else {
                // Cap the calculation at a reasonable limit to prevent timeouts and memory issues
                if ($number > 170) {
                    echo "<div class='warning'>For better performance, the calculation is limited to numbers below 171. Values above this would exceed PHP's floating-point precision.</div>";
                    $number = min($number, 170);
                }
                
                // Calculate the factorial
                $factorialResult = calculateFactorial($number);
                
                // Display result
                echo "<div class='result'>";
                echo "<h3>Factorial of $number:</h3>";
                echo "<h2>$number! = " . number_format($factorialResult, 0, '.', ',') . "</h2>";
                echo "</div>";
                
                // Show the calculation steps
                echo "<div class='steps'>";
                echo "<h3>Calculation Steps:</h3>";
                
                if ($number == 0) {
                    echo "<p>By definition, 0! = 1</p>";
                } else {
                    echo "<table>";
                    echo "<tr><th>Step</th><th>Calculation</th><th>Result</th></tr>";
                    
                    $steps = factorialSteps($number);
                    $calculation = "";
                    
                    for ($i = 1; $i <= $number; $i++) {
                        if ($i == 1) {
                            $calculation = "1";
                        } else {
                            $calculation .= " × $i";
                        }
                        
                        echo "<tr>";
                        echo "<td>Step $i</td>";
                        echo "<td>$calculation</td>";
                        echo "<td>" . number_format($steps[$i], 0, '.', ',') . "</td>";
                        echo "</tr>";
                    }
                    
                    echo "</table>";
                }
                
                echo "</div>";
                
                // Show information about factorials
                echo "<div class='info-box'>";
                echo "<h3>About Factorial:</h3>";
                echo "<p>The factorial function (denoted as n!) is the product of all positive integers less than or equal to n.</p>";
                echo "<p>Some interesting facts:</p>";
                echo "<ul>";
                echo "<li>0! is defined as 1</li>";
                echo "<li>Factorials grow very quickly - 10! is already over 3.6 million</li>";
                echo "<li>Factorials are used in combinatorics, probability theory, and calculus</li>";
                echo "</ul>";
                echo "</div>";
            }
        }
        ?>
        
        <!-- HTML form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <p>
                <label for="number">Enter a non-negative integer:</label><br>
                <input type="number" id="number" name="number" min="0" max="170" step="1" required>
            </p>
            <p>
                <input type="submit" value="Calculate Factorial">
            </p>
        </form>
    </div>
</body>
</html>
