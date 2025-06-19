<!DOCTYPE html>
<html>
<head>
    <title>PHP CRUD Operations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            text-align: center;
            background-color: #f0f0f0;
        }
        h1, h2, h3 {
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
        input[type="text"], input[type="email"], input[type="number"] {
            padding: 8px;
            width: 300px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        textarea {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            height: 100px;
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
        .create-btn {
            background-color: #28a745;
        }
        .update-btn {
            background-color: #ffc107;
            color: #212529;
        }
        .delete-btn {
            background-color: #dc3545;
        }
        .create-btn:hover {
            background-color: #218838;
        }
        .update-btn:hover {
            background-color: #e0a800;
            color: #212529;
        }
        .delete-btn:hover {
            background-color: #c82333;
        }
        .actions {
            display: flex;
            gap: 5px;
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
        .status-message {
            margin-bottom: 20px;
        }
        .tab-container {
            margin-bottom: 20px;
        }
        .tab-buttons {
            display: flex;
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
            border-radius: 5px 5px 0 0;
        }
        .tab-button {
            background-color: inherit;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 10px 16px;
            transition: 0.3s;
            font-size: 17px;
            color: #495057;
        }
        .tab-button:hover {
            background-color: #ddd;
        }
        .tab-button.active {
            background-color: #4a6fa5;
            color: white;
        }
        .tab-content {
            display: none;
            padding: 15px;
            border: 1px solid #ccc;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .tab-content.active {
            display: block;
        }
    </style>
</head>
<body>
    <?php
    // Initialize database connection parameters
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "crud_demo";
    
    // Create connection
    $conn = new mysqli($host, $username, $password);
    $connected = false;
    $db_exists = false;
    
    // Check connection
    if ($conn->connect_error) {
        $connection_error = "Connection failed: " . $conn->connect_error;
    } else {
        $connected = true;
        
        // Check if database exists, if not, create it
        $result = $conn->query("SHOW DATABASES LIKE '$database'");
        if ($result->num_rows == 0) {
            // Create database
            if ($conn->query("CREATE DATABASE $database")) {
                $db_created = true;
            } else {
                $db_error = "Error creating database: " . $conn->error;
            }
        }
        
        // Select database
        if ($conn->select_db($database)) {
            $db_exists = true;
            
            // Check if table exists, if not, create it
            $result = $conn->query("SHOW TABLES LIKE 'users'");
            if ($result->num_rows == 0) {
                // Create table
                $sql = "CREATE TABLE users (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(50) NOT NULL,
                    email VARCHAR(50) NOT NULL,
                    age INT(3),
                    city VARCHAR(50),
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";
                
                if ($conn->query($sql)) {
                    $table_created = true;
                } else {
                    $table_error = "Error creating table: " . $conn->error;
                }
            }
        } else {
            $db_error = "Error selecting database: " . $conn->error;
        }
    }
    
    // Function to sanitize input data
    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    // Process form submissions
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Create operation
        if (isset($_POST['create'])) {
            $name = sanitize_input($_POST['name']);
            $email = sanitize_input($_POST['email']);
            $age = sanitize_input($_POST['age']);
            $city = sanitize_input($_POST['city']);
            
            // Validate input
            $valid = true;
            if (empty($name)) {
                $name_error = "Name is required";
                $valid = false;
            }
            
            if (empty($email)) {
                $email_error = "Email is required";
                $valid = false;
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email_error = "Invalid email format";
                $valid = false;
            }
            
            if (!empty($age) && (!is_numeric($age) || $age < 1 || $age > 120)) {
                $age_error = "Age must be between 1 and 120";
                $valid = false;
            }
            
            if ($valid) {
                // Prepare and execute insert statement
                $stmt = $conn->prepare("INSERT INTO users (name, email, age, city) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssis", $name, $email, $age, $city);
                
                if ($stmt->execute()) {
                    $success_message = "User created successfully!";
                    // Clear form data
                    $name = $email = $age = $city = "";
                } else {
                    $error_message = "Error: " . $stmt->error;
                }
                
                $stmt->close();
            }
        }
        
        // Update operation
        if (isset($_POST['update'])) {
            $id = $_POST['id'];
            $name = sanitize_input($_POST['name']);
            $email = sanitize_input($_POST['email']);
            $age = sanitize_input($_POST['age']);
            $city = sanitize_input($_POST['city']);
            
            // Validate input
            $valid = true;
            if (empty($name)) {
                $name_error = "Name is required";
                $valid = false;
            }
            
            if (empty($email)) {
                $email_error = "Email is required";
                $valid = false;
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email_error = "Invalid email format";
                $valid = false;
            }
            
            if (!empty($age) && (!is_numeric($age) || $age < 1 || $age > 120)) {
                $age_error = "Age must be between 1 and 120";
                $valid = false;
            }
            
            if ($valid) {
                // Prepare and execute update statement
                $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, age = ?, city = ? WHERE id = ?");
                $stmt->bind_param("ssisi", $name, $email, $age, $city, $id);
                
                if ($stmt->execute()) {
                    $success_message = "User updated successfully!";
                } else {
                    $error_message = "Error: " . $stmt->error;
                }
                
                $stmt->close();
            }
        }
        
        // Delete operation
        if (isset($_POST['delete'])) {
            $id = $_POST['id'];
            
            // Prepare and execute delete statement
            $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param("i", $id);
            
            if ($stmt->execute()) {
                $success_message = "User deleted successfully!";
            } else {
                $error_message = "Error: " . $stmt->error;
            }
            
            $stmt->close();
        }
    }
    
    // Fetch all users for display
    $users = [];
    if ($connected && $db_exists) {
        $result = $conn->query("SELECT * FROM users ORDER BY id DESC");
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
    }
    ?>

    <div class="container">
        <h1>PHP CRUD Operations</h1>
        
        <?php if (!$connected): ?>
            <div class="error">
                <?php echo $connection_error; ?>
                <p>Please make sure your MySQL server is running and that you have the correct credentials.</p>
            </div>
        <?php elseif (!$db_exists): ?>
            <div class="error">
                <?php echo $db_error; ?>
            </div>
        <?php else: ?>
            <?php if (isset($table_created)): ?>
                <div class="result">
                    The 'users' table was created successfully.
                </div>
            <?php endif; ?>
            
            <?php if (isset($db_created)): ?>
                <div class="result">
                    The database '<?php echo $database; ?>' was created successfully.
                </div>
            <?php endif; ?>
            
            <?php if (isset($success_message)): ?>
                <div class="result status-message">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($error_message)): ?>
                <div class="error status-message">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            
            <div class="tab-container">
                <div class="tab-buttons">
                    <button class="tab-button active" onclick="openTab(event, 'create-tab')">Create</button>
                    <button class="tab-button" onclick="openTab(event, 'read-tab')">Read</button>
                    <button class="tab-button" onclick="openTab(event, 'update-tab')">Update</button>
                    <button class="tab-button" onclick="openTab(event, 'delete-tab')">Delete</button>
                </div>
                
                <div id="create-tab" class="tab-content active">
                    <h2>Create a New User</h2>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div>
                            <label for="name">Name:</label><br>
                            <input type="text" id="name" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required>
                            <?php if (isset($name_error)): ?>
                                <span class="error"><?php echo $name_error; ?></span>
                            <?php endif; ?>
                        </div>
                        <div>
                            <label for="email">Email:</label><br>
                            <input type="email" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                            <?php if (isset($email_error)): ?>
                                <span class="error"><?php echo $email_error; ?></span>
                            <?php endif; ?>
                        </div>
                        <div>
                            <label for="age">Age:</label><br>
                            <input type="number" id="age" name="age" value="<?php echo isset($age) ? htmlspecialchars($age) : ''; ?>">
                            <?php if (isset($age_error)): ?>
                                <span class="error"><?php echo $age_error; ?></span>
                            <?php endif; ?>
                        </div>
                        <div>
                            <label for="city">City:</label><br>
                            <input type="text" id="city" name="city" value="<?php echo isset($city) ? htmlspecialchars($city) : ''; ?>">
                        </div>
                        <button type="submit" name="create" class="create-btn">Create User</button>
                    </form>
                </div>
                
                <div id="read-tab" class="tab-content">
                    <h2>User List</h2>
                    <?php if (empty($users)): ?>
                        <p>No users found. Create a new user to see the list.</p>
                    <?php else: ?>
                        <table>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Age</th>
                                <th>City</th>
                                <th>Created At</th>
                            </tr>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo $user['age']; ?></td>
                                    <td><?php echo htmlspecialchars($user['city']); ?></td>
                                    <td><?php echo $user['created_at']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </div>
                
                <div id="update-tab" class="tab-content">
                    <h2>Update User</h2>
                    <?php if (empty($users)): ?>
                        <p>No users found. Create a new user to update.</p>
                    <?php else: ?>
                        <table>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Age</th>
                                <th>City</th>
                                <th>Action</th>
                            </tr>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo $user['age']; ?></td>
                                    <td><?php echo htmlspecialchars($user['city']); ?></td>
                                    <td>
                                        <button onclick="fillUpdateForm(<?php echo $user['id']; ?>, '<?php echo addslashes($user['name']); ?>', '<?php echo addslashes($user['email']); ?>', '<?php echo $user['age']; ?>', '<?php echo addslashes($user['city']); ?>')" class="update-btn">Edit</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                        
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="update-form" style="display: none; margin-top: 20px;">
                            <h3>Edit User Details</h3>
                            <input type="hidden" id="update-id" name="id">
                            <div>
                                <label for="update-name">Name:</label><br>
                                <input type="text" id="update-name" name="name" required>
                            </div>
                            <div>
                                <label for="update-email">Email:</label><br>
                                <input type="email" id="update-email" name="email" required>
                            </div>
                            <div>
                                <label for="update-age">Age:</label><br>
                                <input type="number" id="update-age" name="age">
                            </div>
                            <div>
                                <label for="update-city">City:</label><br>
                                <input type="text" id="update-city" name="city">
                            </div>
                            <button type="submit" name="update" class="update-btn">Update User</button>
                        </form>
                    <?php endif; ?>
                </div>
                
                <div id="delete-tab" class="tab-content">
                    <h2>Delete User</h2>
                    <?php if (empty($users)): ?>
                        <p>No users found. Create a new user to delete.</p>
                    <?php else: ?>
                        <table>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td>
                                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                            <button type="submit" name="delete" class="delete-btn">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="section">
            <h2>Understanding CRUD Operations</h2>
            
            <div class="example">
                <h3>What is CRUD?</h3>
                <p>CRUD stands for Create, Read, Update, and Delete, which are the four basic operations of persistent storage. These operations are fundamental for managing data in any database-driven application.</p>
                
                <table>
                    <tr>
                        <th>Operation</th>
                        <th>SQL</th>
                        <th>HTTP Method</th>
                        <th>Description</th>
                    </tr>
                    <tr>
                        <td>Create</td>
                        <td>INSERT</td>
                        <td>POST</td>
                        <td>Add new records to the database</td>
                    </tr>
                    <tr>
                        <td>Read</td>
                        <td>SELECT</td>
                        <td>GET</td>
                        <td>Retrieve records from the database</td>
                    </tr>
                    <tr>
                        <td>Update</td>
                        <td>UPDATE</td>
                        <td>PUT/PATCH</td>
                        <td>Modify existing records in the database</td>
                    </tr>
                    <tr>
                        <td>Delete</td>
                        <td>DELETE</td>
                        <td>DELETE</td>
                        <td>Remove records from the database</td>
                    </tr>
                </table>
            </div>
            
            <div class="example">
                <h3>PHP Code Samples</h3>
                
                <h4>1. Create (INSERT)</h4>
                <pre><code>// Prepared statement for Insert
$stmt = $conn->prepare("INSERT INTO users (name, email, age, city) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssis", $name, $email, $age, $city);
$stmt->execute();</code></pre>
                
                <h4>2. Read (SELECT)</h4>
                <pre><code>// Simple SELECT query
$result = $conn->query("SELECT * FROM users");

// Fetch all rows
$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

// Prepared statement for SELECT with condition
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();</code></pre>
                
                <h4>3. Update (UPDATE)</h4>
                <pre><code>// Prepared statement for Update
$stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, age = ?, city = ? WHERE id = ?");
$stmt->bind_param("ssisi", $name, $email, $age, $city, $id);
$stmt->execute();</code></pre>
                
                <h4>4. Delete (DELETE)</h4>
                <pre><code>// Prepared statement for Delete
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();</code></pre>
            </div>
        </div>
        
        <div class="section">
            <h2>Database Security Best Practices</h2>
            
            <div class="example">
                <h3>1. Always Use Prepared Statements</h3>
                <p>Prepared statements protect against SQL injection attacks by separating SQL code from user input.</p>
                <pre><code>// Unsafe
$query = "SELECT * FROM users WHERE username = '$username'"; // Vulnerable to SQL injection

// Safe - Using prepared statements
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();</code></pre>
            </div>
            
            <div class="example">
                <h3>2. Validate and Sanitize Input</h3>
                <p>Always validate and sanitize user input before processing it.</p>
                <pre><code>// Sanitize function
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Invalid email
}</code></pre>
            </div>
            
            <div class="example">
                <h3>3. Implement Proper Error Handling</h3>
                <p>Don't expose sensitive error information to users.</p>
                <pre><code>// Instead of:
die("Connection failed: " . $conn->connect_error);

// Use:
if ($conn->connect_error) {
    // Log the detailed error internally
    error_log("Database connection failed: " . $conn->connect_error);
    
    // Show generic error to the user
    die("Database connection failed. Please try again later.");
}</code></pre>
            </div>
            
            <div class="example">
                <h3>4. Use Least Privilege Principle</h3>
                <p>Create database users with only the permissions they need to perform their functions.</p>
            </div>
        </div>
    </div>

    <script>
        // Function to open tab content
        function openTab(evt, tabName) {
            // Declare variables
            var i, tabContent, tabButtons;
            
            // Get all elements with class="tab-content" and hide them
            tabContent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabContent.length; i++) {
                tabContent[i].style.display = "none";
            }
            
            // Get all elements with class="tab-button" and remove the class "active"
            tabButtons = document.getElementsByClassName("tab-button");
            for (i = 0; i < tabButtons.length; i++) {
                tabButtons[i].className = tabButtons[i].className.replace(" active", "");
            }
            
            // Show the current tab, and add an "active" class to the button that opened the tab
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }
        
        // Function to fill the update form with user data
        function fillUpdateForm(id, name, email, age, city) {
            document.getElementById('update-form').style.display = 'block';
            document.getElementById('update-id').value = id;
            document.getElementById('update-name').value = name;
            document.getElementById('update-email').value = email;
            document.getElementById('update-age').value = age || '';
            document.getElementById('update-city').value = city || '';
            
            // Switch to update tab
            var updateTab = document.getElementById('update-tab');
            updateTab.scrollIntoView();
        }
    </script>
</body>
</html>
