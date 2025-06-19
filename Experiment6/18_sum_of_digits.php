<!DOCTYPE html>
<html>
<head>
    <title>Sum of Individual Digits</title>
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
        table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .digit {
            font-size: 24px;
            font-weight: bold;
            color: #4a6fa5;
            margin: 0 5px;
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            background-color: #e9ecef;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sum of Individual Digits</h1>
        
        <?php
        // Function to calculate sum of individual digits
        function sumOfDigits($number) {
            // Convert number to string for easy digit extraction
            $numberStr = (string)$number;
            $sum = 0;
            $digits = [];
            
            // Calculate sum and store individual digits
            for ($i = 0; $i < strlen($numberStr); $i++) {
                $digit = (int)$numberStr[$i];
                $sum += $digit;
                $digits[] = $digit;
            }
            
            return [
                'sum' => $sum,
                'digits' => $digits
            ];
        }
        
        // Function to create a table of sums for different representations of a number
        function digitAnalysis($number) {
            $representations = [];
            
            // Original number
            $original = sumOfDigits($number);
            $representations[] = [
                'type' => 'Original Number',
                'value' => $number,
                'sum' => $original['sum'],
                'digits' => $original['digits']
            ];
            
            // Binary
            $binary = decbin($number);
            $binarySum = sumOfDigits($binary);
            $representations[] = [
                'type' => 'Binary',
                'value' => $binary,
                'sum' => $binarySum['sum'],
                'digits' => $binarySum['digits']
            ];
            
            // Octal
            $octal = decoct($number);
            $octalSum = sumOfDigits($octal);
            $representations[] = [
                'type' => 'Octal',
                'value' => $octal,
                'sum' => $octalSum['sum'],
                'digits' => $octalSum['digits']
            ];
            
            // Hexadecimal
            $hex = dechex($number);
            // For hex, we need to handle letters differently
            $hexSum = 0;
            $hexDigits = [];
            for ($i = 0; $i < strlen($hex); $i++) {
                $hexDigit = $hex[$i];
                $decimalValue = hexdec($hexDigit);
                $hexSum += $decimalValue;
                $hexDigits[] = $hexDigit;
            }
            $representations[] = [
                'type' => 'Hexadecimal',
                'value' => strtoupper($hex),
                'sum' => $hexSum,
                'digits' => $hexDigits
            ];
            
            return $representations;
        }
        
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the number from the form
            $number = $_POST["number"];
            $originalNumber = $number;
            
            // Calculate the sum of digits
            $result = sumOfDigits($number);
            $sum = $result['sum'];
            $digits = $result['digits'];
            
            // Display result
            echo "<div class='result'>";
            echo "<h3>Sum of Digits in $originalNumber:</h3>";
            echo "<div>";
            foreach ($digits as $digit) {
                echo "<span class='digit'>$digit</span>";
            }
            echo "</div>";
            echo "<h2>$sum</h2>";
            echo "</div>";
            
            // Show the calculation steps
            echo "<div class='steps'>";
            echo "<h3>Calculation Steps:</h3>";
            echo "<ol>";
            echo "<li>Number: $originalNumber</li>";
            echo "<li>Individual digits: " . implode(", ", $digits) . "</li>";
            echo "<li>Sum: " . implode(" + ", $digits) . " = $sum</li>";
            echo "</ol>";
            
            // Provide additional analysis
            $digitAnalysis = digitAnalysis($number);
            
            echo "<h3>Number Representation Analysis:</h3>";
            echo "<table>";
            echo "<tr><th>Representation</th><th>Value</th><th>Digits</th><th>Sum</th></tr>";
            
            foreach ($digitAnalysis as $analysis) {
                echo "<tr>";
                echo "<td>{$analysis['type']}</td>";
                echo "<td>{$analysis['value']}</td>";
                echo "<td>" . implode(", ", $analysis['digits']) . "</td>";
                echo "<td>{$analysis['sum']}</td>";
                echo "</tr>";
            }
            
            echo "</table>";
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
                <input type="submit" value="Calculate Sum of Digits">
            </p>
        </form>
        
        <div style="margin-top: 20px; font-size: 14px; color: #666;">
            This program calculates the sum of individual digits in a given number.
            For example, the sum of digits in 12345 is 1+2+3+4+5 = 15.
        </div>
    </div>
</body>
</html>
