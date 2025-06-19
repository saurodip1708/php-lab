<!DOCTYPE html>
<html>
<head>
    <title>Vowel Counter</title>
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
            max-width: 700px;
        }
        textarea {
            padding: 10px;
            width: 90%;
            height: 100px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: Arial, sans-serif;
            resize: vertical;
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
            text-align: left;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #4a6fa5;
            color: white;
        }
        .vowel-highlight {
            padding: 10px;
            margin-top: 20px;
            background-color: #e9ecef;
            border-radius: 5px;
        }
        .a-vowel { color: #e63946; }
        .e-vowel { color: #06d6a0; }
        .i-vowel { color: #118ab2; }
        .o-vowel { color: #ffd166; }
        .u-vowel { color: #7209b7; }
        .vowel-count {
            font-size: 24px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Vowel Counter</h1>
        
        <?php
        // Function to count vowels
        function countVowels($str) {
            // Convert string to lowercase for easier checking
            $str = strtolower($str);
            
            // Initialize vowel counts
            $vowels = ['a' => 0, 'e' => 0, 'i' => 0, 'o' => 0, 'u' => 0];
            
            // Count each vowel
            for ($i = 0; $i < strlen($str); $i++) {
                $char = $str[$i];
                if (array_key_exists($char, $vowels)) {
                    $vowels[$char]++;
                }
            }
            
            // Calculate total vowels
            $total = array_sum($vowels);
            
            return [
                'vowels' => $vowels,
                'total' => $total
            ];
        }
        
        // Function to highlight vowels in text
        function highlightVowels($str) {
            // Create an array of replacement patterns and their corresponding HTML
            $patterns = [
                '/a/i' => '<span class="a-vowel">a</span>',
                '/e/i' => '<span class="e-vowel">e</span>',
                '/i/i' => '<span class="i-vowel">i</span>',
                '/o/i' => '<span class="o-vowel">o</span>',
                '/u/i' => '<span class="u-vowel">u</span>',
                '/A/i' => '<span class="a-vowel">A</span>',
                '/E/i' => '<span class="e-vowel">E</span>',
                '/I/i' => '<span class="i-vowel">I</span>',
                '/O/i' => '<span class="o-vowel">O</span>',
                '/U/i' => '<span class="u-vowel">U</span>'
            ];
            
            // Apply the replacements
            return preg_replace(array_keys($patterns), array_values($patterns), $str);
        }
        
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get string from the form
            $input_string = $_POST["input_string"];
            
            // Count vowels
            $result = countVowels($input_string);
            
            // Display results
            echo "<div class='result'>";
            echo "<h2>Analysis Results:</h2>";
            
            // Display total vowel count
            echo "<p>Input text length: <strong>" . strlen($input_string) . "</strong> characters</p>";
            echo "<p>Total vowels found: <span class='vowel-count'>" . $result['total'] . "</span></p>";
            
            // Display vowel distribution in a table
            echo "<h3>Vowel Distribution:</h3>";
            echo "<table>";
            echo "<tr><th>Vowel</th><th>Count</th><th>Percentage</th></tr>";
            
            foreach ($result['vowels'] as $vowel => $count) {
                $percentage = ($result['total'] > 0) ? round(($count / $result['total']) * 100, 1) : 0;
                $vowelClass = $vowel . "-vowel";
                
                echo "<tr>";
                echo "<td><span class='$vowelClass'>" . strtoupper($vowel) . "</span></td>";
                echo "<td>$count</td>";
                echo "<td>$percentage%</td>";
                echo "</tr>";
            }
            
            echo "</table>";
            
            // Display the highlighted text
            echo "<h3>Highlighted Vowels:</h3>";
            echo "<div class='vowel-highlight'>";
            echo highlightVowels(htmlspecialchars($input_string));
            echo "</div>";
            
            echo "</div>";
        }
        ?>
        
        <!-- HTML form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <p>
                <label for="input_string">Enter a String:</label><br>
                <textarea id="input_string" name="input_string" required placeholder="Type or paste your text here..."></textarea>
            </p>
            <p>
                <input type="submit" value="Count Vowels">
            </p>
        </form>
        
        <div style="margin-top: 20px; font-size: 14px; color: #666;">
            This tool counts and highlights the vowels (a, e, i, o, u) in your text,
            showing the total number and distribution of each vowel.
        </div>
    </div>
</body>
</html>
