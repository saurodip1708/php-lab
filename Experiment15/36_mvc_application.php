<?php
/*
 * PHP MVC Application Demo
 * 
 * This file demonstrates a simple MVC (Model-View-Controller) application structure in PHP.
 * For simplicity, all components are included in this single file, but in a real application,
 * these would be separated into different files and folders.
 */

// Start the session
session_start();

// Define the base URL - adjust this based on your server configuration
define('BASE_URL', '/php/Experiment15/36_mvc_application.php');

// ========================
// DATABASE CONFIGURATION
// ========================
// In a real application, this would be in a separate config file
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'php_mvc_demo');

// ========================
// DATABASE CONNECTION CLASS
// ========================
class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    
    private $conn;
    private $error;
    private $stmt;
    public $connected = false;
    
    public function __construct() {
        // Create connection if mysqli extension is available
        if (extension_loaded('mysqli')) {
            try {
                $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
                
                // Check connection
                if ($this->conn->connect_error) {
                    $this->error = $this->conn->connect_error;
                } else {
                    $this->connected = true;
                }
            } catch (Exception $e) {
                $this->error = $e->getMessage();
            }
        } else {
            $this->error = 'MySQLi extension not loaded';
        }
    }
    
    // Execute query
    public function query($sql) {
        if ($this->connected) {
            $this->stmt = $this->conn->query($sql);
            
            if (!$this->stmt) {
                $this->error = $this->conn->error;
                return false;
            }
            return true;
        }
        return false;
    }
    
    // Get result set as array of objects
    public function resultSet() {
        if ($this->stmt) {
            $result = $this->stmt->fetch_all(MYSQLI_ASSOC);
            return $result;
        }
        return [];
    }
    
    // Get single record as object
    public function single() {
        if ($this->stmt) {
            $result = $this->stmt->fetch_assoc();
            return $result;
        }
        return null;
    }
    
    // Get error message
    public function getError() {
        return $this->error;
    }
    
    // Check if database exists
    public function databaseExists() {
        if (!$this->connected) {
            return false;
        }
        
        $result = $this->conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '" . DB_NAME . "'");
        return $result->num_rows > 0;
    }
    
    // Create the database
    public function createDatabase() {
        if (!$this->connected) {
            return false;
        }
        
        // Create the database
        $this->conn->query("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
        
        // Select the database
        $this->conn->select_db(DB_NAME);
        
        // Create tasks table
        $sql = "CREATE TABLE IF NOT EXISTS tasks (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            status ENUM('pending', 'completed') DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        
        $result = $this->conn->query($sql);
        
        // Add sample data if table is empty
        $this->conn->query("INSERT INTO tasks (title, description) 
                           SELECT 'Complete PHP assignment', 'Finish the MVC application in PHP' 
                           FROM DUAL 
                           WHERE NOT EXISTS (SELECT * FROM tasks LIMIT 1)");
        
        $this->conn->query("INSERT INTO tasks (title, description) 
                           SELECT 'Learn more about MVC', 'Study design patterns and MVC architecture' 
                           FROM DUAL 
                           WHERE NOT EXISTS (SELECT * FROM tasks LIMIT 1, 1)");
        
        return $result;
    }
}

// ========================
// MODELS
// ========================
class TaskModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
        
        // Create the database and tables if they don't exist
        if (!$this->db->databaseExists()) {
            $this->db->createDatabase();
        }
    }
    
    public function getTasks() {
        if (!$this->db->connected) {
            return ['error' => $this->db->getError()];
        }
        
        $this->db->query("SELECT * FROM tasks ORDER BY created_at DESC");
        return $this->db->resultSet();
    }
    
    public function getTaskById($id) {
        if (!$this->db->connected) {
            return ['error' => $this->db->getError()];
        }
        
        $this->db->query("SELECT * FROM tasks WHERE id = " . intval($id));
        return $this->db->single();
    }
    
    public function addTask($title, $description) {
        if (!$this->db->connected) {
            return ['error' => $this->db->getError()];
        }
        
        $title = $this->db->conn->real_escape_string($title);
        $description = $this->db->conn->real_escape_string($description);
        
        $sql = "INSERT INTO tasks (title, description) VALUES ('$title', '$description')";
        $success = $this->db->query($sql);
        
        if ($success) {
            return ['success' => true, 'id' => $this->db->conn->insert_id];
        } else {
            return ['error' => $this->db->getError()];
        }
    }
    
    public function updateTask($id, $title, $description, $status) {
        if (!$this->db->connected) {
            return ['error' => $this->db->getError()];
        }
        
        $id = intval($id);
        $title = $this->db->conn->real_escape_string($title);
        $description = $this->db->conn->real_escape_string($description);
        $status = $this->db->conn->real_escape_string($status);
        
        $sql = "UPDATE tasks SET title = '$title', description = '$description', status = '$status' WHERE id = $id";
        $success = $this->db->query($sql);
        
        if ($success) {
            return ['success' => true];
        } else {
            return ['error' => $this->db->getError()];
        }
    }
    
    public function deleteTask($id) {
        if (!$this->db->connected) {
            return ['error' => $this->db->getError()];
        }
        
        $id = intval($id);
        
        $sql = "DELETE FROM tasks WHERE id = $id";
        $success = $this->db->query($sql);
        
        if ($success) {
            return ['success' => true];
        } else {
            return ['error' => $this->db->getError()];
        }
    }
}

