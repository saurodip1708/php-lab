<!DOCTYPE html>
<html>
<head>
    <title>Division Table</title>
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
            min-width: 500px;
        }
        .form-container {
            margin-bottom: 30px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        input[type="number"] {
            padding: 8px;
            width: 80px;
            margin: 5px;
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
            margin-top: 10px;
        }
        input[type="submit"]:hover {
            background-color: #3a5982;
        }
        table.division-table {
            border-collapse: collapse;
            margin: 20px auto;
        }
        table.division-table th, table.division-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        table.division-table th {
            background-color: #4a6fa5;
            color: white;
            font-weight: bold;
        }
        table.division-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table.division-table tr:hover {
            background-color: #e2e6ea;
        }
        .error {
            color: #dc3545;
            margin: 10px 0;
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
        .legend {
            margin: 15px auto;
            text-align: center;
        }
        .legend-item {
            display: inline-block;
            margin: 0 10px;
            font-size: 14px;
        }
        .legend-color {
            display: inline-block;
            width: 15px;
            height: 15px;
            margin-right: 5px;
            vertical-align: middle;
        }
        .precision-warning {
            color: #856404;
            background-color: #fff3cd;
            border-radius: 5px;
            padding: 10px;
            margin: 15px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Division Table Generator</h1>
        
        <div class="form-container">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <p>
                    <label for="start">Start Number:</label>
                    <input type="number" id="start" name="start" value="<?php echo isset($_POST['start']) ? $_POST['start'] : 1; ?>" min="1" max="20" required>
                    
                    <label for="end">End Number:</label>
                    <input type="number" id="end" name="end" value="<?php echo isset($_POST['end']) ? $_POST['end'] : 10; ?>" min="1" max="20" required>
                </p>
                <p>
                    <label for="precision">Decimal Precision:</label>
                    <input type="number" id="precision" name="precision" value="<?php echo isset($_POST['precision']) ? $_POST['precision'] : 2; ?>" min="0" max="10" required>
                </p>
                <input type="submit" value="Generate Table">
            </form>
        </div>
        
        <?php
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get input values
            $startNum = isset($_POST['start']) ? (int)$_POST['start'] : 1;
            $endNum = isset($_POST['end']) ? (int)$_POST['end'] : 10;
            $precision = isset($_POST['precision']) ? (int)$_POST['precision'] : 2;
            
            // Validate inputs
            $error = "";
            if ($startNum <= 0 || $endNum <= 0) {
                $error = "Numbers must be positive.";
            } elseif ($startNum > $endNum) {
                $error = "Start number cannot be greater than end number.";
            } elseif ($endNum - $startNum > 20) {
                $error = "Range is too large. Please limit to 20 numbers.";
            }
            
            if (!empty($error)) {
                echo "<p class='error'>$error</p>";
            } else {
                // Display precision information
                if ($precision > 0) {
                    echo "<div class='precision-warning'>Results are rounded to $precision decimal places.</div>";
                }
                
                // Generate and display the division table
                echo "<table class='division-table'>";
                
                // Table header
                echo "<tr><th>÷</th>";
                for ($i = $startNum; $i <= $endNum; $i++) {
                    echo "<th>$i</th>";
                }
                echo "</tr>";
                
                // Table body
                for ($i = $startNum; $i <= $endNum; $i++) {
                    echo "<tr>";
                    echo "<th>$i</th>"; // Row header
                    
                    for ($j = $startNum; $j <= $endNum; $j++) {
                        // Calculate division result
                        $result = $i / $j;
                        
                        // Format result based on precision
                        $formattedResult = number_format($result, $precision);
                        
                        // Add special styling for different cases
                        if ($j == 0) {
                            echo "<td style='background-color: #f8d7da;'>Undefined</td>";
                        } elseif ($i == $j) {
                            echo "<td style='background-color: #d4edda;'>$formattedResult</td>";
                        } elseif ($i % $j == 0) {
                            echo "<td style='background-color: #cce5ff;'>$formattedResult</td>";
                        } else {
                            echo "<td>$formattedResult</td>";
                        }
                    }
                    
                    echo "</tr>";
                }
                
                echo "</table>";
                
                // Add a legend
                echo "<div class='legend'>";
                echo "<div class='legend-item'><span class='legend-color' style='background-color: #d4edda;'></span> Equal numbers (n ÷ n = 1)</div>";
                echo "<div class='legend-item'><span class='legend-color' style='background-color: #cce5ff;'></span> Divisible without remainder</div>";
                echo "</div>";
                
                // Add code explanation
                echo "<div class='info-box'>";
                echo "<h3>How this works:</h3>";
                echo "<p>This program generates a division table using nested <code>for</code> loops in PHP:</p>";
                echo "<pre style='background:#f8f9fa;padding:10px;overflow:auto'>";
                echo htmlspecialchars("// Table header
echo \"<tr><th>÷</th>\";
for (\$i = \$startNum; \$i <= \$endNum; \$i++) {
    echo \"<th>\$i</th>\";
}
echo \"</tr>\";

// Table body
for (\$i = \$startNum; \$i <= \$endNum; \$i++) {
    echo \"<tr>\";
    echo \"<th>\$i</th>\"; // Row header
    
    for (\$j = \$startNum; \$j <= \$endNum; \$j++) {
        // Calculate division result
        \$result = \$i / \$j;
        
        // Format result based on precision
        \$formattedResult = number_format(\$result, \$precision);
        
        // Output the result
        echo \"<td>\$formattedResult</td>\";
    }
    
    echo \"</tr>\";
}");
                echo "</pre>";
                echo "</div>";
            }
        }
        ?>
    </div>
</body>
</html>
