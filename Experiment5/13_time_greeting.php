<!DOCTYPE html>
<html>
<head>
    <title>Time-based Greeting</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            transition: background-color 1s, color 1s;
        }
        .morning {
            background-color: #ffecc5;
            color: #8b5a00;
        }
        .afternoon {
            background-color: #c5e1ff;
            color: #004d8b;
        }
        .evening {
            background-color: #ffd1c5;
            color: #8b2500;
        }
        .night {
            background-color: #232634;
            color: #e6e6e6;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }
        .greeting {
            font-size: 28px;
            margin-bottom: 30px;
        }
        .time {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .date {
            font-size: 18px;
            margin-bottom: 30px;
        }
        .message {
            font-size: 20px;
            line-height: 1.6;
        }
        img {
            max-width: 150px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php
    // Get current hour in 24-hour format
    $hour = date('H');
    
    // Set greeting and styling based on time of day
    if ($hour >= 5 && $hour < 12) {
        // Morning: 5 AM to 11:59 AM
        $timeOfDay = 'morning';
        $greeting = 'Good Morning!';
        $message = 'Wishing you a bright and productive start to your day!';
        $image = '☀️';
    } elseif ($hour >= 12 && $hour < 17) {
        // Afternoon: 12 PM to 4:59 PM
        $timeOfDay = 'afternoon';
        $greeting = 'Good Afternoon!';
        $message = 'Hope your day is going well. Keep up the good work!';
        $image = '🌤️';
    } elseif ($hour >= 17 && $hour < 21) {
        // Evening: 5 PM to 8:59 PM
        $timeOfDay = 'evening';
        $greeting = 'Good Evening!';
        $message = 'Time to wind down and enjoy the rest of your day!';
        $image = '🌆';
    } else {
        // Night: 9 PM to 4:59 AM
        $timeOfDay = 'night';
        $greeting = 'Good Night!';
        $message = 'It\'s getting late. Have a peaceful rest and sweet dreams!';
        $image = '🌙';
    }
    
    // Set body class based on time of day
    echo "<script>document.body.classList.add('$timeOfDay');</script>";
    
    // Format current time
    $currentTime = date('h:i A');
    
    // Format current date
    $currentDate = date('l, F j, Y');
    ?>
    
    <div class="container">
        <div style="font-size: 72px;"><?php echo $image; ?></div>
        <h1><?php echo $greeting; ?></h1>
        <div class="time"><?php echo $currentTime; ?></div>
        <div class="date"><?php echo $currentDate; ?></div>
        <div class="message"><?php echo $message; ?></div>
    </div>
</body>
</html>
