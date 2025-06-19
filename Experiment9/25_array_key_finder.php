<!DOCTYPE html>
<html>
<head>
    <title>Array Key Finder</title>
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
        .function-name {
            font-weight: bold;
            color: #4a6fa5;
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
        input[type="text"] {
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
        .highlight {
            background-color: #ffeeba;
            padding: 2px 4px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PHP Array Key Finder</h1>
        
        <div class="section">
            <h2>1. Predefined Array Examples</h2>
            
            <?php
            // Define example arrays
            $exampleArrays = [
                'fruits' => [
                    'apple' => 'Red fruit',
                    'banana' => 'Yellow fruit',
                    'orange' => 'Orange fruit',
                    'grape' => 'Purple fruit',
                    'kiwi' => 'Brown fruit'
                ],
                'countries' => [
                    'USA' => 'United States of America',
                    'IND' => 'India',
                    'JPN' => 'Japan',
                    'GBR' => 'United Kingdom',
                    'CAN' => 'Canada'
                ],
                'programming' => [
                    'php' => 'Server-side scripting language',
                    'js' => 'Client-side scripting language',
                    'python' => 'General-purpose programming language',
                    'java' => 'Object-oriented programming language',
                    'cpp' => 'High-performance programming language'
                ]
            ];
            
            // Display all example arrays
            foreach ($exampleArrays as $arrayName => $array) {
                echo "<div class='example'>";
                echo "<h3>$arrayName Array:</h3>";
                
                echo "<table>";
                echo "<tr><th>Key</th><th>Value</th></tr>";
                
                foreach ($array as $key => $value) {
                    echo "<tr><td>$key</td><td>$value</td></tr>";
                }
                
                echo "</table>";
                echo "</div>";
            }
            ?>
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h3>Find Key by Value</h3>
                <div>
                    <label for="array-select">Select Array:</label><br>
                    <select id="array-select" name="array-select">
                        <?php
                        foreach ($exampleArrays as $arrayName => $array) {
                            $selected = (isset($_POST['array-select']) && $_POST['array-select'] == $arrayName) ? 'selected' : '';
                            echo "<option value='$arrayName' $selected>$arrayName</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="search-value">Enter Value to Search:</label><br>
                    <input type="text" id="search-value" name="search-value" 
                           value="<?php echo isset($_POST['search-value']) ? htmlspecialchars($_POST['search-value']) : ''; ?>" required>
                    <p class="note">Try entering values like "Red fruit", "India", "Server-side scripting language", etc.</p>
                </div>
                <input type="submit" name="search-predefined" value="Find Key">
            </form>
            
            <?php
            // Process form submission for predefined arrays
            if (isset($_POST['search-predefined'])) {
                $arrayName = $_POST['array-select'];
                $searchValue = $_POST['search-value'];
                
                if (isset($exampleArrays[$arrayName])) {
                    $selectedArray = $exampleArrays[$arrayName];
                    $foundKey = array_search($searchValue, $selectedArray);
                    
                    if ($foundKey !== false) {
                        echo "<div class='result'>Found key: <span class='highlight'>$foundKey</span> for value: <span class='highlight'>$searchValue</span></div>";
                        
                        // Show the code used
                        echo "<pre><code>// Code used to find the key:
\$foundKey = array_search(\"$searchValue\", \$exampleArrays['$arrayName']);
// Result: \"$foundKey\"</code></pre>";
                    } else {
                        echo "<div class='error'>Value \"$searchValue\" not found in the $arrayName array</div>";
                    }
                } else {
                    echo "<div class='error'>Selected array not found</div>";
                }
            }
            ?>
        </div>
        
        <div class="section">
            <h2>2. Custom Array Creation and Key Finding</h2>
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h3>Create Your Own Array</h3>
                <p>Enter key-value pairs (one per line in the format "key:value"):</p>
                <textarea name="custom-array" rows="5" cols="50" style="width: 100%;"><?php echo isset($_POST['custom-array']) ? htmlspecialchars($_POST['custom-array']) : "key1:value1\nkey2:value2\nkey3:value3"; ?></textarea>
                <p class="note">Example: "apple:Red fruit" (one entry per line)</p>
                
                <div>
                    <label for="custom-search-value">Enter Value to Search:</label><br>
                    <input type="text" id="custom-search-value" name="custom-search-value" 
                           value="<?php echo isset($_POST['custom-search-value']) ? htmlspecialchars($_POST['custom-search-value']) : ''; ?>" required>
                </div>
                <input type="submit" name="search-custom" value="Find Key in Custom Array">
            </form>
            
            <?php
            // Process form submission for custom array
            if (isset($_POST['search-custom'])) {
                $customArrayText = $_POST['custom-array'];
                $customSearchValue = $_POST['custom-search-value'];
                
                // Parse the custom array
                $customArray = [];
                $lines = explode("\n", $customArrayText);
                
                foreach ($lines as $line) {
                    $line = trim($line);
                    if (!empty($line)) {
                        $parts = explode(":", $line, 2);
                        if (count($parts) == 2) {
                            $key = trim($parts[0]);
                            $value = trim($parts[1]);
                            $customArray[$key] = $value;
                        }
                    }
                }
                
                // Display the parsed custom array
                echo "<div class='example'>";
                echo "<h3>Your Custom Array:</h3>";
                
                if (empty($customArray)) {
                    echo "<p>No valid key-value pairs found</p>";
                } else {
                    echo "<table>";
                    echo "<tr><th>Key</th><th>Value</th></tr>";
                    
                    foreach ($customArray as $key => $value) {
                        echo "<tr><td>$key</td><td>$value</td></tr>";
                    }
                    
                    echo "</table>";
                }
                echo "</div>";
                
                // Search for the value in the custom array
                if (!empty($customArray)) {
                    $foundKey = array_search($customSearchValue, $customArray);
                    
                    if ($foundKey !== false) {
                        echo "<div class='result'>Found key: <span class='highlight'>$foundKey</span> for value: <span class='highlight'>$customSearchValue</span></div>";
                        
                        // Show the code used
                        echo "<pre><code>// Code used to find the key:
\$foundKey = array_search(\"$customSearchValue\", \$customArray);
// Result: \"$foundKey\"</code></pre>";
                    } else {
                        echo "<div class='error'>Value \"$customSearchValue\" not found in your custom array</div>";
                    }
                }
            }
            ?>
        </div>
        
        <div class="section">
            <h2>3. Advanced Array Key Functions</h2>
            
            <?php
            // Create a multi-dimensional array for demonstration
            $multiArray = [
                'fruits' => [
                    'apple' => ['color' => 'red', 'taste' => 'sweet'],
                    'lemon' => ['color' => 'yellow', 'taste' => 'sour'],
                    'grape' => ['color' => 'purple', 'taste' => 'sweet']
                ],
                'vegetables' => [
                    'carrot' => ['color' => 'orange', 'taste' => 'sweet'],
                    'spinach' => ['color' => 'green', 'taste' => 'bitter'],
                    'onion' => ['color' => 'white', 'taste' => 'pungent']
                ]
            ];
            
            echo "<h3>Functions to Get Array Keys:</h3>";
            
            echo "<h4>1. array_keys() - Get all keys from an array</h4>";
            echo "<pre><code>// Get all keys from fruits array:
\$fruitKeys = array_keys(\$multiArray['fruits']);
print_r(\$fruitKeys);</code></pre>";
            
            echo "<div class='example'>";
            echo "<strong>Result:</strong><br>";
            echo "<pre>";
            print_r(array_keys($multiArray['fruits']));
            echo "</pre>";
            echo "</div>";
            
            echo "<h4>2. key_exists() or array_key_exists() - Check if a key exists in an array</h4>";
            echo "<pre><code>// Check if 'apple' exists in fruits array:
\$exists = array_key_exists('apple', \$multiArray['fruits']);
echo \$exists ? 'true' : 'false';</code></pre>";
            
            echo "<div class='example'>";
            echo "<strong>Result:</strong><br>";
            echo array_key_exists('apple', $multiArray['fruits']) ? 'true' : 'false';
            echo "</div>";
            
            echo "<h4>3. array_key_first() - Get the first key of an array (PHP 7.3+)</h4>";
            echo "<pre><code>// Get the first key from vegetables array:
\$firstKey = array_key_first(\$multiArray['vegetables']);
echo \$firstKey;</code></pre>";
            
            echo "<div class='example'>";
            echo "<strong>Result:</strong><br>";
            if (function_exists('array_key_first')) {
                echo array_key_first($multiArray['vegetables']);
            } else {
                echo "Function not available in this PHP version (requires PHP 7.3+)";
            }
            echo "</div>";
            
            echo "<h4>4. array_key_last() - Get the last key of an array (PHP 7.3+)</h4>";
            echo "<pre><code>// Get the last key from vegetables array:
\$lastKey = array_key_last(\$multiArray['vegetables']);
echo \$lastKey;</code></pre>";
            
            echo "<div class='example'>";
            echo "<strong>Result:</strong><br>";
            if (function_exists('array_key_last')) {
                echo array_key_last($multiArray['vegetables']);
            } else {
                echo "Function not available in this PHP version (requires PHP 7.3+)";
            }
            echo "</div>";
            ?>
        </div>
        
        <div class="section">
            <h2>4. Recursive Search for Keys in Multi-dimensional Arrays</h2>
            
            <?php
            // Function to recursively search for a value in a nested array and return the key path
            function recursiveArraySearch($array, $needle, $currentPath = []) {
                $results = [];
                
                foreach ($array as $key => $value) {
                    $path = array_merge($currentPath, [$key]);
                    
                    if ($value === $needle) {
                        $results[] = $path;
                    } elseif (is_array($value) && !empty($value)) {
                        $nestedResults = recursiveArraySearch($value, $needle, $path);
                        if (!empty($nestedResults)) {
                            $results = array_merge($results, $nestedResults);
                        }
                    }
                }
                
                return $results;
            }
            
            // Display function explanation
            echo "<h3>Recursive Search Function:</h3>";
            echo "<pre><code>function recursiveArraySearch(\$array, \$needle, \$currentPath = []) {
    \$results = [];
    
    foreach (\$array as \$key => \$value) {
        \$path = array_merge(\$currentPath, [\$key]);
        
        if (\$value === \$needle) {
            \$results[] = \$path;
        } elseif (is_array(\$value) && !empty(\$value)) {
            \$nestedResults = recursiveArraySearch(\$value, \$needle, \$path);
            if (!empty(\$nestedResults)) {
                \$results = array_merge(\$results, \$nestedResults);
            }
        }
    }
    
    return \$results;
}</code></pre>";
            
            echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "#recursive'>";
            echo "<h3>Search in Multi-dimensional Array</h3>";
            echo "<div>";
            echo "<label for='recursive-search'>Enter value to search:</label><br>";
            echo "<input type='text' id='recursive-search' name='recursive-search' 
                   value='" . (isset($_POST['recursive-search']) ? htmlspecialchars($_POST['recursive-search']) : 'sweet') . "' required>";
            echo "<p class='note'>Try searching for values like 'sweet', 'red', 'bitter', etc.</p>";
            echo "</div>";
            echo "<input type='submit' name='search-recursive' value='Find Key Paths'>";
            echo "</form>";
            
            // Process form submission for recursive search
            if (isset($_POST['search-recursive'])) {
                $needle = $_POST['recursive-search'];
                
                $paths = recursiveArraySearch($multiArray, $needle);
                
                echo "<div class='example'>";
                echo "<h3>Search Results for \"$needle\":</h3>";
                
                if (empty($paths)) {
                    echo "<p>No matches found</p>";
                } else {
                    echo "<ul>";
                    foreach ($paths as $path) {
                        echo "<li>" . implode(' > ', $path) . "</li>";
                    }
                    echo "</ul>";
                }
                echo "</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>
