<!DOCTYPE html>
<html>
<head>
    <title>PHP AJAX Implementation</title>
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
        select {
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
        #user-data-container {
            margin-top: 20px;
        }
        .user-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f8f9fa;
            transition: transform 0.3s;
        }
        .user-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }
        .loading:after {
            content: " .";
            animation: dots 1s steps(5, end) infinite;
        }
        @keyframes dots {
            0%, 20% {
                color: rgba(0,0,0,0);
                text-shadow: .25em 0 0 rgba(0,0,0,0), .5em 0 0 rgba(0,0,0,0);
            }
            40% {
                color: #333;
                text-shadow: .25em 0 0 rgba(0,0,0,0), .5em 0 0 rgba(0,0,0,0);
            }
            60% {
                text-shadow: .25em 0 0 #333, .5em 0 0 rgba(0,0,0,0);
            }
            80%, 100% {
                text-shadow: .25em 0 0 #333, .5em 0 0 #333;
            }
        }
        #search-results {
            margin-top: 20px;
        }
        .search-item {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .search-item:hover {
            background-color: #f0f0f0;
        }
        .ajax-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 5px;
            background-color: #4a6fa5;
            color: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            opacity: 0;
            transform: translateY(-50px);
            transition: all 0.5s;
            z-index: 1000;
        }
        .ajax-notification.show {
            opacity: 1;
            transform: translateY(0);
        }
        .progress-container {
            width: 100%;
            background-color: #ddd;
            border-radius: 4px;
            margin: 10px 0;
        }
        .progress-bar {
            height: 20px;
            width: 0;
            background-color: #4a6fa5;
            border-radius: 4px;
            transition: width 0.3s;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PHP AJAX Implementation</h1>
        
        <?php
        // If this file receives an AJAX request, process it
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            // Set the content type to JSON
            header('Content-Type: application/json');
            
            // Handle different AJAX endpoints
            if(isset($_GET['action'])) {
                $action = $_GET['action'];
                
                switch($action) {
                    case 'get_users':
                        // Simulate fetching users from a database
                        sleep(1); // Simulate network delay
                        $users = [
                            ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'role' => 'Admin'],
                            ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'role' => 'User'],
                            ['id' => 3, 'name' => 'Bob Johnson', 'email' => 'bob@example.com', 'role' => 'Editor'],
                            ['id' => 4, 'name' => 'Alice Williams', 'email' => 'alice@example.com', 'role' => 'User'],
                            ['id' => 5, 'name' => 'Charlie Brown', 'email' => 'charlie@example.com', 'role' => 'Moderator']
                        ];
                        echo json_encode($users);
                        break;
                        
                    case 'get_user':
                        // Simulate fetching a single user by ID
                        if(isset($_GET['id'])) {
                            $id = (int)$_GET['id'];
                            sleep(1); // Simulate network delay
                            
                            // Sample user data
                            $users = [
                                1 => [
                                    'id' => 1,
                                    'name' => 'John Doe',
                                    'email' => 'john@example.com',
                                    'role' => 'Admin',
                                    'bio' => 'John is a senior developer with 10 years of experience.',
                                    'skills' => ['PHP', 'JavaScript', 'MySQL', 'React']
                                ],
                                2 => [
                                    'id' => 2,
                                    'name' => 'Jane Smith',
                                    'email' => 'jane@example.com',
                                    'role' => 'User',
                                    'bio' => 'Jane is a UX designer focused on creating intuitive interfaces.',
                                    'skills' => ['UI/UX', 'Figma', 'Adobe XD', 'HTML/CSS']
                                ],
                                3 => [
                                    'id' => 3,
                                    'name' => 'Bob Johnson',
                                    'email' => 'bob@example.com',
                                    'role' => 'Editor',
                                    'bio' => 'Bob specializes in content management and editing.',
                                    'skills' => ['Content Writing', 'Proofreading', 'SEO', 'WordPress']
                                ],
                                4 => [
                                    'id' => 4,
                                    'name' => 'Alice Williams',
                                    'email' => 'alice@example.com',
                                    'role' => 'User',
                                    'bio' => 'Alice is a data analyst who loves working with numbers.',
                                    'skills' => ['Data Analysis', 'Python', 'R', 'Tableau']
                                ],
                                5 => [
                                    'id' => 5,
                                    'name' => 'Charlie Brown',
                                    'email' => 'charlie@example.com',
                                    'role' => 'Moderator',
                                    'bio' => 'Charlie manages community discussions and ensures quality content.',
                                    'skills' => ['Communication', 'Conflict Resolution', 'Content Moderation']
                                ]
                            ];
                            
                            if(isset($users[$id])) {
                                echo json_encode($users[$id]);
                            } else {
                                echo json_encode(['error' => 'User not found']);
                            }
                        } else {
                            echo json_encode(['error' => 'No user ID provided']);
                        }
                        break;
                        
                    case 'search':
                        // Simulate search functionality
                        if(isset($_GET['query'])) {
                            $query = strtolower($_GET['query']);
                            sleep(1); // Simulate network delay
                            
                            // Sample data to search through
                            $data = [
                                ['id' => 1, 'name' => 'PHP Basics', 'category' => 'Programming'],
                                ['id' => 2, 'name' => 'Advanced JavaScript', 'category' => 'Programming'],
                                ['id' => 3, 'name' => 'MySQL Database', 'category' => 'Database'],
                                ['id' => 4, 'name' => 'Web Design Principles', 'category' => 'Design'],
                                ['id' => 5, 'name' => 'Server Administration', 'category' => 'DevOps'],
                                ['id' => 6, 'name' => 'AJAX in PHP', 'category' => 'Programming'],
                                ['id' => 7, 'name' => 'Responsive CSS', 'category' => 'Design'],
                                ['id' => 8, 'name' => 'NoSQL Databases', 'category' => 'Database'],
                                ['id' => 9, 'name' => 'React Framework', 'category' => 'Programming'],
                                ['id' => 10, 'name' => 'Docker Containers', 'category' => 'DevOps'],
                            ];
                            
                            // Filter results based on query
                            $results = [];
                            foreach($data as $item) {
                                if(strpos(strtolower($item['name']), $query) !== false || 
                                   strpos(strtolower($item['category']), $query) !== false) {
                                    $results[] = $item;
                                }
                            }
                            
                            echo json_encode($results);
                        } else {
                            echo json_encode(['error' => 'No search query provided']);
                        }
                        break;
                        
                    case 'submit_form':
                        // Process POST data from AJAX form submission
                        if($_SERVER['REQUEST_METHOD'] === 'POST') {
                            sleep(2); // Simulate network delay
                            
                            $name = isset($_POST['name']) ? $_POST['name'] : '';
                            $email = isset($_POST['email']) ? $_POST['email'] : '';
                            $message = isset($_POST['message']) ? $_POST['message'] : '';
                            
                            // Simple validation
                            $errors = [];
                            if(empty($name)) {
                                $errors[] = 'Name is required';
                            }
                            if(empty($email)) {
                                $errors[] = 'Email is required';
                            } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                $errors[] = 'Invalid email format';
                            }
                            if(empty($message)) {
                                $errors[] = 'Message is required';
                            }
                            
                            if(empty($errors)) {
                                // In a real application, you would save the data to a database here
                                echo json_encode([
                                    'success' => true,
                                    'message' => 'Thank you! Your message has been received.'
                                ]);
                            } else {
                                echo json_encode([
                                    'success' => false,
                                    'errors' => $errors
                                ]);
                            }
                        } else {
                            echo json_encode(['error' => 'Invalid request method']);
                        }
                        break;
                        
                    default:
                        echo json_encode(['error' => 'Unknown action']);
                        break;
                }
            } else {
                echo json_encode(['error' => 'No action specified']);
            }
            
            // Exit to prevent the rest of the page from loading
            exit;
        }
        ?>
        
        <div class="section">
            <h2>1. Basic AJAX Data Loading</h2>
            <p>This example demonstrates loading user data from the server without refreshing the page.</p>
            
            <button id="load-users-btn" onclick="loadUsers()">Load Users</button>
            <div id="loading-users" class="loading">Loading users</div>
            
            <div id="user-data-container"></div>
            
            <div class="example">
                <h3>How it Works:</h3>
                <ol>
                    <li>User clicks the "Load Users" button</li>
                    <li>JavaScript makes an AJAX request to the server</li>
                    <li>Server processes the request and returns JSON data</li>
                    <li>JavaScript updates the page with the received data</li>
                </ol>
            </div>
        </div>
        
        <div class="section">
            <h2>2. AJAX Search with Live Results</h2>
            <p>Type in the search box below to see live search results without page reload.</p>
            
            <div>
                <input type="text" id="search-input" placeholder="Search topics..." onkeyup="performSearch(this.value)">
                <p class="note">Try searching for terms like "php", "database", "design", etc.</p>
            </div>
            <div id="loading-search" class="loading">Searching</div>
            <div id="search-results"></div>
            
            <div class="example">
                <h3>Code Explanation:</h3>
                <pre><code>// Client-side JavaScript
