<?php
// Define the service class and its methods
class WeatherService {
    private $weatherData = [
        'New York' => [
            'temperature' => 72,
            'condition' => 'Sunny',
            'humidity' => 45
        ],
        'London' => [
            'temperature' => 65,
            'condition' => 'Cloudy',
            'humidity' => 78
        ],
        'Tokyo' => [
            'temperature' => 82,
            'condition' => 'Partly Cloudy',
            'humidity' => 60
        ],
        'Sydney' => [
            'temperature' => 85,
            'condition' => 'Clear',
            'humidity' => 40
        ],
        'Paris' => [
            'temperature' => 70,
            'condition' => 'Rainy',
            'humidity' => 85
        ]
    ];
    
    /**
     * Get weather information for a given city
     */
    public function getWeather($city) {
        if (isset($this->weatherData[$city])) {
            return $this->weatherData[$city];
        } else {
            return ['error' => 'City not found'];
        }
    }
    
    /**
     * Get all available cities
     */
    public function getAvailableCities() {
        return array_keys($this->weatherData);
    }
    
    /**
     * Add a new city with weather data
     */
    public function addCity($city, $temperature, $condition, $humidity) {
        $this->weatherData[$city] = [
            'temperature' => (int)$temperature,
            'condition' => $condition,
            'humidity' => (int)$humidity
        ];
        return ['status' => 'success', 'message' => "City $city added successfully"];
    }
}

// Check if this is an API request or a web page request
$isApiRequest = isset($_GET['api']) && $_GET['api'] === 'true';

// Handle API requests
if ($isApiRequest) {
    header('Content-Type: application/json');
    $weatherService = new WeatherService();
    $response = ['error' => 'Invalid action'];
    
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'getWeather':
                if (isset($_GET['city'])) {
                    $response = $weatherService->getWeather($_GET['city']);
                } else {
                    $response = ['error' => 'City parameter is required'];
                }
                break;
                
            case 'getCities':
                $response = $weatherService->getAvailableCities();
                break;
                
            case 'addCity':
                // For POST requests to add a new city
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (
                        isset($_POST['city']) && 
                        isset($_POST['temperature']) && 
                        isset($_POST['condition']) && 
                        isset($_POST['humidity'])
                    ) {
                        $response = $weatherService->addCity(
                            $_POST['city'],
                            $_POST['temperature'],
                            $_POST['condition'],
                            $_POST['humidity']
                        );
                    } else {
                        $response = ['error' => 'Missing required parameters'];
                    }
                } else {
                    $response = ['error' => 'This action requires a POST request'];
                }
                break;
        }
    }
    
    echo json_encode($response);
    exit;
}

