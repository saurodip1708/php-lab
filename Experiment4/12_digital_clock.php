<!DOCTYPE html>
<html>
<head>
    <title>Digital Clock</title>
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
        .clock {
            font-size: 60px;
            font-weight: bold;
            margin: 40px 0;
            padding: 20px;
            background-color: #333;
            color: #0f0;
            border-radius: 10px;
            display: inline-block;
            min-width: 300px;
            font-family: 'Courier New', monospace;
            text-shadow: 0 0 10px #0f0;
            box-shadow: 0 0 20px rgba(0, 255, 0, 0.2);
        }
        .date {
            font-size: 24px;
            margin: 20px 0;
            color: #333;
        }
        .info {
            margin-top: 30px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Digital Clock</h1>
        
        <?php
        // Get the current server time
        $date = new DateTime();
        
        // Format the current time for display
        $current_time = $date->format('H:i:s');
        
        // Get the current date
        $current_date = $date->format('l, F j, Y');
        
        // Get timezone
        $timezone = date_default_timezone_get();
        ?>
        
        <div class="clock" id="clock"><?php echo $current_time; ?></div>
        <div class="date"><?php echo $current_date; ?></div>
        
        <div class="info">
            <p>Server Timezone: <?php echo $timezone; ?></p>
            <p>This clock shows the current time of the server.</p>
        </div>
    </div>
    
    <script>
        // Function to update the clock every second
        function updateClock() {
            // Create a new XMLHttpRequest object
            var xhr = new XMLHttpRequest();
            
            // Configure it to make a GET request to a PHP file that returns the current time
            xhr.open('GET', '?time=' + new Date().getTime(), true);
            
            // Set up what happens when the request is successful
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Update the clock with the new time
                    location.reload();
                }
            };
            
            // Send the request
            xhr.send();
        }
        
        // Update the clock every second
        setInterval(updateClock, 1000);
    </script>
</body>
</html>