function performSearch(query) {
    if (query.length < 2) {
        document.getElementById('search-results').innerHTML = '';
        return;
    }
    
    // Show loading indicator
    document.getElementById('loading-search').style.display = 'block';
    
    // Make AJAX request
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `?action=search&query=${encodeURIComponent(query)}`, true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    
    xhr.onload = function() {
        if (xhr.status === 200) {
            const results = JSON.parse(xhr.responseText);
            displaySearchResults(results);
        }
        document.getElementById('loading-search').style.display = 'none';
    };
    
    xhr.send();
}

// Server-side PHP (simplified)
if(isset($_GET['action']) && $_GET['action'] === 'search') {
    $query = strtolower($_GET['query']);
    // Search through data and filter results
    $results = array_filter($data, function($item) use ($query) {
        return strpos(strtolower($item['name']), $query) !== false;
    });
    echo json_encode($results);
}</code></pre>
            </div>
        </div>
        
        <div class="section">
            <h2>3. AJAX Form Submission</h2>
            <p>Submit this form without refreshing the page using AJAX.</p>
            
            <form id="contact-form" onsubmit="return submitForm(this)">
                <div>
                    <label for="name">Name:</label><br>
                    <input type="text" id="name" name="name" required>
                </div>
                <div>
                    <label for="email">Email:</label><br>
                    <input type="email" id="email" name="email" required>
                </div>
                <div>
                    <label for="message">Message:</label><br>
                    <textarea id="message" name="message" style="width: 300px; height: 100px;" required></textarea>
                </div>
                <button type="submit">Submit</button>
            </form>
            
            <div id="form-response"></div>
            
            <div class="example">
                <h3>Benefits of AJAX Form Submission:</h3>
                <ul>
                    <li>Better user experience - no page refreshing</li>
                    <li>Instant feedback to the user</li>
                    <li>Ability to validate form data on the server before final submission</li>
                    <li>Can update multiple parts of the page based on the form submission</li>
                </ul>
            </div>
        </div>
        
        <div class="section">
            <h2>4. AJAX with File Upload & Progress Bar</h2>
            <p>This example shows how to upload files with AJAX and display a progress bar.</p>
            
            <form id="upload-form">
                <div>
                    <label for="file">Select File:</label><br>
                    <input type="file" id="file" name="file">
                    <p class="note">Select any file to see the progress bar simulation</p>
                </div>
                
                <div class="progress-container" style="display: none;" id="progress-container">
                    <div class="progress-bar" id="progress-bar"></div>
                    <div id="progress-text">0%</div>
                </div>
                
                <button type="button" onclick="simulateFileUpload()">Upload File</button>
            </form>
            
            <div id="upload-response"></div>
            
            <div class="example">
                <h3>Real Implementation with PHP:</h3>
                <pre><code>// Client-side JavaScript for file upload with progress
