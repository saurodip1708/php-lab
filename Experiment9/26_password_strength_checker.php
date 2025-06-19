<!DOCTYPE html>
<html>
<head>
    <title>Password Strength Checker</title>
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
        .section {
            margin: 25px 0;
            padding: 20px;
            background-color: #e9ecef;
            border-radius: 5px;
            border-left: 5px solid #4a6fa5;
        }
        .example {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
            margin: 10px 0;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .result {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            font-weight: bold;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }
        form {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        input[type="text"], input[type="password"] {
            padding: 8px;
            width: 300px;
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
        .note {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }
        .strength-meter {
            height: 10px;
            width: 300px;
            background-color: #e9ecef;
            margin: 10px 0;
            border-radius: 5px;
            position: relative;
        }
        .strength-meter div {
            height: 100%;
            border-radius: 5px;
            transition: width 0.5s;
        }
        .very-weak {
            background-color: #dc3545;
            width: 20%;
        }
        .weak {
            background-color: #f0ad4e;
            width: 40%;
        }
        .medium {
            background-color: #ffc107;
            width: 60%;
        }
        .strong {
            background-color: #28a745;
            width: 80%;
        }
        .very-strong {
            background-color: #20c997;
            width: 100%;
        }
        .highlight {
            background-color: #ffeeba;
            padding: 2px 4px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PHP Password Strength Checker</h1>
        
        <div class="section">
            <h2>Check Password Strength</h2>
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div>
                    <label for="password">Enter Password:</label><br>
                    <input type="password" id="password" name="password" 
                           value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>" required>
                </div>
                <input type="submit" name="check-strength" value="Check Strength">
            </form>
            
            <?php
            function getPasswordStrength($password) {
                // Initialize score
                $score = 0;
                
                // Store feedback messages
                $feedback = [];
                
                // 1. Check length
                $length = strlen($password);
                if ($length < 6) {
                    $feedback[] = "Password is too short (minimum 6 characters)";
                } elseif ($length >= 12) {
                    $score += 2;
                    $feedback[] = "Good password length";
                } else {
                    $score += 1;
                    $feedback[] = "Consider a longer password (12+ characters)";
                }
                
                // 2. Check for lowercase letters
                if (preg_match('/[a-z]/', $password)) {
                    $score += 1;
                    $feedback[] = "Contains lowercase letters";
                } else {
                    $feedback[] = "Add lowercase letters";
                }
                
                // 3. Check for uppercase letters
                if (preg_match('/[A-Z]/', $password)) {
                    $score += 1;
                    $feedback[] = "Contains uppercase letters";
                } else {
                    $feedback[] = "Add uppercase letters";
                }
                
                // 4. Check for numbers
                if (preg_match('/[0-9]/', $password)) {
                    $score += 1;
                    $feedback[] = "Contains numbers";
                } else {
                    $feedback[] = "Add numbers";
                }
                
                // 5. Check for special characters
                if (preg_match('/[^a-zA-Z0-9]/', $password)) {
                    $score += 1;
                    $feedback[] = "Contains special characters";
                } else {
                    $feedback[] = "Add special characters (!@#$%^&*)";
                }
                
                // 6. Check for repeated characters
                if (preg_match('/(.)\1\1/', $password)) {
                    $feedback[] = "Avoid repeating characters (e.g., 'aaa', '111')";
                    $score -= 1;
                }
                
                // 7. Check for sequential characters
                if (preg_match('/(abc|bcd|cde|def|efg|fgh|ghi|hij|ijk|jkl|klm|lmn|mno|nop|opq|pqr|qrs|rst|stu|tuv|uvw|vwx|wxy|xyz|012|123|234|345|456|567|678|789)/i', $password)) {
                    $feedback[] = "Avoid sequential characters (e.g., 'abc', '123')";
                    $score -= 1;
                }
                
                // 8. Check for common passwords (simplified)
                $commonPasswords = [
                    'password', '123456', 'qwerty', 'admin', 'welcome',
                    'letmein', 'monkey', '1234', 'football', 'iloveyou'
                ];
                
                if (in_array(strtolower($password), $commonPasswords)) {
                    $feedback[] = "This is a commonly used password";
                    $score = 0;
                }
                
                // Ensure score is within range
                $score = max(0, min($score, 5));
                
                // Determine strength level
                $strengthLevels = [
                    0 => ['very-weak', 'Very Weak'],
                    1 => ['very-weak', 'Very Weak'],
                    2 => ['weak', 'Weak'],
                    3 => ['medium', 'Medium'],
                    4 => ['strong', 'Strong'],
                    5 => ['very-strong', 'Very Strong']
                ];
                
                return [
                    'score' => $score,
                    'strength' => $strengthLevels[$score][1],
                    'class' => $strengthLevels[$score][0],
                    'feedback' => $feedback
                ];
            }
            
            if (isset($_POST['check-strength'])) {
                $password = $_POST['password'];
                $result = getPasswordStrength($password);
                
                echo "<div class='example'>";
                echo "<h3>Password Strength Analysis</h3>";
                
                echo "<div class='strength-meter'>";
                echo "<div class='" . $result['class'] . "'></div>";
                echo "</div>";
                
                echo "<p><strong>Strength:</strong> " . $result['strength'] . " (Score: " . $result['score'] . "/5)</p>";
                
                echo "<h4>Feedback:</h4>";
                echo "<ul>";
                foreach ($result['feedback'] as $item) {
                    echo "<li>" . $item . "</li>";
                }
                echo "</ul>";
                
                // Display the password analysis
                echo "<h4>Character Analysis:</h4>";
                echo "<table>";
                echo "<tr><th>Category</th><th>Count</th></tr>";
                
                $length = strlen($password);
                $lowercase = preg_match_all('/[a-z]/', $password);
                $uppercase = preg_match_all('/[A-Z]/', $password);
                $numbers = preg_match_all('/[0-9]/', $password);
                $special = preg_match_all('/[^a-zA-Z0-9]/', $password);
                
                echo "<tr><td>Total length</td><td>$length</td></tr>";
                echo "<tr><td>Lowercase letters</td><td>$lowercase</td></tr>";
                echo "<tr><td>Uppercase letters</td><td>$uppercase</td></tr>";
                echo "<tr><td>Numbers</td><td>$numbers</td></tr>";
                echo "<tr><td>Special characters</td><td>$special</td></tr>";
                
                echo "</table>";
                
                echo "</div>";
                
                // Show the code used
                echo "<h3>PHP Code Used for Strength Calculation:</h3>";
                echo "<pre><code>function getPasswordStrength(\$password) {
    \$score = 0;
    \$feedback = [];
    
    // Check length
    \$length = strlen(\$password);
    if (\$length < 6) {
        \$feedback[] = \"Password is too short\";
    } elseif (\$length >= 12) {
        \$score += 2;
    } else {
        \$score += 1;
    }
    
    // Check for lowercase, uppercase, numbers, special chars
    if (preg_match('/[a-z]/', \$password)) \$score += 1;
    if (preg_match('/[A-Z]/', \$password)) \$score += 1;
    if (preg_match('/[0-9]/', \$password)) \$score += 1;
    if (preg_match('/[^a-zA-Z0-9]/', \$password)) \$score += 1;
    
    // Check for repeated and sequential characters
    if (preg_match('/(.)\1\1/', \$password)) \$score -= 1;
    if (preg_match('/(abc|123)/', \$password)) \$score -= 1;
    
    // Final score between 0-5
    \$score = max(0, min(\$score, 5));
    
    return [
        'score' => \$score,
        'strength' => \$strengthLevels[\$score][1]
    ];
}</code></pre>";
            }
            ?>
        </div>
        
        <div class="section">
            <h2>Password Security Best Practices</h2>
            
            <div class="example">
                <h3>How to Create Strong Passwords:</h3>
                <ol>
                    <li><strong>Length:</strong> Use at least 12 characters</li>
                    <li><strong>Complexity:</strong> Include a mix of:
                        <ul>
                            <li>Uppercase letters (A-Z)</li>
                            <li>Lowercase letters (a-z)</li>
                            <li>Numbers (0-9)</li>
                            <li>Special characters (!@#$%^&*)</li>
                        </ul>
                    </li>
                    <li><strong>Avoid:</strong>
                        <ul>
                            <li>Personal information (names, birthdays)</li>
                            <li>Dictionary words</li>
                            <li>Common substitutions (e.g., "p@ssw0rd")</li>
                            <li>Sequential characters (abc, 123)</li>
                            <li>Repeated characters (aaa, 111)</li>
                        </ul>
                    </li>
                    <li><strong>Use:</strong>
                        <ul>
                            <li>Passphrases (multiple random words)</li>
                            <li>Different passwords for different accounts</li>
                            <li>Password managers to generate and store complex passwords</li>
                        </ul>
                    </li>
                </ol>
            </div>
            
            <div class="example">
                <h3>PHP Password Hashing</h3>
                <p>For storing passwords securely in a database, always use PHP's built-in password hashing functions:</p>
                
                <pre><code>// Hash a password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Verify a password
$isValid = password_verify($password, $hashedPassword);</code></pre>
                
                <p>Never store plain text passwords in a database!</p>
            </div>
        </div>
    </div>
</body>
</html>
