<!DOCTYPE html>
<html>
<head>
    <title>MySQL Database Connection</title>
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
        input[type="text"], input[type="password"] {
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
        .connection-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 20px 0;
        }
        .connection-form {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        .sql-result {
            margin-top: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .execute-btn {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PHP MySQL Database Connection</h1>
        
        <div class="section">
            <h2>Connect to MySQL Database</h2>
            
            <?php
            // Default connection values
            $default_host = "localhost";
            $default_username = "root";
            $default_password = "";
            $default_database = "test";
            
            // Initialize connection variables
            $host = isset($_POST['db_host']) ? $_POST['db_host'] : $default_host;
            $username = isset($_POST['db_username']) ? $_POST['db_username'] : $default_username;
            $password = isset($_POST['db_password']) ? $_POST['db_password'] : $default_password;
            $database = isset($_POST['db_name']) ? $_POST['db_name'] : $default_database;
            
            // Connection status flag
            $connected = false;
            $connection_error = "";
            $conn = null;
            
            // Process connection request
            if (isset($_POST['connect'])) {
                // Attempt to connect to MySQL
                try {
                    $conn = new mysqli($host, $username, $password);
                    
                    // Check connection
                    if ($conn->connect_error) {
                        $connection_error = "Connection failed: " . $conn->connect_error;
                    } else {
                        $connected = true;
                    }
                } catch (Exception $e) {
                    $connection_error = "Connection failed: " . $e->getMessage();
                }
            }
            
            // Process database selection
            if (isset($_POST['select_db']) && $connected) {
                // Try to select the database
                if ($conn->select_db($database)) {
                    $db_selected = true;
                    $db_message = "Database '$database' selected successfully!";
                } else {
                    $db_selected = false;
                    $db_message = "Error selecting database '$database': " . $conn->error;
                }
            }
            
            // Process SQL query execution
            if (isset($_POST['execute_query']) && $connected) {
                $sql = $_POST['sql_query'];
                $query_result = null;
                $query_error = "";
                
                // Check if a database is selected
                if (!isset($db_selected) || !$db_selected) {
                    $query_error = "Please select a database first.";
                } else if (empty($sql)) {
                    $query_error = "SQL query cannot be empty.";
                } else {
                    // Execute the query
                    try {
                        // Check if query is a SELECT statement
                        $is_select = stripos(trim($sql), "SELECT") === 0;
                        
                        if ($is_select) {
                            $result = $conn->query($sql);
                            
                            if ($result) {
                                // Process SELECT result
                                $query_result = $result;
                            } else {
                                $query_error = "Error executing query: " . $conn->error;
                            }
                        } else {
                            // Execute non-SELECT query (INSERT, UPDATE, DELETE, etc.)
                            if ($conn->query($sql) === TRUE) {
                                $affected_rows = $conn->affected_rows;
                                $query_success = "Query executed successfully. Affected rows: $affected_rows";
                            } else {
                                $query_error = "Error executing query: " . $conn->error;
                            }
                        }
                    } catch (Exception $e) {
                        $query_error = "Error executing query: " . $e->getMessage();
                    }
                }
            }
            ?>
            
            <div class="connection-details">
                <div class="connection-form">
                    <h3>Connection Details</h3>
                    <form method="post" action="">
                        <div>
                            <label for="db_host">Host:</label><br>
                            <input type="text" id="db_host" name="db_host" value="<?php echo htmlspecialchars($host); ?>" required>
                        </div>
                        <div>
                            <label for="db_username">Username:</label><br>
                            <input type="text" id="db_username" name="db_username" value="<?php echo htmlspecialchars($username); ?>" required>
                        </div>
                        <div>
                            <label for="db_password">Password:</label><br>
                            <input type="password" id="db_password" name="db_password" value="<?php echo htmlspecialchars($password); ?>">
                        </div>
                        <input type="submit" name="connect" value="Connect to MySQL">
                    </form>
                    
                    <?php if ($connected): ?>
                        <div class="result">
                            Connected to MySQL server successfully!
                        </div>
                    <?php elseif (!empty($connection_error)): ?>
                        <div class="error">
                            <?php echo $connection_error; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <?php if ($connected): ?>
                    <div class="connection-form">
                        <h3>Select Database</h3>
                        <form method="post" action="">
                            <div>
                                <label for="db_name">Database Name:</label><br>
                                <input type="text" id="db_name" name="db_name" value="<?php echo htmlspecialchars($database); ?>" required>
                            </div>
                            
                            <!-- Hidden fields to maintain connection state -->
                            <input type="hidden" name="db_host" value="<?php echo htmlspecialchars($host); ?>">
                            <input type="hidden" name="db_username" value="<?php echo htmlspecialchars($username); ?>">
                            <input type="hidden" name="db_password" value="<?php echo htmlspecialchars($password); ?>">
                            <input type="hidden" name="connect" value="1">
                            
                            <input type="submit" name="select_db" value="Select Database">
                        </form>
                        
                        <?php if (isset($db_message)): ?>
                            <div class="<?php echo $db_selected ? 'result' : 'error'; ?>">
                                <?php echo $db_message; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php
                        // Show available databases
                        if ($connected) {
                            $result = $conn->query("SHOW DATABASES");
                            
                            if ($result) {
                                echo "<h4>Available Databases:</h4>";
                                echo "<ul>";
                                while ($row = $result->fetch_assoc()) {
                                    echo "<li>" . htmlspecialchars($row['Database']) . "</li>";
                                }
                                echo "</ul>";
                            }
                        }
                        ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if (isset($db_selected) && $db_selected): ?>
                <div class="example">
                    <h3>Execute SQL Query</h3>
                    <form method="post" action="">
                        <div>
                            <label for="sql_query">SQL Query:</label><br>
                            <textarea id="sql_query" name="sql_query" placeholder="Enter SQL query here..."><?php echo isset($_POST['sql_query']) ? htmlspecialchars($_POST['sql_query']) : ''; ?></textarea>
                            <p class="note">Examples: SELECT * FROM users; CREATE TABLE users (id INT, name VARCHAR(50));</p>
                        </div>
                        
                        <!-- Hidden fields to maintain connection state -->
                        <input type="hidden" name="db_host" value="<?php echo htmlspecialchars($host); ?>">
                        <input type="hidden" name="db_username" value="<?php echo htmlspecialchars($username); ?>">
                        <input type="hidden" name="db_password" value="<?php echo htmlspecialchars($password); ?>">
                        <input type="hidden" name="db_name" value="<?php echo htmlspecialchars($database); ?>">
                        <input type="hidden" name="connect" value="1">
                        <input type="hidden" name="select_db" value="1">
                        
                        <input type="submit" name="execute_query" value="Execute Query" class="execute-btn">
                    </form>
                    
                    <?php if (isset($query_error) && !empty($query_error)): ?>
                        <div class="error">
                            <?php echo $query_error; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($query_success)): ?>
                        <div class="result">
                            <?php echo $query_success; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($query_result) && $query_result->num_rows > 0): ?>
                        <div class="sql-result">
                            <h4>Query Results:</h4>
                            <table>
                                <tr>
                                    <?php
                                    // Get field names
                                    $fields = $query_result->fetch_fields();
                                    foreach ($fields as $field) {
                                        echo "<th>" . htmlspecialchars($field->name) . "</th>";
                                    }
                                    ?>
                                </tr>
                                
                                <?php
                                // Print data rows
                                while ($row = $query_result->fetch_assoc()) {
                                    echo "<tr>";
                                    foreach ($row as $value) {
                                        echo "<td>" . htmlspecialchars($value) . "</td>";
                                    }
                                    echo "</tr>";
                                }
                                ?>
                            </table>
                            <p><strong>Total rows: <?php echo $query_result->num_rows; ?></strong></p>
                        </div>
                    <?php elseif (isset($query_result)): ?>
                        <div class="sql-result">
                            <p>Query executed successfully, but returned no results.</p>
                        </div>
                    <?php endif; ?>
                    
                    <?php
                    // Show tables in the current database
                    $tables_result = $conn->query("SHOW TABLES");
                    
                    if ($tables_result && $tables_result->num_rows > 0) {
                        echo "<div class='sql-result'>";
                        echo "<h4>Tables in '{$database}':</h4>";
                        echo "<ul>";
                        while ($row = $tables_result->fetch_array()) {
                            echo "<li>" . htmlspecialchars($row[0]) . "</li>";
                        }
                        echo "</ul>";
                        echo "</div>";
                    }
                    ?>
                </div>
            <?php endif; ?>
            
            <?php
            // Close connection
            if ($conn) {
                $conn->close();
            }
            ?>
        </div>
        
        <div class="section">
            <h2>MySQL Connection Methods in PHP</h2>
            
            <div class="example">
                <h3>1. Using MySQLi (Object-Oriented)</h3>
                <pre><code>// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Execute query
$result = $conn->query("SELECT * FROM users");

// Process result
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo $row["name"];
    }
}