// Handle client-side demo interactions
$result = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simulate API calls from client side
    if (isset($_POST['client_action'])) {
        $weatherService = new WeatherService();
        
        switch ($_POST['client_action']) {
            case 'getWeather':
                if (isset($_POST['city'])) {
                    $weatherData = $weatherService->getWeather($_POST['city']);
                    if (isset($weatherData['error'])) {
                        $result = "Error: " . $weatherData['error'];
                    } else {
                        $result = "Weather for {$_POST['city']}:<br>
                                   Temperature: {$weatherData['temperature']}°F<br>
                                   Condition: {$weatherData['condition']}<br>
                                   Humidity: {$weatherData['humidity']}%";
                    }
                }
                break;
                
            case 'addCityDemo':
                if (
                    isset($_POST['new_city']) && 
                    isset($_POST['new_temperature']) && 
                    isset($_POST['new_condition']) && 
                    isset($_POST['new_humidity'])
                ) {
                    $response = $weatherService->addCity(
                        $_POST['new_city'],
                        $_POST['new_temperature'],
                        $_POST['new_condition'],
                        $_POST['new_humidity']
                    );
                    $result = $response['message'];
                }
                break;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP Web Services</title>
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
        .form-group {
            margin-bottom: 15px;
        }
        input[type="text"], input[type="number"] {
            padding: 8px;
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        select {
            padding: 8px;
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4a6fa5;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #3a5a80;
        }
        .tabs {
            display: flex;
            margin-bottom: 20px;
        }
        .tab {
            padding: 10px 20px;
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            cursor: pointer;
            margin-right: 5px;
        }
        .tab.active {
            background-color: #4a6fa5;
            color: white;
            border-color: #4a6fa5;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        .result {
            margin-top: 15px;
            padding: 15px;
            background-color: #d1ecf1;
            border-radius: 5px;
            border: 1px solid #bee5eb;
            color: #0c5460;
        }
        .api-url {
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 5px;
            margin: 10px 0;
            font-family: 'Courier New', Courier, monospace;
            word-break: break-all;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PHP Web Services</h1>
        
        <div class="tabs">
            <div class="tab active" onclick="switchTab('client')">Client Demo</div>
            <div class="tab" onclick="switchTab('api')">API Documentation</div>
            <div class="tab" onclick="switchTab('code')">Implementation</div>
        </div>
        
        <div id="client" class="tab-content active">
            <div class="section">
                <h2>Weather Service Client Demo</h2>
                <p>This demo allows you to interact with the Weather Service API.</p>
                
                <h3>Get Weather for a City</h3>
                <form method="post">
                    <input type="hidden" name="client_action" value="getWeather">
                    <div class="form-group">
                        <label for="city">Select a City:</label>
                        <select id="city" name="city" required>
                            <option value="">-- Select a City --</option>
                            <?php 
                            $weatherService = new WeatherService();
                            $cities = $weatherService->getAvailableCities();
                            foreach ($cities as $city) {
                                echo "<option value=\"$city\">$city</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit">Get Weather</button>
                </form>
                
                <h3>Add a New City</h3>
                <form method="post">
                    <input type="hidden" name="client_action" value="addCityDemo">
                    <div class="form-group">
                        <label for="new_city">City Name:</label>
                        <input type="text" id="new_city" name="new_city" required>
                    </div>
                    <div class="form-group">
                        <label for="new_temperature">Temperature (°F):</label>
                        <input type="number" id="new_temperature" name="new_temperature" required>
                    </div>
                    <div class="form-group">
                        <label for="new_condition">Weather Condition:</label>
                        <input type="text" id="new_condition" name="new_condition" required>
                    </div>
                    <div class="form-group">
                        <label for="new_humidity">Humidity (%):</label>
                        <input type="number" id="new_humidity" name="new_humidity" required min="0" max="100">
                    </div>
                    <button type="submit">Add City</button>
                </form>
                
                <?php if (!empty($result)): ?>
                    <div class="result">
                        <h3>Result</h3>
                        <p><?php echo $result; ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div id="api" class="tab-content">
            <div class="section">
                <h2>Weather Service API Documentation</h2>
                <p>This service provides weather information for various cities through a RESTful API.</p>
                
                <div class="example">
                    <h3>Get Weather for a City</h3>
                    <p><strong>Endpoint:</strong> <span class="api-url">?api=true&action=getWeather&city={city_name}</span></p>
                    <p><strong>Method:</strong> GET</p>
                    <p><strong>Example Response:</strong></p>
                    <pre><code>{
    "temperature": 72,
    "condition": "Sunny",
    "humidity": 45
}</code></pre>
                </div>
                
                <div class="example">
                    <h3>Get Available Cities</h3>
                    <p><strong>Endpoint:</strong> <span class="api-url">?api=true&action=getCities</span></p>
                    <p><strong>Method:</strong> GET</p>
                    <p><strong>Example Response:</strong></p>
                    <pre><code>["New York", "London", "Tokyo", "Sydney", "Paris"]</code></pre>
                </div>
                
                <div class="example">
                    <h3>Add a New City</h3>
                    <p><strong>Endpoint:</strong> <span class="api-url">?api=true&action=addCity</span></p>
                    <p><strong>Method:</strong> POST</p>
                    <p><strong>Parameters:</strong></p>
                    <ul>
                        <li><code>city</code> - Name of the city</li>
                        <li><code>temperature</code> - Temperature in Fahrenheit</li>
                        <li><code>condition</code> - Weather condition</li>
                        <li><code>humidity</code> - Humidity percentage</li>
                    </ul>
                    <p><strong>Example Response:</strong></p>
                    <pre><code>{
    "status": "success",
    "message": "City Berlin added successfully"
}</code></pre>
                </div>
                
                <h3>Testing the API with curl</h3>
                <p>You can test these endpoints using curl commands:</p>
                <pre><code># Get weather for New York
curl "http://localhost/path/to/35_web_services.php?api=true&action=getWeather&city=New%20York"

# Get all available cities
curl "http://localhost/path/to/35_web_services.php?api=true&action=getCities"

# Add a new city
curl -X POST "http://localhost/path/to/35_web_services.php?api=true&action=addCity" \
  -d "city=Berlin&temperature=68&condition=Cloudy&humidity=72"</code></pre>
            </div>
        </div>
        
        <div id="code" class="tab-content">
            <div class="section">
                <h2>PHP Web Services Implementation</h2>
                <p>Here's how this web service is implemented:</p>
                
                <div class="example">
                    <h3>Creating a Simple Web Service</h3>
                    <p>PHP makes it easy to create web services that can respond to HTTP requests and return data in JSON format.</p>
                    <pre><code>// Set the content type to JSON
header('Content-Type: application/json');

// Process the request
$data = array('message' => 'Hello, World!');

// Return the response as JSON
echo json_encode($data);</code></pre>
                </div>
                
                <div class="example">
                    <h3>RESTful API Principles</h3>
                    <p>RESTful APIs typically follow these principles:</p>
                    <ul>
                        <li>Use HTTP methods appropriately (GET, POST, PUT, DELETE)</li>
                        <li>Return appropriate status codes (200 OK, 404 Not Found, etc.)</li>
                        <li>Structure URLs around resources, not actions</li>
                        <li>Return data in a standard format (usually JSON)</li>
                    </ul>
                </div>
                
                <div class="example">
                    <h3>SOAP vs REST</h3>
                    <p>Web services can be implemented using different architectures:</p>
                    <table>
                        <tr>
                            <th>SOAP</th>
                            <th>REST</th>
                        </tr>
                        <tr>
                            <td>Uses XML for message format</td>
                            <td>Can use JSON, XML, or other formats</td>
                        </tr>
                        <tr>
                            <td>Protocol specific</td>
                            <td>Architectural style</td>
                        </tr>
                        <tr>
                            <td>More rigid, formal</td>
                            <td>More flexible, lightweight</td>
                        </tr>
                        <tr>
                            <td>Built-in error handling</td>
                            <td>Relies on HTTP status codes</td>
                        </tr>
                    </table>
                </div>
                
                <div class="example">
                    <h3>Consuming Web Services in PHP</h3>
                    <p>PHP provides several ways to consume web services:</p>
                    <pre><code>// Using file_get_contents
$json = file_get_contents('https://api.example.com/data');
$data = json_decode($json, true);

// Using cURL
$ch = curl_init('https://api.example.com/data');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$json = curl_exec($ch);
curl_close($ch);
$data = json_decode($json, true);

// Using Guzzle HTTP library
use GuzzleHttp\Client;
$client = new Client();
$response = $client->request('GET', 'https://api.example.com/data');
$data = json_decode($response->getBody(), true);</code></pre>
                </div>
            </div>
        </div>
        
        <div class="section">
            <h2>Web Services in PHP</h2>
            <p>Web services allow different systems to communicate over a network, typically using standard web protocols like HTTP. They enable applications to exchange data regardless of the programming languages or platforms they use.</p>
            
            <p>PHP supports various web service architectures:</p>
            <ul>
                <li><strong>REST (Representational State Transfer)</strong> - A lightweight approach using standard HTTP methods</li>
                <li><strong>SOAP (Simple Object Access Protocol)</strong> - A protocol that uses XML for message format</li>
                <li><strong>XML-RPC</strong> - A remote procedure call protocol using XML to encode calls</li>
                <li><strong>JSON-RPC</strong> - Similar to XML-RPC but uses JSON instead of XML</li>
            </ul>
            
            <p>The example on this page demonstrates a simple RESTful API for weather data, showing how to both create and consume web services in PHP.</p>
        </div>
    </div>

    <script>
        function switchTab(tabId) {
            // Hide all tab contents
            var tabContents = document.getElementsByClassName('tab-content');
            for (var i = 0; i < tabContents.length; i++) {
                tabContents[i].classList.remove('active');
            }
            
            // Deactivate all tabs
            var tabs = document.getElementsByClassName('tab');
            for (var i = 0; i < tabs.length; i++) {
                tabs[i].classList.remove('active');
            }
            
            // Activate the selected tab and content
            document.getElementById(tabId).classList.add('active');
            
            // Find and activate the tab button
            var tabs = document.getElementsByClassName('tab');
            for (var i = 0; i < tabs.length; i++) {
                if (tabs[i].textContent.toLowerCase().includes(tabId.toLowerCase())) {
                    tabs[i].classList.add('active');
                    break;
                }
            }
        }
    </script>
</body>
</html>
