<!DOCTYPE html>
<html>
<head>
    <title>Palindrome Number Checker</title>
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
            padding-left: 20px;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Palindrome Number Checker</h1>
        
        <?php
        // Function to check if a number is palindrome
        function isPalindrome($num) {
            // Convert number to string
            $numStr = (string)$num;
            
            // Reverse the string
            $reversedStr = strrev($numStr);
            
            // Check if original and reversed are same
            return $numStr === $reversedStr;
        }
        
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get number from the form
            $number = $_POST["number"];
            $originalNumber = $number;
            
            // Check if number is palindrome
            $isPalindrome = isPalindrome($number);
            
            // Display result
            if ($isPalindrome) {
                echo "<div class='result palindrome'><strong>$originalNumber is a Palindrome Number!</strong></div>";
            } else {
                echo "<div class='result not-palindrome'><strong>$originalNumber is NOT a Palindrome Number.</strong></div>";
            }
            
            // Show the process
            echo "<div class='steps'>";
            echo "<h3>Verification Process:</h3>";
            echo "<ol>";
            echo "<li>Original number: $originalNumber</li>";
            echo "<li>Reversed number: " . strrev((string)$originalNumber) . "</li>";
            echo "<li>Comparison: " . ($isPalindrome ? "Both are equal, so it's a palindrome." : "They are different, so it's not a palindrome.") . "</li>";
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
                <input type="submit" value="Check Palindrome">
            </p>
        </form>
        
        <div style="margin-top: 20px;">
            <small>A palindrome number reads the same backward as forward, e.g., 121, 12321, etc.</small>
        </div>
    </div>
</body>
</html>
