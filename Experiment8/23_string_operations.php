<!DOCTYPE html>
<html>
<head>
    <title>String Operations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            text-align: center;
            background-color: #f0f0f0;
        }
        h1, h2 {
            color: #4a6fa5;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            display: inline-block;
            min-width: 600px;
            max-width: 900px;
            text-align: left;
        }
        .operation-result {
            margin: 25px 0;
            padding: 20px;
            background-color: #e9ecef;
            border-radius: 5px;
            border-left: 5px solid #4a6fa5;
        }
        pre {
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
        }
        code {
            font-family: 'Courier New', Courier, monospace;
            color: #333;
        }
        .function-name {
            font-weight: bold;
            color: #4a6fa5;
        }
        .string-result {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
            margin: 10px 0;
            word-wrap: break-word;
        }
        .string-comparison {
            display: flex;
            align-items: stretch;
            margin: 10px 0;
        }
        .string-box {
            flex: 1;
            padding: 10px;
            margin: 0 5px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
        .string-box-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #4a6fa5;
        }
        .highlight {
            background-color: #ffeeba;
            padding: 2px 4px;
            border-radius: 3px;
        }
        form {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        input[type="text"] {
            padding: 8px;
            width: 300px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="number"] {
            padding: 8px;
            width: 60px;
            margin: 5px 0;
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
        .input-row {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PHP String Operations</h1>
        
        <?php
        // Create a string with the given value
        $originalString = "php Program - the complete SOLUTION for WEB development";
        
        // Function to display string in a nice format
        function displayString($str, $title = "String") {
            echo "<div class='string-result'>";
            echo "<div class='string-box-title'>$title:</div>";
            echo $str;
            echo "</div>";
        }
        
        // Display the original string
        echo "<div class='operation-result'>";
        echo "<h2>1. Original String</h2>";
        displayString($originalString, "Original String");
        echo "<pre><code>// Original string creation code:\n\$originalString = \"php Program - the complete SOLUTION for WEB development\";</code></pre>";
        echo "</div>";
        
        // Convert lowercase string to uppercase
        echo "<div class='operation-result'>";
        echo "<h2>2. Convert to Uppercase</h2>";
        echo "<p>Using <span class='function-name'>strtoupper()</span> function to convert the string to uppercase:</p>";
        
        $uppercaseString = strtoupper($originalString);
        
        echo "<pre><code>// Uppercase conversion:\n\$uppercaseString = strtoupper(\$originalString);</code></pre>";
        
        echo "<div class='string-comparison'>";
        echo "<div class='string-box'><div class='string-box-title'>Original:</div>$originalString</div>";
        echo "<div class='string-box'><div class='string-box-title'>Uppercase:</div>$uppercaseString</div>";
        echo "</div>";
        echo "</div>";
        
        // Convert uppercase string to lowercase
        echo "<div class='operation-result'>";
        echo "<h2>3. Convert to Lowercase</h2>";
        echo "<p>Using <span class='function-name'>strtolower()</span> function to convert the string to lowercase:</p>";
        
        $lowercaseString = strtolower($originalString);
        
        echo "<pre><code>// Lowercase conversion:\n\$lowercaseString = strtolower(\$originalString);</code></pre>";
        
        echo "<div class='string-comparison'>";
        echo "<div class='string-box'><div class='string-box-title'>Original:</div>$originalString</div>";
        echo "<div class='string-box'><div class='string-box-title'>Lowercase:</div>$lowercaseString</div>";
        echo "</div>";
        echo "</div>";
        
        // Convert first character to uppercase
        echo "<div class='operation-result'>";
        echo "<h2>4. Convert First Character to Uppercase</h2>";
        echo "<p>Using <span class='function-name'>ucfirst()</span> function to capitalize the first character:</p>";
        
        $ucfirstString = ucfirst($originalString);
        
        echo "<pre><code>// First character to uppercase:\n\$ucfirstString = ucfirst(\$originalString);</code></pre>";
        
        echo "<div class='string-comparison'>";
        echo "<div class='string-box'><div class='string-box-title'>Original:</div>$originalString</div>";
        echo "<div class='string-box'><div class='string-box-title'>First Character Uppercase:</div>$ucfirstString</div>";
        echo "</div>";
        echo "</div>";
        
        // Convert first character of each word to uppercase
        echo "<div class='operation-result'>";
        echo "<h2>5. Convert First Character of Each Word to Uppercase</h2>";
        echo "<p>Using <span class='function-name'>ucwords()</span> function to capitalize the first character of each word:</p>";
        
        $ucwordsString = ucwords($originalString);
        
        echo "<pre><code>// First character of each word to uppercase:\n\$ucwordsString = ucwords(\$originalString);</code></pre>";
        
        echo "<div class='string-comparison'>";
        echo "<div class='string-box'><div class='string-box-title'>Original:</div>$originalString</div>";
        echo "<div class='string-box'><div class='string-box-title'>First Character of Each Word Uppercase:</div>$ucwordsString</div>";
        echo "</div>";
        echo "</div>";
        
        // Get the last 11 characters of the string
        echo "<div class='operation-result'>";
        echo "<h2>6. Get the Last 11 Characters</h2>";
        echo "<p>Using <span class='function-name'>substr()</span> function to extract the last 11 characters:</p>";
        
        $last11Chars = substr($originalString, -11);
        
        echo "<pre><code>// Last 11 characters:\n\$last11Chars = substr(\$originalString, -11);</code></pre>";
        
        echo "<div class='string-result'>";
        echo "<div class='string-box-title'>Last 11 Characters:</div>";
        echo "'$last11Chars'";
        echo "</div>";
        
        // Highlight the characters in the original string
        $highlightedString = substr($originalString, 0, strlen($originalString) - 11) . 
                             "<span class='highlight'>" . $last11Chars . "</span>";
        
        echo "<div class='string-result'>";
        echo "<div class='string-box-title'>Original with Last 11 Characters Highlighted:</div>";
        echo $highlightedString;
        echo "</div>";
        echo "</div>";
        
        // Replace the first 'the' with 'best'
        echo "<div class='operation-result'>";
        echo "<h2>7. Replace First 'the' with 'best'</h2>";
        echo "<p>Using <span class='function-name'>str_replace()</span> function (with a limit) to replace only the first occurrence:</p>";
        
        // To replace just the first occurrence, we'll use preg_replace with a limit
        $replacedString = preg_replace('/the/', 'best', $originalString, 1);
        
        echo "<pre><code>// Replace first 'the' with 'best':\n\$replacedString = preg_replace('/the/', 'best', \$originalString, 1);</code></pre>";
        
        // Highlight the change
        $originalHighlighted = str_replace("the", "<span class='highlight'>the</span>", $originalString, $count = 1);
        $replacedHighlighted = str_replace("best", "<span class='highlight'>best</span>", $replacedString, $count = 1);
        
        echo "<div class='string-comparison'>";
        echo "<div class='string-box'><div class='string-box-title'>Original:</div>$originalHighlighted</div>";
        echo "<div class='string-box'><div class='string-box-title'>Replaced:</div>$replacedHighlighted</div>";
        echo "</div>";
        echo "</div>";
        
        // Get the second word of a sentence
        echo "<div class='operation-result'>";
        echo "<h2>8. Get the Second Word</h2>";
        echo "<p>Using <span class='function-name'>explode()</span> function to split the string and get the second word:</p>";
        
        // Split the string into words
        $words = explode(" ", $originalString);
        $secondWord = isset($words[1]) ? $words[1] : "N/A";
        
        echo "<pre><code>// Get second word:\n\$words = explode(\" \", \$originalString);\n\$secondWord = \$words[1];</code></pre>";
        
        echo "<div class='string-result'>";
        echo "<div class='string-box-title'>Second Word:</div>";
        echo "'$secondWord'";
        echo "</div>";
        
        // Highlight the second word in the original string
        $originalWithSecondWordHighlighted = $originalString;
        if (isset($words[1])) {
            $pos = strpos($originalString, $words[1]);
            $originalWithSecondWordHighlighted = substr($originalString, 0, $pos) . 
                                                 "<span class='highlight'>" . $words[1] . "</span>" . 
                                                 substr($originalString, $pos + strlen($words[1]));
        }
        
        echo "<div class='string-result'>";
        echo "<div class='string-box-title'>Original with Second Word Highlighted:</div>";
        echo $originalWithSecondWordHighlighted;
        echo "</div>";
        echo "</div>";
        
        // Initialize variables for form data
        $position = "";
        $insertString = "";
        $insertResult = "";
        
        // Process form submission for insertion
        if (isset($_POST['insert'])) {
            $position = $_POST['position'];
            $insertString = $_POST['insert_string'];
            
            // Insert string at specified position
            $insertResult = substr($originalString, 0, $position) . $insertString . substr($originalString, $position);
        }
        
        // Insert a string at the specified position
        echo "<div class='operation-result'>";
        echo "<h2>9. Insert a String at Specified Position</h2>";
        echo "<p>Using <span class='function-name'>substr()</span> function to insert a string at a specific position:</p>";
        
        echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
        echo "<div class='input-row'>";
        echo "<label for='position'>Position to insert:</label><br>";
        echo "<input type='number' id='position' name='position' min='0' max='" . strlen($originalString) . "' required value='$position'>";
        echo "</div>";
        echo "<div class='input-row'>";
        echo "<label for='insert_string'>String to insert:</label><br>";
        echo "<input type='text' id='insert_string' name='insert_string' required value='$insertString'>";
        echo "</div>";
        echo "<input type='submit' name='insert' value='Insert String'>";
        echo "</form>";
        
        if (!empty($insertResult)) {
            echo "<pre><code>// Insertion code:\n\$insertResult = substr(\$originalString, 0, $position) . \"$insertString\" . substr(\$originalString, $position);</code></pre>";
            
            // Show the insertion with highlight
            $highlightedInsertResult = substr($originalString, 0, $position) . 
                                     "<span class='highlight'>$insertString</span>" . 
                                     substr($originalString, $position);
            
            echo "<div class='string-comparison'>";
            echo "<div class='string-box'><div class='string-box-title'>Original:</div>$originalString</div>";
            echo "<div class='string-box'><div class='string-box-title'>After Insertion:</div>$highlightedInsertResult</div>";
            echo "</div>";
        }
        echo "</div>";
        
        // Additional string function examples
        echo "<div class='operation-result'>";
        echo "<h2>Additional String Functions</h2>";
        
        // String length
        echo "<h3>String Length:</h3>";
        echo "<pre><code>// Get string length:\nstrlen(\$originalString); // Result: " . strlen($originalString) . "</code></pre>";
        
        // Word count
        echo "<h3>Word Count:</h3>";
        echo "<pre><code>// Count words in the string:\nstr_word_count(\$originalString); // Result: " . str_word_count($originalString) . "</code></pre>";
        
        // String position
        $posWeb = strpos($originalString, "WEB");
        echo "<h3>Find Position of a Substring:</h3>";
        echo "<pre><code>// Find position of 'WEB':\nstrpos(\$originalString, \"WEB\"); // Result: $posWeb</code></pre>";
        
        // String reverse
        echo "<h3>Reverse String:</h3>";
        $reversedString = strrev($originalString);
        echo "<pre><code>// Reverse the string:\nstrrev(\$originalString);</code></pre>";
        
        echo "<div class='string-comparison'>";
        echo "<div class='string-box'><div class='string-box-title'>Original:</div>$originalString</div>";
        echo "<div class='string-box'><div class='string-box-title'>Reversed:</div>$reversedString</div>";
        echo "</div>";
        
        echo "</div>";
        ?>
        
    </div>
</body>
</html>