// ========================
// CONTROLLERS
// ========================
class TaskController {
    private $model;
    private $view;
    
    public function __construct() {
        $this->model = new TaskModel();
        $this->view = new View();
    }
    
    public function index() {
        // Get all tasks
        $tasks = $this->model->getTasks();
        
        // Render the view
        return $this->view->render('tasks_index', ['tasks' => $tasks]);
    }
    
    public function show($id) {
        // Get task by ID
        $task = $this->model->getTaskById($id);
        
        if (!$task) {
            return $this->view->render('error', ['message' => 'Task not found']);
        }
        
        // Render the view
        return $this->view->render('task_detail', ['task' => $task]);
    }
    
    public function create() {
        // Render the form view
        return $this->view->render('task_form', ['action' => 'add']);
    }
    
    public function store() {
        // Validate and process form
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        
        if (empty($title)) {
            return $this->view->render('task_form', [
                'action' => 'add',
                'error' => 'Title is required',
                'title' => $title,
                'description' => $description
            ]);
        }
        
        // Add the task
        $result = $this->model->addTask($title, $description);
        
        if (isset($result['error'])) {
            return $this->view->render('task_form', [
                'action' => 'add',
                'error' => $result['error'],
                'title' => $title,
                'description' => $description
            ]);
        }
        
        // Redirect to index with success message
        $_SESSION['message'] = 'Task added successfully';
        $this->redirect('/');
    }
    
    public function edit($id) {
        // Get task by ID
        $task = $this->model->getTaskById($id);
        
        if (!$task) {
            return $this->view->render('error', ['message' => 'Task not found']);
        }
        
        // Render the form view
        return $this->view->render('task_form', [
            'action' => 'edit',
            'task' => $task
        ]);
    }
    
    public function update($id) {
        // Get task by ID
        $task = $this->model->getTaskById($id);
        
        if (!$task) {
            return $this->view->render('error', ['message' => 'Task not found']);
        }
        
        // Validate and process form
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : 'pending';
        
        if (empty($title)) {
            return $this->view->render('task_form', [
                'action' => 'edit',
                'task' => $task,
                'error' => 'Title is required'
            ]);
        }
        
        // Update the task
        $result = $this->model->updateTask($id, $title, $description, $status);
        
        if (isset($result['error'])) {
            return $this->view->render('task_form', [
                'action' => 'edit',
                'task' => $task,
                'error' => $result['error']
            ]);
        }
        
        // Redirect to index with success message
        $_SESSION['message'] = 'Task updated successfully';
        $this->redirect('/');
    }
    
    public function delete($id) {
        // Get task by ID
        $task = $this->model->getTaskById($id);
        
        if (!$task) {
            return $this->view->render('error', ['message' => 'Task not found']);
        }
        
        // Delete the task
        $result = $this->model->deleteTask($id);
        
        if (isset($result['error'])) {
            return $this->view->render('error', ['message' => $result['error']]);
        }
        
        // Redirect to index with success message
        $_SESSION['message'] = 'Task deleted successfully';
        $this->redirect('/');
    }
    