// Close connection
$conn->close();</code></pre>
            </div>
            
            <div class="example">
                <h3>2. Using MySQLi (Procedural)</h3>
                <pre><code>// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Execute query
$result = mysqli_query($conn, "SELECT * FROM users");

// Process result
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo $row["name"];
    }
}

// Close connection
mysqli_close($conn);</code></pre>
            </div>
            
            <div class="example">
                <h3>3. Using PDO (PHP Data Objects)</h3>
                <pre><code>try {
    // Create connection
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    
    // Set error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Execute query
    $stmt = $conn->prepare("SELECT * FROM users");
    $stmt->execute();
    
    // Process result
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $data = $stmt->fetchAll();
    
    foreach($data as $row) {
        echo $row["name"];
    }
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}</code></pre>
            </div>
        </div>
        
        <div class="section">
            <h2>Common MySQL Operations</h2>
            
            <div class="example">
                <h3>1. Create a Database</h3>
                <pre><code>CREATE DATABASE mydatabase;</code></pre>
            </div>
            
            <div class="example">
                <h3>2. Create a Table</h3>
                <pre><code>CREATE TABLE users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);</code></pre>
            </div>
            
            <div class="example">
                <h3>3. Insert Data</h3>
                <pre><code>INSERT INTO users (firstname, lastname, email)
