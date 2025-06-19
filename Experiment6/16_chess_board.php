<!DOCTYPE html>
<html>
<head>
    <title>PHP Chess Board</title>
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
        }
        .board-container {
            display: inline-block;
            border: 10px solid #8B4513;
            border-radius: 5px;
            padding: 0;
            margin: 20px 0;
        }
        table {
            border-collapse: collapse;
            margin: 0;
        }
        td {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 24px;
        }
        .white {
            background-color: #f0d9b5;
        }
        .black {
            background-color: #b58863;
        }
        .row-label {
            width: 20px;
            height: 50px;
            background-color: #8B4513;
            color: white;
            font-weight: bold;
        }
        .col-label {
            height: 20px;
            background-color: #8B4513;
            color: white;
            font-weight: bold;
        }
        .corner {
            background-color: #8B4513;
        }
        .controls {
            margin: 20px 0;
        }
        .controls input, .controls select {
            padding: 8px;
            margin: 5px;
        }
        .controls button {
            padding: 8px 15px;
            background-color: #4a6fa5;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PHP Chess Board</h1>
        
        <?php
        // Default settings
        $boardSize = isset($_GET['size']) ? (int)$_GET['size'] : 8;
        $showLabels = isset($_GET['labels']) ? $_GET['labels'] === 'true' : true;
        $showPieces = isset($_GET['pieces']) ? $_GET['pieces'] === 'true' : false;
        
        // Validate board size (between 4 and 12)
        $boardSize = max(4, min(12, $boardSize));
        
        // Chess pieces for the 8x8 standard board
        $pieces = [
            // Black pieces (top)
            [0, 0] => '♜', [0, 1] => '♞', [0, 2] => '♝', [0, 3] => '♛', 
            [0, 4] => '♚', [0, 5] => '♝', [0, 6] => '♞', [0, 7] => '♜',
            // Black pawns
            [1, 0] => '♟', [1, 1] => '♟', [1, 2] => '♟', [1, 3] => '♟',
            [1, 4] => '♟', [1, 5] => '♟', [1, 6] => '♟', [1, 7] => '♟',
            // White pawns
            [6, 0] => '♙', [6, 1] => '♙', [6, 2] => '♙', [6, 3] => '♙',
            [6, 4] => '♙', [6, 5] => '♙', [6, 6] => '♙', [6, 7] => '♙',
            // White pieces (bottom)
            [7, 0] => '♖', [7, 1] => '♘', [7, 2] => '♗', [7, 3] => '♕',
            [7, 4] => '♔', [7, 5] => '♗', [7, 6] => '♘', [7, 7] => '♖'
        ];
        
        // Start the board
        echo "<div class='board-container'>";
        echo "<table>";
        
        // If showing labels, add the top row of labels
        if ($showLabels) {
            echo "<tr>";
            echo "<td class='corner'></td>"; // Top left corner
            // Column labels (A, B, C, etc.)
            for ($col = 0; $col < $boardSize; $col++) {
                echo "<td class='col-label'>" . chr(65 + $col) . "</td>";
            }
            echo "</tr>";
        }
        
        // Create the chess board
        for ($row = 0; $row < $boardSize; $row++) {
            echo "<tr>";
            
            // If showing labels, add row labels (1, 2, 3, etc.)
            if ($showLabels) {
                echo "<td class='row-label'>" . ($boardSize - $row) . "</td>";
            }
            
            // Create cells for each column
            for ($col = 0; $col < $boardSize; $col++) {
                // Determine cell color (alternating pattern)
                $isBlackCell = ($row + $col) % 2 !== 0;
                $cellClass = $isBlackCell ? 'black' : 'white';
                
                // Start the cell
                echo "<td class='$cellClass'>";
                
                // If showing pieces and this is a standard 8x8 board
                if ($showPieces && $boardSize == 8 && isset($pieces[$row][$col])) {
                    echo $pieces[$row][$col];
                }
                
                echo "</td>";
            }
            echo "</tr>";
        }
        
        echo "</table>";
        echo "</div>";
        ?>
        
        <!-- Controls to customize the board -->
        <div class="controls">
            <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="size">Board Size:</label>
                <select id="size" name="size">
                    <?php
                    for ($i = 4; $i <= 12; $i++) {
                        $selected = ($i == $boardSize) ? 'selected' : '';
                        echo "<option value='$i' $selected>$i x $i</option>";
                    }
                    ?>
                </select>
                
                <label for="labels">Show Labels:</label>
                <select id="labels" name="labels">
                    <option value="true" <?php echo $showLabels ? 'selected' : ''; ?>>Yes</option>
                    <option value="false" <?php echo !$showLabels ? 'selected' : ''; ?>>No</option>
                </select>
                
                <?php if ($boardSize == 8): ?>
                <label for="pieces">Show Pieces:</label>
                <select id="pieces" name="pieces">
                    <option value="true" <?php echo $showPieces ? 'selected' : ''; ?>>Yes</option>
                    <option value="false" <?php echo !$showPieces ? 'selected' : ''; ?>>No</option>
                </select>
                <?php endif; ?>
                
                <button type="submit">Update Board</button>
            </form>
        </div>
        
        <div style="margin-top: 20px; font-size: 14px; color: #666;">
            <p>Created using PHP for loops to generate an interactive chess board pattern.</p>
            <p>Customize the board size and display options using the controls above.</p>
        </div>
    </div>
</body>
</html>