const formData = new FormData();
formData.append('file', document.getElementById('file').files[0]);

const xhr = new XMLHttpRequest();
xhr.open('POST', 'upload.php', true);

// Track upload progress
xhr.upload.addEventListener('progress', function(e) {
    if (e.lengthComputable) {
        const percentComplete = (e.loaded / e.total) * 100;
        document.getElementById('progress-bar').style.width = percentComplete + '%';
        document.getElementById('progress-text').textContent = Math.round(percentComplete) + '%';
    }
});

xhr.onload = function() {
    if (xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        if (response.success) {
            document.getElementById('upload-response').innerHTML = 
                `<div class="result">${response.message}</div>`;
        } else {
            document.getElementById('upload-response').innerHTML = 
                `<div class="error">${response.error}</div>`;
        }
    }
};

xhr.send(formData);

// Server-side PHP (simplified)
if(isset($_FILES['file'])) {
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($_FILES['file']['name']);
    
    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
        echo json_encode([
            'success' => true,
            'message' => 'File uploaded successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Failed to upload file'
        ]);
    }
}</code></pre>
            </div>
        </div>
        
        <div id="ajax-notification" class="ajax-notification"></div>
        
        <div class="section">
            <h2>Understanding AJAX in PHP</h2>
            
            <div class="example">
                <h3>What is AJAX?</h3>
                <p>AJAX stands for <strong>Asynchronous JavaScript and XML</strong>. It allows web pages to be updated asynchronously by exchanging data with a server behind the scenes. This means you can update parts of a web page without reloading the whole page.</p>
            </div>
            
            <div class="example">
                <h3>Core AJAX Components:</h3>
                <table>
                    <tr>
                        <th>Component</th>
                        <th>Description</th>
                    </tr>
                    <tr>
                        <td>XMLHttpRequest Object</td>
                        <td>The JavaScript object used to make asynchronous requests</td>
                    </tr>
                    <tr>
                        <td>JavaScript/DOM</td>
                        <td>Used to display and interact with the information</td>
                    </tr>
                    <tr>
                        <td>JSON/XML/HTML/Text</td>
                        <td>Common formats for data exchange (JSON most popular now)</td>
                    </tr>
                    <tr>
                        <td>PHP (Server-side)</td>
                        <td>Processes requests and returns data</td>
                    </tr>
                </table>
            </div>
            
            <div class="example">
                <h3>Modern AJAX Implementations:</h3>
                <ol>
                    <li>
                        <strong>XMLHttpRequest (Traditional):</strong>
                        <pre><code>const xhr = new XMLHttpRequest();
