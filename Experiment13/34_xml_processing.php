<?php
// Create a sample XML file if it doesn't exist
if (!file_exists('books.xml')) {
    $sample_xml = '<?xml version="1.0" encoding="UTF-8"?>
    <bookstore>
        <book category="Fiction">
            <title>Harry Potter and the Philosopher\'s Stone</title>
            <author>J.K. Rowling</author>
            <year>1997</year>
            <price>29.99</price>
        </book>
        <book category="Science Fiction">
            <title>Dune</title>
            <author>Frank Herbert</author>
            <year>1965</year>
            <price>24.95</price>
        </book>
        <book category="Mystery">
            <title>The Girl with the Dragon Tattoo</title>
            <author>Stieg Larsson</author>
            <year>2005</year>
            <price>19.99</price>
        </book>
        <book category="Non-Fiction">
            <title>A Brief History of Time</title>
            <author>Stephen Hawking</author>
            <year>1988</year>
            <price>15.50</price>
        </book>
    </bookstore>';
    
    file_put_contents('books.xml', $sample_xml);
}

// Function to display parsed XML data in a table
function displayXMLAsTable($xml) {
    $output = '<table border="1">
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Year</th>
                    <th>Price</th>
                    <th>Category</th>
                </tr>';
    
    foreach ($xml->book as $book) {
        $output .= '<tr>
                    <td>' . $book->title . '</td>
                    <td>' . $book->author . '</td>
                    <td>' . $book->year . '</td>
                    <td>$' . $book->price . '</td>
                    <td>' . $book['category'] . '</td>
                </tr>';
    }
    
    $output .= '</table>';
    return $output;
}

// Function to save XML content
function saveXML($xmlObj, $filePath) {
    $xmlObj->asXML($filePath);
    return "XML file saved successfully.";
}

// Process XML operations
$message = '';
$xmlTable = '';
$xmlContent = '';

// Load the XML file
if (file_exists('books.xml')) {
    $xml = simplexml_load_file('books.xml');
    $xmlContent = file_get_contents('books.xml');
    
    // Check for form submissions
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Add a new book
        if (isset($_POST['add_book'])) {
            $newBook = $xml->addChild('book');
            $newBook->addAttribute('category', $_POST['category']);
            $newBook->addChild('title', $_POST['title']);
            $newBook->addChild('author', $_POST['author']);
            $newBook->addChild('year', $_POST['year']);
            $newBook->addChild('price', $_POST['price']);
            
            $message = saveXML($xml, 'books.xml');
            $xml = simplexml_load_file('books.xml'); // Reload the XML
            $xmlContent = file_get_contents('books.xml');
        }
        
        // Search for books
        elseif (isset($_POST['search'])) {
            $searchTerm = strtolower($_POST['search_term']);
            $results = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><bookstore></bookstore>');
            
            foreach ($xml->book as $book) {
                if (
                    stripos($book->title, $searchTerm) !== false ||
                    stripos($book->author, $searchTerm) !== false ||
                    stripos($book['category'], $searchTerm) !== false
                ) {
                    $newBook = $results->addChild('book');
                    $newBook->addAttribute('category', $book['category']);
                    $newBook->addChild('title', $book->title);
                    $newBook->addChild('author', $book->author);
                    $newBook->addChild('year', $book->year);
                    $newBook->addChild('price', $book->price);
                }
            }
            
            $message = count($results->book) . " results found for '$searchTerm'.";
            // Override the original XML for display
            $xml = $results;
        }
    }
    
    // Display the XML as a table
    $xmlTable = displayXMLAsTable($xml);
}
else {
    $message = "XML file could not be loaded.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP XML Processing</title>
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
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>PHP XML Processing</h1>
        
        <?php if (!empty($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <div class="tabs">
            <div class="tab active" onclick="switchTab('view')">View Books</div>
            <div class="tab" onclick="switchTab('add')">Add Book</div>
            <div class="tab" onclick="switchTab('search')">Search Books</div>
            <div class="tab" onclick="switchTab('xml')">Raw XML</div>
        </div>
        
        <div id="view" class="tab-content active">
            <div class="section">
                <h2>Books Database</h2>
                <p>This is a simple XML database of books parsed using PHP's SimpleXML functions.</p>
                
                <?php echo $xmlTable; ?>
            </div>
        </div>
        
        <div id="add" class="tab-content">
            <div class="section">
                <h2>Add a New Book</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="author">Author:</label>
                        <input type="text" id="author" name="author" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="year">Year:</label>
                        <input type="number" id="year" name="year" required min="1400" max="2099">
                    </div>
                    
                    <div class="form-group">
                        <label for="price">Price ($):</label>
                        <input type="number" id="price" name="price" required step="0.01" min="0">
                    </div>
                    
                    <div class="form-group">
                        <label for="category">Category:</label>
                        <input type="text" id="category" name="category" required>
                    </div>
                    
                    <button type="submit" name="add_book">Add Book</button>
                </form>
            </div>
        </div>
        
        <div id="search" class="tab-content">
            <div class="section">
                <h2>Search Books</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="search_term">Search Term:</label>
                        <input type="text" id="search_term" name="search_term" required>
                    </div>
                    
                    <button type="submit" name="search">Search</button>
                </form>
            </div>
        </div>
        
        <div id="xml" class="tab-content">
            <div class="section">
                <h2>Raw XML Content</h2>
                <pre><code><?php echo htmlspecialchars($xmlContent); ?></code></pre>
            </div>
        </div>
        
        <div class="section">
            <h2>PHP XML Processing Explained</h2>
            <p>PHP offers two main extensions for working with XML:</p>
            
            <div class="example">
                <h3>SimpleXML</h3>
                <p>SimpleXML provides a simple and easy-to-use toolset for converting XML to an object that can be processed with normal property selectors and array iterators.</p>
                <pre><code>$xml = simplexml_load_file('books.xml');
foreach ($xml->book as $book) {
    echo $book->title . " by " . $book->author;
}</code></pre>
            </div>
            
            <div class="example">
                <h3>DOM (Document Object Model)</h3>
                <p>The DOM extension allows you to operate on XML documents through the DOM API with PHP.</p>
                <pre><code>$dom = new DOMDocument();
$dom->load('books.xml');
$books = $dom->getElementsByTagName('book');
foreach ($books as $book) {
    $titles = $book->getElementsByTagName('title');
    $title = $titles->item(0)->nodeValue;
    echo $title;
}</code></pre>
            </div>
            
            <div class="example">
                <h3>Creating and Modifying XML</h3>
                <p>XML can be easily created and modified using SimpleXML:</p>
                <pre><code>$xml = new SimpleXMLElement('&lt;?xml version="1.0" encoding="UTF-8"?&gt;&lt;bookstore&gt;&lt;/bookstore&gt;');
$book = $xml->addChild('book');
$book->addAttribute('category', 'Fiction');
$book->addChild('title', 'New Book Title');
$book->addChild('author', 'Author Name');
$xml->asXML('new_books.xml'); // Save to file</code></pre>
            </div>
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
                if (tabs[i].textContent.toLowerCase().includes(tabId)) {
                    tabs[i].classList.add('active');
                    break;
                }
            }
        }
    </script>
</body>
</html>
