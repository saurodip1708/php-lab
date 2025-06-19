<!DOCTYPE html>
<html>
<head>
    <title>Current Date Information</title>
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
        .date-card {
            margin: 20px auto;
            padding: 15px;
            border-radius: 5px;
            background-color: #e6f0ff;
            color: #333;
            max-width: 300px;
        }
        .current-time {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }
        .date-info {
            margin: 5px 0;
            text-align: left;
            padding-left: 50px;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4a6fa5;
            color: white;
            width: 40%;
        }
        button {
            padding: 8px 20px;
            background-color: #4a6fa5;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #3a5982;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Current Date Information</h1>
        
        <?php
        // Get current date information using getdate()
        $date_info = getdate();
        
        // Format the current time
        $hour = $date_info['hours'];
        $am_pm = ($hour >= 12) ? 'PM' : 'AM';
        $hour = ($hour > 12) ? $hour - 12 : $hour;
        $hour = ($hour == 0) ? 12 : $hour;
        $current_time = sprintf("%d:%02d:%02d %s", 
                              $hour, 
                              $date_info['minutes'], 
                              $date_info['seconds'], 
                              $am_pm);
        
        // Format the date
        $current_date = sprintf("%s, %s %d, %d",
                              $date_info['weekday'],
                              $date_info['month'],
                              $date_info['mday'],
                              $date_info['year']);
                              
        // Display current date and time
        echo "<div class='date-card'>";
        echo "<div class='current-time'>$current_time</div>";
        echo "<div>$current_date</div>";
        echo "</div>";
        
        // Display detailed date information in a table
        echo "<h3>Detailed Date Information</h3>";
        echo "<table>";
        echo "<tr><th>Component</th><th>Value</th></tr>";
        echo "<tr><td>Seconds</td><td>{$date_info['seconds']}</td></tr>";
        echo "<tr><td>Minutes</td><td>{$date_info['minutes']}</td></tr>";
        echo "<tr><td>Hours</td><td>{$date_info['hours']}</td></tr>";
        echo "<tr><td>Day of month</td><td>{$date_info['mday']}</td></tr>";
        echo "<tr><td>Month (numeric)</td><td>{$date_info['mon']}</td></tr>";
        echo "<tr><td>Year</td><td>{$date_info['year']}</td></tr>";
        echo "<tr><td>Day of week (numeric)</td><td>{$date_info['wday']}</td></tr>";
        echo "<tr><td>Day of year</td><td>{$date_info['yday']}</td></tr>";
        echo "<tr><td>Month (text)</td><td>{$date_info['month']}</td></tr>";
        echo "<tr><td>Weekday (text)</td><td>{$date_info['weekday']}</td></tr>";
        echo "<tr><td>Timestamp</td><td>{$date_info[0]}</td></tr>";
        echo "</table>";
        ?>
        
        <button onclick="location.reload()">Refresh Date & Time</button>
    </div>
</body>
</html>
