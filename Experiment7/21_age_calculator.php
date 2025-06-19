<!DOCTYPE html>
<html>
<head>
    <title>Age Calculator</title>
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
            max-width: 700px;
        }
        input[type="date"] {
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
        .result {
            margin-top: 20px;
            padding: 20px;
            border-radius: 5px;
            background-color: #d4edda;
            color: #155724;
        }
        .age-breakdown {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        .age-card {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            width: 100px;
            text-align: center;
        }
        .age-number {
            font-size: 36px;
            font-weight: bold;
            color: #4a6fa5;
        }
        .age-label {
            font-size: 14px;
            color: #6c757d;
        }
        .next-birthday {
            margin-top: 20px;
            padding: 15px;
            background-color: #e2f0fe;
            border-radius: 5px;
            border: 1px solid #bee5eb;
        }
        .error {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            background-color: #f8d7da;
            color: #721c24;
        }
        .fun-fact {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            background-color: #fff3cd;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Age Calculator</h1>
        
        <?php
        // Function to calculate age detail from birthdate to current date
        function calculateAge($birthDate) {
            // Create DateTime objects for birth date and current date
            $birth = new DateTime($birthDate);
            $today = new DateTime('today');
            
            // Check if birth date is in the future
            if ($birth > $today) {
                return ["error" => "Birth date cannot be in the future."];
            }
            
            // Calculate difference between dates
            $diff = $today->diff($birth);
            
            // Calculate days lived
            $birthDateObj = new DateTime($birthDate);
            $currentDateObj = new DateTime();
            $interval = $birthDateObj->diff($currentDateObj);
            $daysLived = $interval->days;
            
            // Calculate weeks lived
            $weeksLived = floor($daysLived / 7);
            
            // Calculate hours lived (approximate)
            $hoursLived = $daysLived * 24;
            
            // Calculate minutes lived (approximate)
            $minutesLived = $hoursLived * 60;
            
            // Calculate next birthday
            $nextBirthday = new DateTime($birthDate);
            $nextBirthday->setDate($today->format('Y'), $birth->format('n'), $birth->format('j'));
            if ($nextBirthday < $today) {
                $nextBirthday->modify('+1 year');
            }
            $daysUntilNextBirthday = $today->diff($nextBirthday)->days;
            
            // Return all calculated data
            return [
                "years" => $diff->y,
                "months" => $diff->m,
                "days" => $diff->d,
                "total_months" => $diff->y * 12 + $diff->m,
                "total_weeks" => $weeksLived,
                "total_days" => $daysLived,
                "total_hours" => $hoursLived,
                "total_minutes" => $minutesLived,
                "next_birthday" => [
                    "date" => $nextBirthday->format('F j, Y'),
                    "days_remaining" => $daysUntilNextBirthday
                ],
                "birth_day_of_week" => $birth->format('l')
            ];
        }
        
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get birthdate from the form
            $birthDate = $_POST["birthdate"];
            
            // Calculate age details
            $ageDetails = calculateAge($birthDate);
            
            // Display error if any
            if (isset($ageDetails["error"])) {
                echo "<div class='error'>{$ageDetails["error"]}</div>";
            } else {
                // Format birthdate for display
                $formattedBirthDate = date("F j, Y", strtotime($birthDate));
                
                // Display result
                echo "<div class='result'>";
                echo "<h2>Your Age Results</h2>";
                echo "<p>Based on your birth date: <strong>$formattedBirthDate</strong> ({$ageDetails['birth_day_of_week']})</p>";
                
                // Display age in years, months, days
                echo "<div class='age-breakdown'>";
                echo "<div class='age-card'><div class='age-number'>{$ageDetails['years']}</div><div class='age-label'>Years</div></div>";
                echo "<div class='age-card'><div class='age-number'>{$ageDetails['months']}</div><div class='age-label'>Months</div></div>";
                echo "<div class='age-card'><div class='age-number'>{$ageDetails['days']}</div><div class='age-label'>Days</div></div>";
                echo "</div>";
                
                // Display detailed age information
                echo "<h3>You have lived for approximately:</h3>";
                echo "<ul style='text-align: left;'>";
                echo "<li><strong>{$ageDetails['total_months']}</strong> months</li>";
                echo "<li><strong>{$ageDetails['total_weeks']}</strong> weeks</li>";
                echo "<li><strong>{$ageDetails['total_days']}</strong> days</li>";
                echo "<li><strong>{$ageDetails['total_hours']}</strong> hours</li>";
                echo "<li><strong>{$ageDetails['total_minutes']}</strong> minutes</li>";
                echo "</ul>";
                
                // Display next birthday information
                echo "<div class='next-birthday'>";
                echo "<h3>Your Next Birthday</h3>";
                echo "<p>Date: <strong>{$ageDetails['next_birthday']['date']}</strong></p>";
                echo "<p>Days remaining: <strong>{$ageDetails['next_birthday']['days_remaining']}</strong></p>";
                echo "</div>";
                
                // Display a fun fact
                $funFacts = [
                    "Did you know? The oldest person ever recorded lived to be 122 years old.",
                    "Fun fact: The human heart beats about 35 million times a year.",
                    "Interesting fact: The average person spends about 26 years of their life sleeping.",
                    "Fun fact: Your body has about 100,000 miles of blood vessels.",
                    "Did you know? The human brain stops growing at age 18.",
                    "Fun fact: Our eyes remain the same size from birth, but our nose and ears never stop growing."
                ];
                $randomFact = $funFacts[array_rand($funFacts)];
                echo "<div class='fun-fact'>$randomFact</div>";
                
                echo "</div>";
            }
        }
        ?>
        
        <!-- HTML form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <p>
                <label for="birthdate">Enter Your Birthdate:</label><br>
                <input type="date" id="birthdate" name="birthdate" required 
                       max="<?php echo date('Y-m-d'); ?>">
            </p>
            <p>
                <input type="submit" value="Calculate Age">
            </p>
        </form>
        
        <div style="margin-top: 20px; font-size: 14px; color: #666;">
            This calculator provides your exact age in years, months, and days, along with other time units.
            It also shows you when your next birthday will be.
        </div>
    </div>
</body>
</html>