    // Redirect helper
    private function redirect($path) {
        header('Location: ' . BASE_URL . $path);
        exit;
    }
}

// ========================
// VIEWS
// ========================
class View {
    public function render($template, $data = []) {
        // Extract data to make it available as variables in the template
        extract($data);
        
        // Start output buffering
        ob_start();
        
        // Include the header template
        $this->includeTemplate('header', $data);
        
        // Include the main template
        $this->includeTemplate($template, $data);
        
        // Include the footer template
        $this->includeTemplate('footer', $data);
        
        // Return the rendered content
        return ob_get_clean();
    }
    
    private function includeTemplate($template, $data) {
        // For this demo, templates are defined as methods in this class
        $method = 'template_' . $template;
        if (method_exists($this, $method)) {
            $this->$method($data);
        }
    }
    
    // Header template
    private function template_header($data) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>PHP MVC Application</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f0f0f0;
                    color: #333;
                }
                header {
                    background-color: #4a6fa5;
                    color: white;
                    padding: 20px;
                    text-align: center;
                }
                .container {
                    max-width: 1000px;
                    margin: 0 auto;
                    padding: 20px;
                }
                .card {
                    background-color: white;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    padding: 20px;
                    margin-bottom: 20px;
                }
                .message {
                    padding: 10px;
                    margin-bottom: 20px;
                    border-radius: 4px;
                }
                .message-success {
                    background-color: #d4edda;
                    border: 1px solid #c3e6cb;
                    color: #155724;
                }
                .message-error {
                    background-color: #f8d7da;
                    border: 1px solid #f5c6cb;
                    color: #721c24;
                }
                .nav {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 20px;
                }
                .btn {
                    display: inline-block;
                    background-color: #4a6fa5;
                    color: white;
                    padding: 8px 16px;
                    text-decoration: none;
                    border-radius: 4px;
                    border: none;
                    cursor: pointer;
                    font-size: 16px;
                }
                .btn:hover {
                    background-color: #3a5a80;
                }
                .btn-danger {
                    background-color: #dc3545;
                }
                .btn-danger:hover {
                    background-color: #c82333;
                }
                .form-group {
                    margin-bottom: 15px;
                }
                label {
                    display: block;
                    margin-bottom: 5px;
                    font-weight: bold;
                }
                input[type="text"], textarea, select {
                    width: 100%;
                    padding: 8px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    box-sizing: border-box;
                }
                textarea {
                    height: 100px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                th, td {
                    padding: 10px;
                    text-align: left;
                    border-bottom: 1px solid #ddd;
                }
                th {
                    background-color: #f2f2f2;
                }
                .task-title {
                    font-weight: bold;
                }
                .task-status {
                    padding: 4px 8px;
                    border-radius: 12px;
                    font-size: 12px;
                    font-weight: bold;
                    text-transform: uppercase;
                }
                .status-pending {
                    background-color: #ffeeba;
                    color: #856404;
                }
                .status-completed {
                    background-color: #c3e6cb;
                    color: #155724;
                }
                .actions {
                    display: flex;
                    gap: 10px;
                }
                footer {
                    text-align: center;
                    padding: 20px;
                    background-color: #4a6fa5;
                    color: white;
                    margin-top: 50px;
                }
                .docs {
                    margin-top: 60px;
                    padding: 20px;
                    background-color: #e9ecef;
                    border-radius: 8px;
                }
                .code {
                    background-color: #f8f9fa;
                    padding: 15px;
                    border-radius: 4px;
                    border: 1px solid #dee2e6;
                    font-family: monospace;
                    white-space: pre;
                    overflow-x: auto;
                }
            </style>
        </head>
        <body>
            <header>
                <h1>PHP MVC Application</h1>
                <p>A simple task management application built with the MVC architecture</p>
            </header>
            
            <div class="container">
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="message message-success">
                        <?php 
                        echo $_SESSION['message']; 
                        unset($_SESSION['message']);
                        ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($error)): ?>
                    <div class="message message-error">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
        <?php
    }
    
    // Footer template
    private function template_footer($data) {
        ?>
                
                <div class="docs">
                    <h2>Understanding MVC Architecture in PHP</h2>
                    <p>The Model-View-Controller (MVC) pattern separates an application into three main components:</p>
                    
                    <h3>Model</h3>
                    <p>Models represent the data structure and business logic of the application. They interact with the database and contain methods for CRUD operations.</p>
                    <div class="code">class TaskModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function getTasks() {
        // Database logic to get all tasks
    }
    
    // Other methods...
}</div>
                    
                    <h3>View</h3>
                    <p>Views are responsible for presenting the data to users in a formatted way. They should contain minimal logic, focused on display.</p>
                    <div class="code">class View {
    public function render($template, $data = []) {
        // Logic to display the template
    }
}</div>
                    
                    <h3>Controller</h3>
                    <p>Controllers act as the intermediary between Models and Views. They handle user requests, process input data, interact with Models, and determine which View to render.</p>
                    <div class="code">class TaskController {
    private $model;
    private $view;
    
    public function __construct() {
        $this->model = new TaskModel();
        $this->view = new View();
    }
    
    public function index() {
        $tasks = $this->model->getTasks();
        return $this->view->render('tasks_index', ['tasks' => $tasks]);
    }
    
    // Other methods...
}</div>
                    
                    <h3>Router</h3>
                    <p>A router directs the HTTP request to the appropriate controller action based on the URL.</p>
                    <div class="code">$router = new Router();