xhr.open('GET', 'data.php', true);
xhr.onload = function() {
    if (xhr.status === 200) {
        const data = JSON.parse(xhr.responseText);
        // Process data
    }
};
xhr.send();</code></pre>
                    </li>
                    <li>
                        <strong>Fetch API (Modern):</strong>
                        <pre><code>fetch('data.php')
    .then(response => response.json())
    .then(data => {
        // Process data
    })
    .catch(error => console.error('Error:', error));</code></pre>
                    </li>
                    <li>
                        <strong>jQuery AJAX (Library-based):</strong>
                        <pre><code>$.ajax({
    url: 'data.php',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
        // Process data
    },
    error: function(xhr, status, error) {
        console.error(error);
    }
});</code></pre>
                    </li>
                    <li>
                        <strong>Axios (Promise-based HTTP client):</strong>
                        <pre><code>axios.get('data.php')
    .then(response => {
        // Process response.data
    })
    .catch(error => {
        console.error(error);
    });</code></pre>
                    </li>
                </ol>
            </div>
            
            <div class="example">
                <h3>PHP Server-Side Response:</h3>
                <pre><code>// Check if it's an AJAX request
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
   strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    
    // Set the appropriate content type for JSON
    header('Content-Type: application/json');
    
    // Process request and prepare data
    $data = [
        'status' => 'success',
        'message' => 'Data loaded successfully',
        'items' => [
            ['id' => 1, 'name' => 'Item 1'],
            ['id' => 2, 'name' => 'Item 2']
        ]
    ];
    
    // Output JSON-encoded data
    echo json_encode($data);
    exit; // Prevent the rest of the page from loading
}</code></pre>
            </div>
        </div>
    </div>

    <script>
        // Function to load users data
        function loadUsers() {
            // Show loading indicator
            document.getElementById('loading-users').style.display = 'block';
            document.getElementById('user-data-container').innerHTML = '';
            
            // Create XMLHttpRequest object
            const xhr = new XMLHttpRequest();
            xhr.open('GET', '?action=get_users', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            
            // Define what happens on successful data submission
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const users = JSON.parse(xhr.responseText);
                    displayUsers(users);
                    
                    // Show notification
                    showNotification('Users loaded successfully!');
                }
                document.getElementById('loading-users').style.display = 'none';
            };
            
            // Define what happens in case of error
            xhr.onerror = function() {
                document.getElementById('user-data-container').innerHTML = '<div class="error">Request failed. Please try again.</div>';
                document.getElementById('loading-users').style.display = 'none';
            };
            
            // Send the request
            xhr.send();
        }
        
        // Function to display users in the container
        function displayUsers(users) {
            const container = document.getElementById('user-data-container');
            let html = '<h3>User List</h3>';
            
            users.forEach(user => {
                html += `
                    <div class="user-card" onclick="getUserDetails(${user.id})">
                        <h4>${user.name}</h4>
                        <p><strong>Email:</strong> ${user.email}</p>
                        <p><strong>Role:</strong> ${user.role}</p>
                        <p class="note">Click for more details</p>
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }
        
        // Function to get user details
        function getUserDetails(id) {
            // Show loading indicator in the notification area
            showNotification('Loading user details...', false);
            
            // Create XMLHttpRequest object
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `?action=get_user&id=${id}`, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            
            // Define what happens on successful data submission
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const userData = JSON.parse(xhr.responseText);
                    
                    if (userData.error) {
                        showNotification('Error: ' + userData.error);
                        return;
                    }
                    
                    // Display detailed user info
                    let skillsHtml = '';
                    if (userData.skills && userData.skills.length > 0) {
                        skillsHtml = '<p><strong>Skills:</strong> ' + userData.skills.join(', ') + '</p>';
                    }
                    
                    const userDetailHtml = `
                        <div class="example">
                            <h3>User Details: ${userData.name}</h3>
                            <p><strong>Email:</strong> ${userData.email}</p>
                            <p><strong>Role:</strong> ${userData.role}</p>
                            <p><strong>Bio:</strong> ${userData.bio || 'No bio available.'}</p>
                            ${skillsHtml}
                        </div>
                    `;
                    
                    // Find the user card and update it
                    const userCards = document.querySelectorAll('.user-card');
                    for (let i = 0; i < userCards.length; i++) {
                        if (userCards[i].querySelector('h4').textContent === userData.name) {
                            userCards[i].insertAdjacentHTML('afterend', userDetailHtml);
                            break;
                        }
                    }
                    
                    showNotification('User details loaded!');
                }
            };
            
            // Send the request
            xhr.send();
        }
        
        // Function to perform search
        function performSearch(query) {
            // Don't search for very short queries
            if (query.length < 2) {
                document.getElementById('search-results').innerHTML = '';
                return;
            }
            
            // Show loading indicator
            document.getElementById('loading-search').style.display = 'block';
            
            // Create XMLHttpRequest object
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `?action=search&query=${encodeURIComponent(query)}`, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            
            // Define what happens on successful data submission
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const results = JSON.parse(xhr.responseText);
                    displaySearchResults(results, query);
                }
                document.getElementById('loading-search').style.display = 'none';
            };
            
            // Send the request
            xhr.send();
        }
        
        // Function to display search results
        function displaySearchResults(results, query) {
            const container = document.getElementById('search-results');
            
            if (results.length === 0) {
                container.innerHTML = `<div class="note">No results found for "${query}"</div>`;
                return;
            }
            
            let html = `<h3>Search Results for "${query}"</h3>`;
            
            results.forEach(item => {
                html += `
                    <div class="search-item" onclick="showNotification('Selected: ${item.name}')">
                        <strong>${item.name}</strong>
                        <div>Category: ${item.category}</div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }
        
        // Function to submit form via AJAX
        function submitForm(form) {
            // Collect form data
            const formData = new FormData(form);
            
            // Show loading message in form response area
            document.getElementById('form-response').innerHTML = '<div class="loading">Submitting form</div>';
            
            // Create XMLHttpRequest object
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '?action=submit_form', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            
            // Define what happens on successful data submission
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    
                    if (response.success) {
                        document.getElementById('form-response').innerHTML = 
                            `<div class="result">${response.message}</div>`;
                        form.reset(); // Clear the form
                    } else {
                        let errorHtml = '<div class="error"><strong>Errors:</strong><ul>';
                        response.errors.forEach(error => {
                            errorHtml += `<li>${error}</li>`;
                        });
                        errorHtml += '</ul></div>';
                        document.getElementById('form-response').innerHTML = errorHtml;
                    }
                }
            };
            
            // Define what happens in case of error
            xhr.onerror = function() {
                document.getElementById('form-response').innerHTML = 
                    '<div class="error">Request failed. Please try again.</div>';
            };
            
            // Send the data
            xhr.send(formData);
            
            // Prevent the default form submission
            return false;
        }
        
        // Function to simulate file upload with progress bar
        function simulateFileUpload() {
            const fileInput = document.getElementById('file');
            
            if (!fileInput.files.length) {
                document.getElementById('upload-response').innerHTML = 
                    '<div class="error">Please select a file first.</div>';
                return;
            }
            
            // Get the file info
            const file = fileInput.files[0];
            const fileName = file.name;
            const fileSize = (file.size / 1024).toFixed(2) + ' KB';
            
            // Show progress container
            const progressContainer = document.getElementById('progress-container');
            const progressBar = document.getElementById('progress-bar');
            const progressText = document.getElementById('progress-text');
            
            progressContainer.style.display = 'block';
            progressBar.style.width = '0%';
            progressText.textContent = '0%';
            
            document.getElementById('upload-response').innerHTML = '';
            
            // Simulate upload progress
            let progress = 0;
            const interval = setInterval(() => {
                progress += Math.random() * 10;
                if (progress > 100) progress = 100;
                
                progressBar.style.width = progress + '%';
                progressText.textContent = Math.round(progress) + '%';
                
                if (progress === 100) {
                    clearInterval(interval);
                    
                    // Simulate server response delay
                    setTimeout(() => {
                        document.getElementById('upload-response').innerHTML = `
                            <div class="result">
                                <strong>File uploaded successfully!</strong><br>
                                File name: ${fileName}<br>
                                Size: ${fileSize}
                            </div>
                        `;
                        showNotification('File uploaded successfully!');
                    }, 500);
                }
            }, 200);
        }
        
        // Function to show notification
        function showNotification(message, autoHide = true) {
            const notification = document.getElementById('ajax-notification');
            notification.textContent = message;
            notification.classList.add('show');
            
            if (autoHide) {
                setTimeout(() => {
                    notification.classList.remove('show');
                }, 3000);
            }
        }
    </script>
</body>
</html>
