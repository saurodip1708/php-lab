<!DOCTYPE html>
<html>
<head>
    <title>String Palindrome Checker</title>
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
        input[type="text"] {
            padding: 10px;
            width: 80%;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4a6fa5;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
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
        .palindrome {
            background-color: #d4edda;
            color: #155724;
        }
        .not-palindrome {
            background-color: #f8d7da;
            color: #721c24;
        }
        .steps {
            margin-top: 20px;
            text-align: left;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        .options {
            margin-top: 20px;
            padding: 10px;
            border-top: 1px solid #ddd;
            text-align: left;
        }
        label {
            display: inline-block;
            margin-right: 20px;
        }
        .examples {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
            text-align: left;
        }
        .example-item {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>String Palindrome Checker</h1>
        
        <?php
        // Function to check if a string is palindrome
        function isPalindrome($str, $ignoreCase = true, $ignoreSpaces = true, $ignoreSpecialChars = true) {
            // Process the string based on selected options
            if ($ignoreCase) {
                $str = strtolower($str);
            }
            
            if ($ignoreSpaces) {
                $str = str_replace(' ', '', $str);
            }
            
            if ($ignoreSpecialChars) {
                // Remove anything that's not a letter or number
                $str = preg_replace('/[^a-zA-Z0-9]/', '', $str);
            }
            
            // Get the reversed string
            $reversed = strrev($str);
            
            // Check if original and reversed are same
            return $str === $reversed;
        }
        
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the string from the form
            $input_string = $_POST["input_string"];
            $original_string = $input_string;
            
            // Get options
            $ignoreCase = isset($_POST["ignore_case"]);
            $ignoreSpaces = isset($_POST["ignore_spaces"]);
            $ignoreSpecialChars = isset($_POST["ignore_special"]);
            
            // Check if string is palindrome
            $isPalindrome = isPalindrome($input_string, $ignoreCase, $ignoreSpaces, $ignoreSpecialChars);
            
            // Process steps for display
            $steps = array();
            $current = $original_string;
            
            if ($ignoreCase) {
                $lower = strtolower($current);
                $steps[] = array(
                    'operation' => 'Converted to lowercase',
                    'result' => $lower
                );
                $current = $lower;
            }
            
            if ($ignoreSpaces) {
                $noSpaces = str_replace(' ', '', $current);
                $steps[] = array(
                    'operation' => 'Removed spaces',
                    'result' => $noSpaces
                );
                $current = $noSpaces;
            }
            
            if ($ignoreSpecialChars) {
                $alphanumeric = preg_replace('/[^a-zA-Z0-9]/', '', $current);
                $steps[] = array(
                    'operation' => 'Removed special characters',
                    'result' => $alphanumeric
                );
                $current = $alphanumeric;
            }
            
            $reversed = strrev($current);
            $steps[] = array(
                'operation' => 'Reversed the string',
                'result' => $reversed
            );
            
            // Display result
            if ($isPalindrome) {
                echo "<div class='result palindrome'><strong>\"$original_string\" is a Palindrome!</strong></div>";
            } else {
                echo "<div class='result not-palindrome'><strong>\"$original_string\" is NOT a Palindrome.</strong></div>";
            }
            
            // Show the verification process
            echo "<div class='steps'>";
            echo "<h3>Verification Process:</h3>";
            echo "<ol>";
            echo "<li>Original string: \"$original_string\"</li>";
            
            foreach ($steps as $step) {
                echo "<li>{$step['operation']}: \"{$step['result']}\"</li>";
            }
            
            echo "<li>Comparison: " . ($isPalindrome ? 
                    "Both strings are identical, so it's a palindrome." : 
                    "The strings are different, so it's not a palindrome.") . "</li>";
            echo "</ol>";
            echo "</div>";
        }
        ?>
        
        <!-- HTML form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <p>
                <label for="input_string">Enter a String:</label><br>
                <input type="text" id="input_string" name="input_string" required>
            </p>
            
            <div class="options">
                <h3>Options:</h3>
                <label>
                    <input type="checkbox" id="ignore_case" name="ignore_case" checked> 
                    Ignore Case (A = a)
                </label>
                <label>
                    <input type="checkbox" id="ignore_spaces" name="ignore_spaces" checked> 
                    Ignore Spaces
                </label>
                <label>
                    <input type="checkbox" id="ignore_special" name="ignore_special" checked> 
                    Ignore Special Characters
                </label>
            </div>
            
            <p>
                <input type="submit" value="Check Palindrome">
            </p>
        </form>
        
        <div class="examples">
            <h3>Examples of Palindromes:</h3>
            <div class="example-item">- "racecar" (simple palindrome)</div>
            <div class="example-item">- "A man, a plan, a canal, Panama" (with spaces and punctuation)</div>
            <div class="example-item">- "Madam, I'm Adam" (with mixed case, spaces and punctuation)</div>
            <div class="example-item">- "No lemon, no melon" (phrase palindrome)</div>
        </div>
    </div>
</body>
</html>
