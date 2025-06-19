<!DOCTYPE html>
<html>
<head>
    <title>Fibonacci Series Generator</title>
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
            max-width: 800px;
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
            text-align: center;
        }
        .fibonacci-numbers {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-top: 15px;
        }
        .fibonacci-number {
            display: inline-block;
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 5px;
            min-width: 30px;
            font-weight: bold;
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
        <h1>Fibonacci Series Generator</h1>
        
        <div class="formula">
            F<sub>n</sub> = F<sub>n-1</sub> + F<sub>n-2</sub>, where F<sub>0</sub> = 0 and F<sub>1</sub> = 1
        </div>
        
        <?php
        // Function to generate Fibonacci series up to n terms
        function generateFibonacciSeries($n) {
            $fibonacci = [];
            
            // Handle special cases
            if ($n <= 0) {
                return $fibonacci;
            }
            
            // First two Fibonacci numbers
            $fibonacci[0] = 0;
            
            if ($n == 1) {
                return $fibonacci;
            }
            
            $fibonacci[1] = 1;
            
            // Generate the rest of the series
            for ($i = 2; $i < $n; $i++) {
                $fibonacci[$i] = $fibonacci[$i-1] + $fibonacci[$i-2];
            }
            
            return $fibonacci;
        }
        
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get number of terms from the form
            $terms = $_POST["terms"];
            $originalTerms = $terms;
            
            // Validate input: must be a positive integer
            if ($terms <= 0) {
                echo "<div class='warning'>Please enter a positive number.</div>";
            } else {
                // Cap the calculation at a reasonable limit to prevent timeouts
                if ($terms > 100) {
                    echo "<div class='warning'>For better display, showing first 100 terms only.</div>";
                    $terms = 100;
                }
                
                // Generate the Fibonacci series
                $fibonacciSeries = generateFibonacciSeries($terms);
                
                // Display result
                echo "<div class='result'>";
                echo "<h3>First $originalTerms term" . ($originalTerms > 1 ? "s" : "") . " of Fibonacci Series:</h3>";
                
                echo "<div class='fibonacci-numbers'>";
                foreach ($fibonacciSeries as $index => $number) {
                    echo "<span class='fibonacci-number' title='F$index = $number'>$number</span>";
                }
                echo "</div>";
                
                echo "</div>";
                
                // Show the calculation steps
                echo "<div class='steps'>";
                echo "<h3>Calculation Steps:</h3>";
                
                echo "<table>";
                echo "<tr><th>Position</th><th>Value</th><th>Calculation</th></tr>";
                
                foreach ($fibonacciSeries as $index => $number) {
                    echo "<tr>";
                    echo "<td>F<sub>$index</sub></td>";
                    echo "<td>$number</td>";
                    
                    if ($index == 0) {
                        echo "<td>By definition, F<sub>0</sub> = 0</td>";
                    } elseif ($index == 1) {
                        echo "<td>By definition, F<sub>1</sub> = 1</td>";
                    } else {
                        $prev1 = $fibonacciSeries[$index-1];
                        $prev2 = $fibonacciSeries[$index-2];
                        echo "<td>F<sub>$index</sub> = F<sub>" . ($index-1) . "</sub> + F<sub>" . ($index-2) . "</sub> = $prev1 + $prev2 = $number</td>";
                    }
                    
                    echo "</tr>";
                }
                
                echo "</table>";
                echo "</div>";
                
                // Show information about Fibonacci series
                echo "<div class='info-box'>";
                echo "<h3>About Fibonacci Series:</h3>";
                echo "<p>The Fibonacci sequence is a series where each number is the sum of the two preceding ones, starting from 0 and 1.</p>";
                echo "<p>Some interesting facts:</p>";
                echo "<ul>";
                echo "<li>The sequence appears in many settings in mathematics and nature</li>";
                echo "<li>The ratio of consecutive Fibonacci numbers approaches the golden ratio (approximately 1.618)</li>";
                echo "<li>Fibonacci numbers are related to the golden spiral, which appears in shells, flowers, and galaxies</li>";
                echo "</ul>";
                echo "</div>";
            }
        }
        ?>
        
        <!-- HTML form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <p>
                <label for="terms">Enter number of terms to generate:</label><br>
                <input type="number" id="terms" name="terms" min="1" max="100" required>
            </p>
            <p>
                <input type="submit" value="Generate Fibonacci Series">
            </p>
        </form>
    </div>
</body>
</html>