$router->parse($_SERVER['REQUEST_URI']);
$controller = $router->getController();
$action = $router->getAction();
$params = $router->getParams();</div>
                    
                    <h3>Benefits of MVC</h3>
                    <ul>
                        <li>Separation of concerns</li>
                        <li>Code organization and maintainability</li>
                        <li>Easier testing</li>
                        <li>Multiple developers can work on different components</li>
                        <li>Code reusability</li>
                    </ul>
                </div>
            </div>
            
            <footer>
                <p>PHP MVC Application Example - Experiment 15</p>
            </footer>
        </body>
        </html>
        <?php
    }
    
    // Tasks index template
    private function template_tasks_index($data) {
        $tasks = isset($data['tasks']) ? $data['tasks'] : [];
        $dbError = isset($tasks['error']) ? $tasks['error'] : null;
        ?>
        <div class="card">
            <div class="nav">
                <h2>Task List</h2>
                <a href="<?php echo BASE_URL; ?>/create" class="btn">Add New Task</a>
            </div>
            
            <?php if ($dbError): ?>
                <div class="message message-error">
                    <p>Database Error: <?php echo $dbError; ?></p>
                    <p>Check your database configuration or ensure XAMPP services are running.</p>
                </div>
            <?php elseif (empty($tasks)): ?>
                <p>No tasks found. Create your first task!</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task): ?>
                            <tr>
                                <td class="task-title"><?php echo htmlspecialchars($task['title']); ?></td>
                                <td>
                                    <span class="task-status status-<?php echo $task['status']; ?>">
                                        <?php echo $task['status']; ?>
                                    </span>
                                </td>
                                <td><?php echo date('M d, Y', strtotime($task['created_at'])); ?></td>
                                <td class="actions">
                                    <a href="<?php echo BASE_URL; ?>/show/<?php echo $task['id']; ?>" class="btn">View</a>
                                    <a href="<?php echo BASE_URL; ?>/edit/<?php echo $task['id']; ?>" class="btn">Edit</a>
                                    <form method="post" action="<?php echo BASE_URL; ?>/delete/<?php echo $task['id']; ?>" style="display:inline">
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        <?php
    }
    
    // Task detail template
    private function template_task_detail($data) {
        $task = isset($data['task']) ? $data['task'] : null;
        ?>
        <div class="card">
            <div class="nav">
                <h2>Task Details</h2>
                <a href="<?php echo BASE_URL; ?>/" class="btn">Back to List</a>
            </div>
            
            <?php if ($task): ?>
                <div class="form-group">
                    <label>Title:</label>
                    <div><?php echo htmlspecialchars($task['title']); ?></div>
                </div>
                
                <div class="form-group">
                    <label>Description:</label>
                    <div><?php echo nl2br(htmlspecialchars($task['description'])); ?></div>
                </div>
                
                <div class="form-group">
                    <label>Status:</label>
                    <div>
                        <span class="task-status status-<?php echo $task['status']; ?>">
                            <?php echo $task['status']; ?>
                        </span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Created At:</label>
                    <div><?php echo date('F d, Y h:i A', strtotime($task['created_at'])); ?></div>
                </div>
                
                <div class="actions">
                    <a href="<?php echo BASE_URL; ?>/edit/<?php echo $task['id']; ?>" class="btn">Edit</a>
                    <form method="post" action="<?php echo BASE_URL; ?>/delete/<?php echo $task['id']; ?>" style="display:inline">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </div>
            <?php else: ?>
                <p>Task not found.</p>
            <?php endif; ?>
        </div>
        <?php
    }
    
    // Task form template
    private function template_task_form($data) {
        $action = isset($data['action']) ? $data['action'] : 'add';
        $task = isset($data['task']) ? $data['task'] : null;
        $error = isset($data['error']) ? $data['error'] : null;
        $title = isset($data['title']) ? $data['title'] : ($task ? $task['title'] : '');
        $description = isset($data['description']) ? $data['description'] : ($task ? $task['description'] : '');
        $status = $task ? $task['status'] : 'pending';
        ?>
        <div class="card">
            <div class="nav">
                <h2><?php echo $action === 'add' ? 'Add New Task' : 'Edit Task'; ?></h2>
                <a href="<?php echo BASE_URL; ?>/" class="btn">Back to List</a>
            </div>
            
            <?php if ($error): ?>
                <div class="message message-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="post" action="<?php echo $action === 'add' ? BASE_URL . '/store' : BASE_URL . '/update/' . $task['id']; ?>">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description"><?php echo htmlspecialchars($description); ?></textarea>
                </div>
                
                <?php if ($action === 'edit'): ?>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="status" name="status">
                            <option value="pending" <?php echo $status === 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="completed" <?php echo $status === 'completed' ? 'selected' : ''; ?>>Completed</option>
                        </select>
                    </div>
                <?php endif; ?>
                
                <button type="submit" class="btn"><?php echo $action === 'add' ? 'Add Task' : 'Update Task'; ?></button>
            </form>
        </div>
        <?php
    }
    
    // Error template
    private function template_error($data) {
        $message = isset($data['message']) ? $data['message'] : 'An error occurred';
        ?>
        <div class="card">
            <div class="nav">
                <h2>Error</h2>
                <a href="<?php echo BASE_URL; ?>/" class="btn">Back to List</a>
            </div>
            
            <div class="message message-error">
                <?php echo $message; ?>
            </div>
        </div>
        <?php
    }
}

