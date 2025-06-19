<!DOCTYPE html>
<html>
<head>
    <title>Array Operations</title>
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
        .array-container {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
            margin: 10px 0;
        }
        .operation-result {
            margin: 25px 0;
            padding: 20px;
            background-color: #e9ecef;
            border-radius: 5px;
            border-left: 5px solid #4a6fa5;
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
        .array-item {
            display: inline-block;
            padding: 5px 10px;
            margin: 5px;
            background-color: #e2e6ea;
            border-radius: 5px;
            border: 1px solid #ced4da;
        }
        .highlight {
            background-color: #ffeeba;
        }
        table {
            width: 100%;
            margin: 10px 0;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
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
            width: 200px;
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
        .input-row {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PHP Array Operations</h1>
        
        <?php
        // Create an array of 10 names
        $names = [
            "John Smith",
            "Emma Johnson",
            "Michael Brown",
            "Sophia Williams",
            "James Miller",
            "Olivia Davis",
            "Robert Wilson",
            "Ava Martinez",
            "William Anderson",
            "Isabella Taylor"
        ];
        
        // Function to display array in a nice format
        function displayArray($arr, $title = "Array Contents") {
            echo "<div class='array-container'>";
            echo "<h3>$title:</h3>";
            
            if (empty($arr)) {
                echo "<p><em>Array is empty</em></p>";
            } else {
                foreach ($arr as $key => $value) {
                    echo "<span class='array-item'>[$key] => $value</span>";
                }
            }
            
            echo "</div>";
        }
        
        // Display the original array
        echo "<div class='operation-result'>";
        echo "<h2>1. Original Array</h2>";
        displayArray($names, "Original Array of Names");
        echo "<pre><code>// Original array creation code:\n\$names = [\n    \"John Smith\",\n    \"Emma Johnson\",\n    \"Michael Brown\",\n    \"Sophia Williams\",\n    \"James Miller\",\n    \"Olivia Davis\",\n    \"Robert Wilson\",\n    \"Ava Martinez\",\n    \"William Anderson\",\n    \"Isabella Taylor\"\n];</code></pre>";
        echo "</div>";
        
        // Display the array using foreach statement
        echo "<div class='operation-result'>";
        echo "<h2>2. Display using foreach</h2>";
        echo "<p>Using <span class='function-name'>foreach</span> to iterate through the array:</p>";
        
        echo "<pre><code>// foreach loop code:\nforeach (\$names as \$key => \$name) {\n    echo \"Index: \$key, Name: \$name&lt;br&gt;\";\n}</code></pre>";
        
        echo "<table>";
        echo "<tr><th>Index</th><th>Name</th></tr>";
        foreach ($names as $key => $name) {
            echo "<tr><td>$key</td><td>$name</td></tr>";
        }
        echo "</table>";
        echo "</div>";
        
        // Display the array in sorted order
        echo "<div class='operation-result'>";
        echo "<h2>3. Display in Sorted Order</h2>";
        echo "<p>Using <span class='function-name'>sort()</span> function to sort the array alphabetically:</p>";
        
        // Create a copy to sort
        $sortedNames = $names;
        sort($sortedNames);
        
        echo "<pre><code>// Sorting code:\n\$sortedNames = \$names;\nsort(\$sortedNames);</code></pre>";
        
        displayArray($sortedNames, "Names in Alphabetical Order");
        echo "</div>";
        
        // Display the array without duplicate elements
        echo "<div class='operation-result'>";
        echo "<h2>4. Display Without Duplicates</h2>";
        echo "<p>Using <span class='function-name'>array_unique()</span> function to remove duplicates:</p>";
        
        // Create a copy with some duplicates
        $namesWithDuplicates = array_merge($names, ["John Smith", "Emma Johnson", "Michael Brown"]);
        
        echo "<pre><code>// Original array with duplicates:\n\$namesWithDuplicates = array_merge(\$names, [\"John Smith\", \"Emma Johnson\", \"Michael Brown\"]);</code></pre>";
        
        displayArray($namesWithDuplicates, "Array with Duplicates");
        
        // Remove duplicates
        $uniqueNames = array_unique($namesWithDuplicates);
        
        echo "<pre><code>// Removing duplicates:\n\$uniqueNames = array_unique(\$namesWithDuplicates);</code></pre>";
        
        displayArray($uniqueNames, "Array Without Duplicates");
        echo "</div>";
        
        // Remove the last element and display
        echo "<div class='operation-result'>";
        echo "<h2>5. Remove Last Element</h2>";
        echo "<p>Using <span class='function-name'>array_pop()</span> function to remove the last element:</p>";
        
        // Create a copy to remove last element
        $popNames = $names;
        $removedName = array_pop($popNames);
        
        echo "<pre><code>// Removing last element:\n\$popNames = \$names;\n\$removedName = array_pop(\$popNames);</code></pre>";
        
        echo "<p>Removed name: <span class='highlight'>$removedName</span></p>";
        displayArray($popNames, "Array After Removing Last Element");
        echo "</div>";
        
        // Display the array in reverse order
        echo "<div class='operation-result'>";
        echo "<h2>6. Display in Reverse Order</h2>";
        echo "<p>Using <span class='function-name'>array_reverse()</span> function to reverse the array:</p>";
        
        // Create a reversed copy
        $reversedNames = array_reverse($names);
        
        echo "<pre><code>// Reversing the array:\n\$reversedNames = array_reverse(\$names);</code></pre>";
        
        displayArray($reversedNames, "Names in Reverse Order");
        echo "</div>";
        
        // Initialize variables for form data
        $position = "";
        $newName = "";
        $searchName = "";
        $insertResult = "";
        $searchResult = "";
        
        // Process form submission for insertion
        if (isset($_POST['insert'])) {
            $position = $_POST['position'];
            $newName = $_POST['new_name'];
            
            // Create a copy for insertion
            $insertNames = $names;
            
            // Insert new element at specified position
            array_splice($insertNames, $position, 0, $newName);
            
            $insertResult = $insertNames;
        }
        
        // Process form submission for search
        if (isset($_POST['search'])) {
            $searchName = $_POST['search_name'];
            
            // Search for the name in the array
            $position = array_search($searchName, $names);
            
            if ($position !== false) {
                $searchResult = "Found \"$searchName\" at position $position";
            } else {
                $searchResult = "\"$searchName\" not found in the array";
            }
        }
        
        // Insert a new element in a specified position
        echo "<div class='operation-result'>";
        echo "<h2>7. Insert a New Element</h2>";
        echo "<p>Using <span class='function-name'>array_splice()</span> function to insert an element at a specific position:</p>";
        
        echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
        echo "<div class='input-row'>";
        echo "<label for='position'>Position to insert:</label><br>";
        echo "<input type='number' id='position' name='position' min='0' max='" . count($names) . "' required value='$position'>";
        echo "</div>";
        echo "<div class='input-row'>";
        echo "<label for='new_name'>New name to insert:</label><br>";
        echo "<input type='text' id='new_name' name='new_name' required value='$newName'>";
        echo "</div>";
        echo "<input type='submit' name='insert' value='Insert Element'>";
        echo "</form>";
        
        if (!empty($insertResult)) {
            echo "<pre><code>// Insertion code:\narray_splice(\$names, $position, 0, \"$newName\");</code></pre>";
            displayArray($insertResult, "Array After Insertion");
        }
        echo "</div>";
        
        // Search and find the position of an element
        echo "<div class='operation-result'>";
        echo "<h2>8. Search for an Element</h2>";
        echo "<p>Using <span class='function-name'>array_search()</span> function to find the position of an element:</p>";
        
        echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
        echo "<div class='input-row'>";
        echo "<label for='search_name'>Name to search:</label><br>";
        echo "<input type='text' id='search_name' name='search_name' required value='$searchName'>";
        echo "</div>";
        echo "<input type='submit' name='search' value='Search Element'>";
        echo "</form>";
        
        if (!empty($searchResult)) {
            echo "<pre><code>// Search code:\n\$position = array_search(\"$searchName\", \$names);</code></pre>";
            echo "<p class='highlight'>$searchResult</p>";
            
            // Display the original array for reference
            displayArray($names, "Original Array (for reference)");
        }
        echo "</div>";
        
        // Additional array function examples
        echo "<div class='operation-result'>";
        echo "<h2>Additional Array Functions</h2>";
        
        // Count elements in the array
        echo "<h3>Count elements:</h3>";
        echo "<pre><code>// Counting elements:\ncount(\$names); // Result: " . count($names) . "</code></pre>";
        
        // Get the first element
        echo "<h3>Get first element:</h3>";
        echo "<pre><code>// Get first element:\nreset(\$names); // Result: \"" . reset($names) . "\"</code></pre>";
        
        // Get the last element
        echo "<h3>Get last element:</h3>";
        echo "<pre><code>// Get last element:\nend(\$names); // Result: \"" . end($names) . "\"</code></pre>";
        
        // Shuffle the array
        $shuffledNames = $names;
        shuffle($shuffledNames);
        echo "<h3>Shuffle array:</h3>";
        echo "<pre><code>// Shuffle array:\nshuffle(\$names);</code></pre>";
        displayArray($shuffledNames, "Shuffled Array");
        
        echo "</div>";
        ?>
        
    </div>
</body>
</html>
