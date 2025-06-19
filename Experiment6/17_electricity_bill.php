<!DOCTYPE html>
<html>
<head>
    <title>Electricity Bill Calculator</title>
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
            max-width: 800px;
        }
        input[type="number"] {
            padding: 8px;
            width: 200px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4a6fa5;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #3a5982;
        }
        .bill {
            margin-top: 30px;
            border: 1px solid #ddd;
            padding: 20px;
            text-align: left;
            border-radius: 5px;
        }
        .bill-header {
            background-color: #4a6fa5;
            color: white;
            padding: 10px;
            margin: -20px -20px 20px -20px;
            border-radius: 5px 5px 0 0;
            text-align: center;
        }
        .bill-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding-bottom: 5px;
            border-bottom: 1px dashed #eee;
        }
        .bill-total {
            font-weight: bold;
            font-size: 18px;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px solid #4a6fa5;
        }
        .rate-info {
            margin: 20px auto;
            width: 80%;
            text-align: left;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Electricity Bill Calculator</h1>
        
        <div class="rate-info">
            <h3>Electricity Rate Information</h3>
            <ul>
                <li>For first 50 units – Rs. 3.50/unit</li>
                <li>For next 100 units – Rs. 4.00/unit</li>
                <li>For next 100 units – Rs. 5.20/unit</li>
                <li>For units above 250 – Rs. 6.50/unit</li>
            </ul>
        </div>
        
        <?php
        // Function to calculate electricity bill based on units consumed
        function calculateBill($units) {
            $totalBill = 0;
            $unitBreakdown = [];
            $remainingUnits = $units;
            
            // For first 50 units – Rs. 3.50/unit
            if ($remainingUnits > 0) {
                $usedUnits = min(50, $remainingUnits);
                $cost = $usedUnits * 3.50;
                $totalBill += $cost;
                $unitBreakdown[] = [
                    'range' => "0-50",
                    'units' => $usedUnits,
                    'rate' => 3.50,
                    'cost' => $cost
                ];
                $remainingUnits -= $usedUnits;
            }
            
            // For next 100 units – Rs. 4.00/unit
            if ($remainingUnits > 0) {
                $usedUnits = min(100, $remainingUnits);
                $cost = $usedUnits * 4.00;
                $totalBill += $cost;
                $unitBreakdown[] = [
                    'range' => "51-150",
                    'units' => $usedUnits,
                    'rate' => 4.00,
                    'cost' => $cost
                ];
                $remainingUnits -= $usedUnits;
            }
            
            // For next 100 units – Rs. 5.20/unit
            if ($remainingUnits > 0) {
                $usedUnits = min(100, $remainingUnits);
                $cost = $usedUnits * 5.20;
                $totalBill += $cost;
                $unitBreakdown[] = [
                    'range' => "151-250",
                    'units' => $usedUnits,
                    'rate' => 5.20,
                    'cost' => $cost
                ];
                $remainingUnits -= $usedUnits;
            }
            
            // For units above 250 – Rs. 6.50/unit
            if ($remainingUnits > 0) {
                $cost = $remainingUnits * 6.50;
                $totalBill += $cost;
                $unitBreakdown[] = [
                    'range' => "Above 250",
                    'units' => $remainingUnits,
                    'rate' => 6.50,
                    'cost' => $cost
                ];
            }
            
            return [
                'total' => $totalBill,
                'breakdown' => $unitBreakdown
            ];
        }
        
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the units from the form
            $units = $_POST["units"];
            $customerName = $_POST["customer_name"];
            $customerID = $_POST["customer_id"];
            
            // Calculate the bill
            $billData = calculateBill($units);
            $totalBill = $billData['total'];
            $breakdown = $billData['breakdown'];
            
            // Generate a unique bill number and date
            $billNumber = "EB-" . date("Ymd") . "-" . rand(1000, 9999);
            $billDate = date("F j, Y");
            $dueDate = date("F j, Y", strtotime("+15 days"));
            
            // Display the electricity bill
            echo "<div class='bill'>";
            echo "<div class='bill-header'><h2>ELECTRICITY BILL</h2></div>";
            
            // Customer Information
            echo "<div class='bill-row'><strong>Bill Number:</strong> $billNumber</div>";
            echo "<div class='bill-row'><strong>Customer Name:</strong> $customerName</div>";
            echo "<div class='bill-row'><strong>Customer ID:</strong> $customerID</div>";
            echo "<div class='bill-row'><strong>Bill Date:</strong> $billDate</div>";
            echo "<div class='bill-row'><strong>Due Date:</strong> $dueDate</div>";
            echo "<div class='bill-row'><strong>Total Units Consumed:</strong> $units</div>";
            
            // Consumption Breakdown
            echo "<h3>Consumption Details</h3>";
            echo "<table style='width:100%; border-collapse: collapse;'>";
            echo "<tr style='background-color: #f2f2f2;'>";
            echo "<th style='padding: 8px; text-align: left; border-bottom: 1px solid #ddd;'>Unit Range</th>";
            echo "<th style='padding: 8px; text-align: center; border-bottom: 1px solid #ddd;'>Units</th>";
            echo "<th style='padding: 8px; text-align: center; border-bottom: 1px solid #ddd;'>Rate (Rs.)</th>";
            echo "<th style='padding: 8px; text-align: right; border-bottom: 1px solid #ddd;'>Amount (Rs.)</th>";
            echo "</tr>";
            
            foreach ($breakdown as $tier) {
                echo "<tr>";
                echo "<td style='padding: 8px; border-bottom: 1px solid #ddd;'>{$tier['range']} units</td>";
                echo "<td style='padding: 8px; text-align: center; border-bottom: 1px solid #ddd;'>{$tier['units']}</td>";
                echo "<td style='padding: 8px; text-align: center; border-bottom: 1px solid #ddd;'>{$tier['rate']}</td>";
                echo "<td style='padding: 8px; text-align: right; border-bottom: 1px solid #ddd;'>" . number_format($tier['cost'], 2) . "</td>";
                echo "</tr>";
            }
            
            echo "</table>";
            
            // Total Amount
            echo "<div class='bill-total'>";
            echo "<div class='bill-row'><strong>Total Amount Due:</strong> Rs. " . number_format($totalBill, 2) . "</div>";
            echo "</div>";
            
            echo "</div>";
        }
        ?>
        
        <!-- HTML form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <p>
                <label for="customer_name">Customer Name:</label><br>
                <input type="text" id="customer_name" name="customer_name" required>
            </p>
            <p>
                <label for="customer_id">Customer ID:</label><br>
                <input type="text" id="customer_id" name="customer_id" required>
            </p>
            <p>
                <label for="units">Enter Units Consumed:</label><br>
                <input type="number" id="units" name="units" min="1" required>
            </p>
            <p>
                <input type="submit" value="Calculate Bill">
            </p>
        </form>
    </div>
</body>
</html>
