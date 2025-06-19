<!DOCTYPE html>
<html>
<head>
    <title>Multiplication Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            text-align: center;
            background-color: #f0f0f0;
        }
        h1 {
            color: #4a6fa5;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            display: inline-block;
            min-width: 400px;
        }
        input[type="number"] {
            padding: 8px;
            width: 200px;
            margin: 10px 0;
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
        }
        input[type="submit"]:hover {
            background-color: #3a5982;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 60%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #4a6fa5;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Multiplication Table Generator</h1>
        
        <?php
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the number from the form
            $number = $_POST["number"];
            
            // Display the multiplication table
            echo "<h3>Multiplication Table for $number</h3>";
            echo "<table>";
            echo "<tr><th>Expression</th><th>Result</th></tr>";
            
            for ($i = 1; $i <= 10; $i++) {
                $result = $number * $i;
                echo "<tr><td>$number × $i</td><td>$result</td></tr>";
            }
            
            echo "</table>";
        }
        ?>
        
        <!-- HTML form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <p>
                <label for="number">Enter a Number:</label><br>
                <input type="number" id="number" name="number" min="1" required>
            </p>
            <p>
                <input type="submit" value="Generate Table">
            </p>
        </form>
    </div>
</body>
</html>