VALUES ('John', 'Doe', 'john@example.com');</code></pre>
            </div>
            
            <div class="example">
                <h3>4. Select Data</h3>
                <pre><code>SELECT * FROM users;
SELECT firstname, lastname FROM users;
SELECT * FROM users WHERE id = 1;
SELECT * FROM users ORDER BY lastname;</code></pre>
            </div>
            
            <div class="example">
                <h3>5. Update Data</h3>
                <pre><code>UPDATE users SET firstname = 'Jane' WHERE id = 1;</code></pre>
            </div>
            
            <div class="example">
                <h3>6. Delete Data</h3>
                <pre><code>DELETE FROM users WHERE id = 1;</code></pre>
            </div>
            
            <div class="example">
                <h3>7. Join Tables</h3>
                <pre><code>SELECT users.firstname, orders.order_id
FROM users
INNER JOIN orders ON users.id = orders.user_id;</code></pre>
            </div>
        </div>
        
        <div class="section">
            <h2>Security Best Practices</h2>
            
            <div class="example">
                <h3>Prepared Statements for Preventing SQL Injection</h3>
                <pre><code>// Using MySQLi
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Using PDO
$stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
$stmt->bindParam(':username', $username);
$stmt->execute();</code></pre>
            </div>
            
            <div class="example">
                <h3>Additional Security Tips</h3>
                <ul>
                    <li>Use a database user with minimal permissions needed for the application</li>
                    <li>Never store database credentials in publicly accessible files</li>
                    <li>Use strong passwords for database access</li>
                    <li>Validate and sanitize all user input before using in queries</li>
                    <li>Use parameterized queries (prepared statements) to prevent SQL injection</li>
                    <li>Hash passwords before storing them in the database</li>
                    <li>Limit the number of database connections and close them when done</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
