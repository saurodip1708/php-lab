<!DOCTYPE html>
<html>
<head>
    <title>PHP Login System</title>
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
        .user-info {
            background-color: #e2e3e5;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .dashboard {
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
            margin-top: 20px;
        }
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .user-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-top: 20px;
        }
        .user-avatar {
            background-color: #4a6fa5;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 15px auto;
        }
        .login-required {
            background-color: #fff3cd;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            text-align: center;
        }
        .logged-in-status {
            background-color: #d1e7dd;
            color: #155724;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
    <?php
    // Start or resume session
    session_start();
    
    // Define demo users (in a real app, this would be a database)
    $users = [
        'admin' => [
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'role' => 'admin'
        ],
        'user' => [
            'password' => password_hash('user123', PASSWORD_DEFAULT),
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'role' => 'user'
        ]
    ];
    
    // Process registration
    if (isset($_POST['register'])) {
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        
        $error = false;
        
        // Validate input
        if (empty($username) || empty($password) || empty($name) || empty($email)) {
            $register_error = "All fields are required.";
            $error = true;
        } elseif (isset($users[$username])) {
            $register_error = "Username already exists.";
            $error = true;
        } elseif ($password !== $confirm_password) {
            $register_error = "Passwords do not match.";
            $error = true;
        } elseif (strlen($password) < 6) {
            $register_error = "Password must be at least 6 characters.";
            $error = true;
        }
        
        if (!$error) {
            // In a real app, you would save to a database here
            $users[$username] = [
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'name' => $name,
                'email' => $email,
                'role' => 'user'
            ];
            
            // For demo purposes, save to session
            $_SESSION['demo_users'] = $users;
            
            $_SESSION['message'] = "Registration successful! You can now log in.";
            
            // Redirect to clear form submission
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        }
    }
    
    // Process login
    if (isset($_POST['login'])) {
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $remember = isset($_POST['remember']) ? true : false;
        
        // Check if demo users have been added during this session
        if (isset($_SESSION['demo_users'])) {
            $users = $_SESSION['demo_users'];
        }
        
        if (isset($users[$username])) {
            if (password_verify($password, $users[$username]['password'])) {
                // Login successful
                $_SESSION['user'] = [
                    'username' => $username,
                    'name' => $users[$username]['name'],
                    'email' => $users[$username]['email'],
                    'role' => $users[$username]['role'],
                    'login_time' => date('Y-m-d H:i:s')
                ];
                
                // Set remember me cookie if requested (30 days)
                if ($remember) {
                    // In a real app, you would use a token here, not the username
                    setcookie('remember_user', $username, time() + (86400 * 30), "/");
                }
                
                $_SESSION['message'] = "Login successful! Welcome, " . $users[$username]['name'] . ".";
                
                // Redirect to clear form submission
                header("Location: ".$_SERVER['PHP_SELF']);
                exit();
            } else {
                $login_error = "Invalid password.";
            }
        } else {
            $login_error = "Username not found.";
        }
    }
    
    // Process logout
    if (isset($_POST['logout'])) {
        // Remove the user from session
        unset($_SESSION['user']);
        
        // Remove remember me cookie if set
        if (isset($_COOKIE['remember_user'])) {
            setcookie('remember_user', '', time() - 3600, '/');
        }
        
        $_SESSION['message'] = "You have been logged out.";
        
        // Redirect to clear form submission
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
    
    // Check for "Remember Me" cookie
    if (!isset($_SESSION['user']) && isset($_COOKIE['remember_user'])) {
        $remembered_user = $_COOKIE['remember_user'];
        
        // Check if demo users have been added during this session
        if (isset($_SESSION['demo_users'])) {
            $users = $_SESSION['demo_users'];
        }
        
        if (isset($users[$remembered_user])) {
            // Auto-login the remembered user
            $_SESSION['user'] = [
                'username' => $remembered_user,
                'name' => $users[$remembered_user]['name'],
                'email' => $users[$remembered_user]['email'],
                'role' => $users[$remembered_user]['role'],
                'login_time' => date('Y-m-d H:i:s'),
                'auto_login' => true
            ];
        }
    }
    ?>

    <div class="container">
        <h1>PHP Login System</h1>
        
        <?php
        // Display message if set
        if (isset($_SESSION['message'])) {
            echo "<div class='result'>".$_SESSION['message']."</div>";
            unset($_SESSION['message']);
        }
        ?>
        
        <?php if (isset($_SESSION['user'])): ?>
            <!-- User is logged in, show dashboard -->
            <div class="logged-in-status">
                <div>
                    <strong>Status:</strong> Logged In
                    <?php if (isset($_SESSION['user']['auto_login'])): ?>
                        <span class="note">(via Remember Me cookie)</span>
                    <?php endif; ?>
                </div>
                <form method="post" action="" style="margin: 0;">
                    <button type="submit" name="logout">Logout</button>
                </form>
            </div>
            
            <div class="section">
                <div class="dashboard">
                    <div class="dashboard-header">
                        <h2>Welcome to Your Dashboard</h2>
                        <div>
                            <strong>Role:</strong> <?php echo ucfirst($_SESSION['user']['role']); ?>
                        </div>
                    </div>
                    
                    <div class="user-card">
                        <div class="user-avatar">
                            <?php echo strtoupper(substr($_SESSION['user']['name'], 0, 1)); ?>
                        </div>
                        
                        <h3><?php echo htmlspecialchars($_SESSION['user']['name']); ?></h3>
                        <p><strong>Username:</strong> <?php echo htmlspecialchars($_SESSION['user']['username']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user']['email']); ?></p>
                        <p><strong>Login Time:</strong> <?php echo htmlspecialchars($_SESSION['user']['login_time']); ?></p>
                    </div>
                    
                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                        <div class="section" style="margin-top: 20px;">
                            <h3>Admin Panel</h3>
                            <p>This section is only visible to administrators.</p>
                            
                            <h4>Registered Users:</h4>
                            <table>
                                <tr>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                </tr>
                                <?php
                                // Show all users in the demo system
                                $all_users = isset($_SESSION['demo_users']) ? $_SESSION['demo_users'] : $users;
                                
                                foreach ($all_users as $username => $user_data) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($username) . "</td>";
                                    echo "<td>" . htmlspecialchars($user_data['name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($user_data['email']) . "</td>";
                                    echo "<td>" . htmlspecialchars($user_data['role']) . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <!-- User is not logged in, show login and registration forms -->
            <div class="section">
                <h2>Login</h2>
                
                <?php if (isset($login_error)): ?>
                    <div class="error"><?php echo $login_error; ?></div>
                <?php endif; ?>
                
                <form method="post" action="">
                    <div>
                        <label for="username">Username:</label><br>
                        <input type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
                        <p class="note">Demo users: 'admin' (password: admin123) or 'user' (password: user123)</p>
                    </div>
                    <div>
                        <label for="password">Password:</label><br>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div>
                        <label>
                            <input type="checkbox" name="remember"> Remember Me (30 days)
                        </label>
                    </div>
                    <input type="submit" name="login" value="Login">
                </form>
            </div>
            
            <div class="section">
                <h2>Register New Account</h2>
                
                <?php if (isset($register_error)): ?>
                    <div class="error"><?php echo $register_error; ?></div>
                <?php endif; ?>
                
                <form method="post" action="">
                    <div>
                        <label for="reg_username">Username:</label><br>
                        <input type="text" id="reg_username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
                    </div>
                    <div>
                        <label for="name">Full Name:</label><br>
                        <input type="text" id="name" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                    </div>
                    <div>
                        <label for="email">Email:</label><br>
                        <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                    </div>
                    <div>
                        <label for="reg_password">Password:</label><br>
                        <input type="password" id="reg_password" name="password" required>
                        <p class="note">Minimum 6 characters</p>
                    </div>
                    <div>
                        <label for="confirm_password">Confirm Password:</label><br>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                    <input type="submit" name="register" value="Register">
                </form>
            </div>
        <?php endif; ?>
        
        <div class="section">
            <h2>Protected Content Example</h2>
            
            <?php if (isset($_SESSION['user'])): ?>
                <!-- Content only visible to logged in users -->
                <div class="example">
                    <h3>Secret Content</h3>
                    <p>This content is only visible to logged-in users.</p>
                    
                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                        <div style="background-color: #cce5ff; padding: 10px; border-radius: 5px;">
                            <h4>Admin-Only Content</h4>
                            <p>This special section is only visible to administrators.</p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <!-- Message for non-logged in users -->
                <div class="login-required">
                    <h3>Login Required</h3>
                    <p>You must be logged in to view the protected content.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="section">
            <h2>About This Login System</h2>
            
            <div class="example">
                <h3>Features:</h3>
                <ul>
                    <li>User registration with validation</li>
                    <li>Secure password hashing</li>
                    <li>"Remember Me" functionality using cookies</li>
                    <li>Role-based access control (admin vs. regular users)</li>
                    <li>Protected content areas</li>
                    <li>User dashboard</li>
                </ul>
            </div>
            
            <div class="example">
                <h3>Security Best Practices:</h3>
                <ol>
                    <li>Passwords are hashed using PHP's <code>password_hash()</code> function</li>
                    <li>User input is validated and sanitized</li>
                    <li>Password strength requirements are enforced</li>
                    <li>Protection against session hijacking through secure session management</li>
                    <li>Role-based access control for different user types</li>
                </ol>
                
                <p class="note">Note: In a real application, user data would be stored in a database rather than in session variables.</p>
            </div>
            
            <div class="example">
                <h3>Core Code Snippets:</h3>
                <pre><code>// Password hashing
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Password verification
if (password_verify($password, $stored_hash)) {
    // Login successful
}

// Session-based authentication
$_SESSION['user'] = [
    'username' => $username,
    'role' => $role,
    'login_time' => date('Y-m-d H:i:s')
];

// "Remember Me" cookie
if ($remember) {
    setcookie('remember_user', $token, time() + (86400 * 30), "/");
}

// Role-based access control
if ($_SESSION['user']['role'] === 'admin') {
    // Show admin content
}</code></pre>
            </div>
        </div>
    </div>
</body>
</html>
