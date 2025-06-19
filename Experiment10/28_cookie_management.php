<!DOCTYPE html>
<html>
<head>
    <title>Cookie Management</title>
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
        input[type="text"], input[type="number"] {
            padding: 8px;
            width: 300px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"], button {
            padding: 8px 20px;
            background-color: #4a6fa5;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            margin-right: 5px;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #3a5982;
        }
        .note {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }
        .highlight {
            background-color: #ffeeba;
            padding: 2px 4px;
            border-radius: 3px;
        }
        .cookie-item {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .cookie-item button {
            margin-top: 0;
        }
        .cookie-value {
            font-family: 'Courier New', Courier, monospace;
            background-color: #f5f5f5;
            padding: 3px 6px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <?php
    // Process cookie operations
    if (isset($_POST['set_cookie'])) {
        $name = isset($_POST['cookie_name']) ? trim($_POST['cookie_name']) : '';
        $value = isset($_POST['cookie_value']) ? trim($_POST['cookie_value']) : '';
        $expiry = isset($_POST['cookie_expiry']) ? (int)$_POST['cookie_expiry'] : 30;
        
        if (!empty($name)) {
            // Set the cookie
            setcookie($name, $value, time() + ($expiry * 60), "/");
            // Refresh the page to see the new cookie
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        }
    }
    
    if (isset($_POST['delete_cookie'])) {
        $name = $_POST['cookie_name'];
        // Delete cookie by setting expiration to past time
        if (isset($_COOKIE[$name])) {
            setcookie($name, "", time() - 3600, "/");
            // Refresh the page
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        }
    }
    
    if (isset($_POST['clear_all_cookies'])) {
        // Delete all cookies
        foreach ($_COOKIE as $key => $value) {
            setcookie($key, "", time() - 3600, "/");
        }
        // Refresh the page
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
    ?>

    <div class="container">
        <h1>PHP Cookie Management</h1>
        
        <div class="section">
            <h2>Current Cookies</h2>
            
            <?php
            if (empty($_COOKIE)) {
                echo "<p>No cookies are currently set.</p>";
            } else {
                echo "<div class='example'>";
                foreach ($_COOKIE as $name => $value) {
                    echo "<div class='cookie-item'>";
                    echo "<div>";
                    echo "<strong>Name:</strong> " . htmlspecialchars($name) . "<br>";
                    echo "<strong>Value:</strong> <span class='cookie-value'>" . htmlspecialchars($value) . "</span>";
                    echo "</div>";
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='cookie_name' value='" . htmlspecialchars($name) . "'>";
                    echo "<button type='submit' name='delete_cookie'>Delete</button>";
                    echo "</form>";
                    echo "</div>";
                }
                echo "</div>";
                
                // Button to clear all cookies
                echo "<form method='post' action=''>";
                echo "<button type='submit' name='clear_all_cookies' style='background-color: #dc3545;'>Clear All Cookies</button>";
                echo "</form>";
            }
            ?>
        </div>
        
        <div class="section">
            <h2>Set a Cookie</h2>
            
            <form method="post" action="">
                <div>
                    <label for="cookie_name">Cookie Name:</label><br>
                    <input type="text" id="cookie_name" name="cookie_name" required>
                </div>
                <div>
                    <label for="cookie_value">Cookie Value:</label><br>
                    <input type="text" id="cookie_value" name="cookie_value">
                </div>
                <div>
                    <label for="cookie_expiry">Expiry Time (minutes):</label><br>
                    <input type="number" id="cookie_expiry" name="cookie_expiry" min="1" value="30">
                    <p class="note">Default: 30 minutes</p>
                </div>
                <input type="submit" name="set_cookie" value="Set Cookie">
            </form>
        </div>
        
        <div class="section">
            <h2>How Cookies Work</h2>
            
            <div class="example">
                <h3>Basic Cookie Syntax:</h3>
                <pre><code>// Set a cookie
setcookie(name, value, expire, path, domain, secure, httponly);

// Required parameters:
// - name: The name of the cookie
// - value: The value of the cookie

// Optional parameters:
// - expire: The time the cookie expires (Unix timestamp)
// - path: The path on the server where the cookie will be available
// - domain: The domain that the cookie is available to
// - secure: Cookie should only be transmitted over HTTPS
// - httponly: Cookie will be accessible only through HTTP protocol</code></pre>
            </div>
            
            <div class="example">
                <h3>Cookie Operations:</h3>
                <table>
                    <tr>
                        <th>Operation</th>
                        <th>Code</th>
                    </tr>
                    <tr>
                        <td>Set a cookie</td>
                        <td><code>setcookie("user", "John", time() + 3600, "/");</code></td>
                    </tr>
                    <tr>
                        <td>Access a cookie</td>
                        <td><code>$user = $_COOKIE["user"];</code></td>
                    </tr>
                    <tr>
                        <td>Check if cookie exists</td>
                        <td><code>if(isset($_COOKIE["user"])) { ... }</code></td>
                    </tr>
                    <tr>
                        <td>Delete a cookie</td>
                        <td><code>setcookie("user", "", time() - 3600, "/");</code></td>
                    </tr>
                </table>
            </div>
            
            <div class="example">
                <h3>Cookies vs. Sessions:</h3>
                <table>
                    <tr>
                        <th>Feature</th>
                        <th>Cookies</th>
                        <th>Sessions</th>
                    </tr>
                    <tr>
                        <td>Storage Location</td>
                        <td>Client's browser</td>
                        <td>Server</td>
                    </tr>
                    <tr>
                        <td>Security</td>
                        <td>Less secure</td>
                        <td>More secure</td>
                    </tr>
                    <tr>
                        <td>Lifespan</td>
                        <td>Set by expiration time</td>
                        <td>Ends when browser closes or timeout</td>
                    </tr>
                    <tr>
                        <td>Data Size</td>
                        <td>Limited (~4KB)</td>
                        <td>Larger capacity</td>
                    </tr>
                    <tr>
                        <td>Accessibility</td>
                        <td>Client-side JavaScript can access (unless HttpOnly)</td>
                        <td>Only server-side code can access</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="section">
            <h2>Cookie Use Cases</h2>
            
            <div class="example">
                <h3>Common Uses of Cookies:</h3>
                <ul>
                    <li><strong>User Authentication</strong>: Remember login status</li>
                    <li><strong>User Preferences</strong>: Store site preferences like theme, language</li>
                    <li><strong>Shopping Carts</strong>: Store items in a shopping cart</li>
                    <li><strong>Tracking</strong>: Analytics and user behavior tracking</li>
                    <li><strong>Personalization</strong>: Customize content for users</li>
                </ul>
            </div>
            
            <div class="example">
                <h3>Cookie Best Practices:</h3>
                <ul>
                    <li>Don't store sensitive information in cookies</li>
                    <li>Use secure flag for HTTPS sites</li>
                    <li>Use HttpOnly flag to prevent JavaScript access</li>
                    <li>Set appropriate expiration times</li>
                    <li>Comply with privacy regulations like GDPR/Cookie Law</li>
                    <li>Inform users about cookie usage</li>
                </ul>
            </div>
        </div>
        
        <div class="section">
            <h2>Cookie Demo - User Preferences</h2>
            
            <?php
            // Process theme preference
            if (isset($_POST['set_theme'])) {
                $theme = $_POST['theme'];
                setcookie("theme_preference", $theme, time() + (86400 * 30), "/"); // 30 days
                header("Location: ".$_SERVER['PHP_SELF']);
                exit();
            }
            
            // Get current theme
            $current_theme = isset($_COOKIE['theme_preference']) ? $_COOKIE['theme_preference'] : 'light';
            ?>
            
            <div class="example" style="<?php echo $current_theme == 'dark' ? 'background-color: #343a40; color: #f8f9fa;' : ''; ?>">
                <h3>Theme Preference Example</h3>
                <p>This box changes appearance based on your theme preference cookie.</p>
                <p>Current theme: <strong><?php echo ucfirst($current_theme); ?></strong></p>
                
                <form method="post" action="">
                    <label><input type="radio" name="theme" value="light" <?php echo $current_theme == 'light' ? 'checked' : ''; ?>> Light Theme</label>
                    <label style="margin-left: 20px;"><input type="radio" name="theme" value="dark" <?php echo $current_theme == 'dark' ? 'checked' : ''; ?>> Dark Theme</label>
                    <br><br>
                    <input type="submit" name="set_theme" value="Save Theme Preference">
                </form>
            </div>
            
            <div class="example">
                <h3>Code for Theme Preference:</h3>
                <pre><code>// Set theme cookie
if (isset($_POST['set_theme'])) {
    $theme = $_POST['theme'];
    setcookie("theme_preference", $theme, time() + (86400 * 30), "/");
}

// Get current theme
$current_theme = isset($_COOKIE['theme_preference']) ? $_COOKIE['theme_preference'] : 'light';

// Use theme in your HTML/CSS
echo "&lt;div style=\"" . ($current_theme == 'dark' ? 'background-color: #343a40; color: #f8f9fa;' : '') . "\"&gt;";
echo "Content with theme applied";
echo "&lt;/div&gt;";</code></pre>
            </div>
        </div>
    </div>
</body>
</html>
