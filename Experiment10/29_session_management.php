<!DOCTYPE html>
<html>
<head>
    <title>PHP Session Management</title>
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
        input[type="text"], input[type="password"], input[type="email"] {
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
        .session-item {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .session-value {
            font-family: 'Courier New', Courier, monospace;
            background-color: #f5f5f5;
            padding: 3px 6px;
            border-radius: 3px;
        }
        .user-info {
            background-color: #e2e3e5;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .cart-total {
            text-align: right;
            font-weight: bold;
            margin-top: 10px;
            padding: 10px;
            border-top: 2px solid #ddd;
        }
    </style>
</head>
<body>
    <?php
    // Start or resume session
    session_start();
    
    // Initialize the cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Process login request
    if (isset($_POST['login'])) {
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        
        // Demo user authentication (in a real app, this would validate against a database)
        if ($username === 'demo' && $password === 'password') {
            $_SESSION['user'] = [
                'username' => $username,
                'email' => 'demo@example.com',
                'name' => 'Demo User',
                'login_time' => date('Y-m-d H:i:s')
            ];
            // Success message to display after redirect
            $_SESSION['message'] = "Login successful! Welcome, Demo User.";
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        } else {
            $error = "Invalid username or password. Try username 'demo' and password 'password'.";
        }
    }
    
    // Process logout request
    if (isset($_POST['logout'])) {
        // Remove user information from session
        unset($_SESSION['user']);
        $_SESSION['message'] = "You have been logged out.";
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
    
    // Process cart operations
    if (isset($_POST['add_to_cart'])) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = (float)$_POST['product_price'];
        
        // Check if the product is already in the cart
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity']++;
        } else {
            $_SESSION['cart'][$product_id] = [
                'name' => $product_name,
                'price' => $product_price,
                'quantity' => 1
            ];
        }
        
        $_SESSION['message'] = "Product added to cart!";
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
    
    // Process cart item removal
    if (isset($_POST['remove_from_cart'])) {
        $product_id = $_POST['product_id'];
        
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
            $_SESSION['message'] = "Item removed from cart!";
        }
        
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
    
    // Clear the entire cart
    if (isset($_POST['clear_cart'])) {
        $_SESSION['cart'] = [];
        $_SESSION['message'] = "Cart has been cleared!";
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
    
    // Set a custom session variable
    if (isset($_POST['set_session'])) {
        $name = trim($_POST['session_name']);
        $value = trim($_POST['session_value']);
        
        if (!empty($name)) {
            $_SESSION[$name] = $value;
            $_SESSION['message'] = "Session variable set!";
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        }
    }
    
    // Remove a session variable
    if (isset($_POST['remove_session'])) {
        $name = $_POST['session_name'];
        
        if (isset($_SESSION[$name])) {
            unset($_SESSION[$name]);
            $_SESSION['message'] = "Session variable removed!";
        }
        
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
    
    // Destroy the entire session
    if (isset($_POST['destroy_session'])) {
        // Remember the message before destroying the session
        $message = "Session destroyed!";
        
        // Remove all session variables
        session_unset();
        
        // Destroy the session
        session_destroy();
        
        // Start a new session for the message
        session_start();
        $_SESSION['message'] = $message;
        
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
    ?>

    <div class="container">
        <h1>PHP Session Management</h1>
        
        <?php
        // Display message if set
        if (isset($_SESSION['message'])) {
            echo "<div class='result'>".$_SESSION['message']."</div>";
            unset($_SESSION['message']);
        }
        
        // Display error if set
        if (isset($error)) {
            echo "<div class='error'>".$error."</div>";
        }
        ?>
        
        <div class="section">
            <h2>Session Information</h2>
            
            <div class="example">
                <h3>Session ID: <span class="highlight"><?php echo session_id(); ?></span></h3>
                <p>This is your current PHP session identifier.</p>
                
                <h3>Session Status:</h3>
                <?php
                $status = session_status();
                if ($status === PHP_SESSION_DISABLED) {
                    echo "<p>Sessions are disabled.</p>";
                } elseif ($status === PHP_SESSION_NONE) {
                    echo "<p>Sessions are enabled, but no session has been started.</p>";
                } elseif ($status === PHP_SESSION_ACTIVE) {
                    echo "<p>Sessions are enabled, and a session exists.</p>";
                }
                
                // Display session variables
                echo "<h3>Current Session Variables:</h3>";
                if (count($_SESSION) > 0) {
                    foreach ($_SESSION as $key => $value) {
                        if ($key === 'user' || $key === 'cart') {
                            // Skip these and handle them separately
                            continue;
                        }
                        echo "<div class='session-item'>";
                        echo "<strong>$key:</strong> ";
                        
                        if (is_array($value)) {
                            echo "<pre>";
                            print_r($value);
                            echo "</pre>";
                        } else {
                            echo "<span class='session-value'>" . htmlspecialchars($value) . "</span>";
                        }
                        
                        echo "<form method='post' action='' style='display:inline; margin-left:10px;'>";
                        echo "<input type='hidden' name='session_name' value='" . htmlspecialchars($key) . "'>";
                        echo "<button type='submit' name='remove_session' style='background-color: #dc3545; padding: 4px 8px;'>Remove</button>";
                        echo "</form>";
                        
                        echo "</div>";
                    }
                } else {
                    echo "<p>No session variables are set.</p>";
                }
                ?>
            </div>
        </div>
        
        <div class="section">
            <h2>User Authentication Demo</h2>
            
            <?php if (isset($_SESSION['user'])): ?>
                <div class="user-info">
                    <h3>Welcome, <?php echo htmlspecialchars($_SESSION['user']['name']); ?>!</h3>
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($_SESSION['user']['username']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user']['email']); ?></p>
                    <p><strong>Login Time:</strong> <?php echo htmlspecialchars($_SESSION['user']['login_time']); ?></p>
                    
                    <form method="post" action="">
                        <input type="submit" name="logout" value="Logout">
                    </form>
                </div>
            <?php else: ?>
                <form method="post" action="">
                    <h3>Login Form</h3>
                    <div>
                        <label for="username">Username:</label><br>
                        <input type="text" id="username" name="username" value="demo" required>
                        <p class="note">Demo username: demo</p>
                    </div>
                    <div>
                        <label for="password">Password:</label><br>
                        <input type="password" id="password" name="password" value="password" required>
                        <p class="note">Demo password: password</p>
                    </div>
                    <input type="submit" name="login" value="Login">
                </form>
            <?php endif; ?>
            
            <div class="example">
                <h3>Session-based Authentication Code:</h3>
                <pre><code>// Start session at the beginning of your script
session_start();

// Login process
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Validate credentials (use database in real apps)
    if ($username === 'demo' && $password === 'password') {
        $_SESSION['user'] = [
            'username' => $username,
            'email' => 'demo@example.com',
            'login_time' => date('Y-m-d H:i:s')
        ];
        // Redirect to dashboard
    } else {
        // Show error message
    }
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user']);
}

// Logout process
if (isset($_POST['logout'])) {
    unset($_SESSION['user']);
    // Redirect to login page
}</code></pre>
            </div>
        </div>
        
        <div class="section">
            <h2>Shopping Cart Demo</h2>
            
            <div class="example">
                <h3>Available Products</h3>
                <form method="post" action="">
                    <table>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        // Sample products
                        $products = [
                            '1' => ['name' => 'Laptop', 'price' => 799.99],
                            '2' => ['name' => 'Smartphone', 'price' => 499.99],
                            '3' => ['name' => 'Headphones', 'price' => 99.99],
                            '4' => ['name' => 'Mouse', 'price' => 29.99],
                            '5' => ['name' => 'Keyboard', 'price' => 49.99],
                        ];
                        
                        foreach ($products as $id => $product) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($product['name']) . "</td>";
                            echo "<td>$" . number_format($product['price'], 2) . "</td>";
                            echo "<td>";
                            echo "<form method='post' action=''>";
                            echo "<input type='hidden' name='product_id' value='" . $id . "'>";
                            echo "<input type='hidden' name='product_name' value='" . htmlspecialchars($product['name']) . "'>";
                            echo "<input type='hidden' name='product_price' value='" . $product['price'] . "'>";
                            echo "<button type='submit' name='add_to_cart'>Add to Cart</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </form>
                
                <h3>Your Shopping Cart</h3>
                <?php
                if (empty($_SESSION['cart'])) {
                    echo "<p>Your cart is empty.</p>";
                } else {
                    echo "<div class='cart-items'>";
                    $total = 0;
                    
                    foreach ($_SESSION['cart'] as $id => $item) {
                        $itemTotal = $item['price'] * $item['quantity'];
                        $total += $itemTotal;
                        
                        echo "<div class='cart-item'>";
                        echo "<div>";
                        echo "<strong>" . htmlspecialchars($item['name']) . "</strong> x " . $item['quantity'];
                        echo "<br>$" . number_format($item['price'], 2) . " each";
                        echo "</div>";
                        echo "<div>";
                        echo "$" . number_format($itemTotal, 2);
                        echo "</div>";
                        echo "<div>";
                        echo "<form method='post' action=''>";
                        echo "<input type='hidden' name='product_id' value='" . $id . "'>";
                        echo "<button type='submit' name='remove_from_cart' style='background-color: #dc3545;'>Remove</button>";
                        echo "</form>";
                        echo "</div>";
                        echo "</div>";
                    }
                    
                    echo "<div class='cart-total'>";
                    echo "Total: $" . number_format($total, 2);
                    echo "</div>";
                    
                    echo "<form method='post' action=''>";
                    echo "<button type='submit' name='clear_cart' style='background-color: #dc3545;'>Clear Cart</button>";
                    echo "</form>";
                    
                    echo "</div>";
                }
                ?>
            </div>
            
            <div class="example">
                <h3>Session-based Shopping Cart Code:</h3>
                <pre><code>// Initialize the cart in session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add product to cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity']++;
    } else {
        $_SESSION['cart'][$product_id] = [
            'name' => $_POST['product_name'],
            'price' => $_POST['product_price'],
            'quantity' => 1
        ];
    }
}

// Remove item from cart
if (isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);
}

// Calculate cart total
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}</code></pre>
            </div>
        </div>
        
        <div class="section">
            <h2>Custom Session Variables</h2>
            
            <form method="post" action="">
                <h3>Set a Session Variable</h3>
                <div>
                    <label for="session_name">Variable Name:</label><br>
                    <input type="text" id="session_name" name="session_name" required>
                </div>
                <div>
                    <label for="session_value">Variable Value:</label><br>
                    <input type="text" id="session_value" name="session_value">
                </div>
                <input type="submit" name="set_session" value="Set Variable">
            </form>
            
            <div class="example" style="margin-top: 20px;">
                <h3>Session Management Functions</h3>
                <form method="post" action="">
                    <button type="submit" name="destroy_session" style="background-color: #dc3545;">Destroy Session</button>
                    <p class="note">This will destroy the entire session, removing all variables.</p>
                </form>
            </div>
        </div>
        
        <div class="section">
            <h2>Understanding PHP Sessions</h2>
            
            <div class="example">
                <h3>How PHP Sessions Work:</h3>
                <ol>
                    <li><strong>Session Start</strong>: When <code>session_start()</code> is called, PHP generates a unique session ID.</li>
                    <li><strong>Cookie Creation</strong>: The session ID is stored in a cookie called PHPSESSID by default.</li>
                    <li><strong>File Creation</strong>: PHP creates a temporary file on the server to store session data.</li>
                    <li><strong>Data Storage</strong>: Session variables are stored in the $_SESSION superglobal array.</li>
                    <li><strong>Data Persistence</strong>: When a user visits another page, PHP retrieves session data using the session ID.</li>
                </ol>
            </div>
            
            <div class="example">
                <h3>Key Session Functions:</h3>
                <table>
                    <tr>
                        <th>Function</th>
                        <th>Description</th>
                    </tr>
                    <tr>
                        <td><code>session_start()</code></td>
                        <td>Starts a new session or resumes an existing one</td>
                    </tr>
                    <tr>
                        <td><code>session_id()</code></td>
                        <td>Gets or sets the current session ID</td>
                    </tr>
                    <tr>
                        <td><code>session_name()</code></td>
                        <td>Gets or sets the current session name</td>
                    </tr>
                    <tr>
                        <td><code>session_status()</code></td>
                        <td>Returns the current session status</td>
                    </tr>
                    <tr>
                        <td><code>session_unset()</code></td>
                        <td>Frees all session variables</td>
                    </tr>
                    <tr>
                        <td><code>session_destroy()</code></td>
                        <td>Destroys all data registered to a session</td>
                    </tr>
                    <tr>
                        <td><code>session_write_close()</code></td>
                        <td>Writes session data and ends the session</td>
                    </tr>
                </table>
            </div>
            
            <div class="example">
                <h3>Session vs. Cookies:</h3>
                <table>
                    <tr>
                        <th>Feature</th>
                        <th>Sessions</th>
                        <th>Cookies</th>
                    </tr>
                    <tr>
                        <td>Storage Location</td>
                        <td>Server</td>
                        <td>Client's browser</td>
                    </tr>
                    <tr>
                        <td>Security</td>
                        <td>More secure</td>
                        <td>Less secure</td>
                    </tr>
                    <tr>
                        <td>Lifespan</td>
                        <td>Ends when browser closes or timeout</td>
                        <td>Set by expiration time</td>
                    </tr>
                    <tr>
                        <td>Data Size</td>
                        <td>Larger capacity</td>
                        <td>Limited (~4KB)</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