// ========================
// ROUTER
// ========================
class Router {
    private $controller = 'TaskController';
    private $action = 'index';
    private $params = [];
    
    public function __construct() {
        $this->parseUri();
    }
    
    public function parseUri() {
        $uri = $_SERVER['REQUEST_URI'];
        
        // Get the part of the URI after the base URL
        $baseUrlPath = parse_url(BASE_URL, PHP_URL_PATH);
        $path = str_replace($baseUrlPath, '', $uri);
        
        // Remove query string if present
        if (strpos($path, '?') !== false) {
            $path = substr($path, 0, strpos($path, '?'));
        }
        
        // Split the path into segments
        $segments = array_filter(explode('/', $path));
        
        // Set the action if present
        if (!empty($segments)) {
            $this->action = array_shift($segments);
        }
        
        // The rest are parameters
        $this->params = $segments;
    }
    
    public function getController() {
        return $this->controller;
    }
    
    public function getAction() {
        return $this->action;
    }
    
    public function getParams() {
        return $this->params;
    }
}

// ========================
// APPLICATION
// ========================
class Application {
    public function run() {
        // Create a router
        $router = new Router();
        
        // Get the controller, action and parameters
        $controllerName = $router->getController();
        $actionName = $router->getAction();
        $params = $router->getParams();
        
        // Create the controller
        $controller = new $controllerName();
        
        // Call the action with parameters
        $output = '';
        
        if (method_exists($controller, $actionName)) {
            $output = call_user_func_array([$controller, $actionName], $params);
        } else {
            // Default to index if action doesn't exist
            $output = $controller->index();
        }
        
        // Output the result
        echo $output;
    }
}

// Run the application
$app = new Application();
$app->run();
