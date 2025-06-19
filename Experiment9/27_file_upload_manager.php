<!DOCTYPE html>
<html>
<head>
    <title>PHP File Upload Manager</title>
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
        input[type="text"], input[type="file"] {
            padding: 8px;
            width: 300px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="file"] {
            width: auto;
        }
        input[type="submit"], button {
            padding: 8px 20px;
            background-color: #4a6fa5;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            margin-right: 5px;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #3a5982;
        }
        .note {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }
        .progress {
            height: 20px;
            margin-top: 10px;
            background-color: #e9ecef;
            border-radius: 5px;
            overflow: hidden;
        }
        .progress-bar {
            height: 100%;
            background-color: #4a6fa5;
            transition: width 0.3s;
        }
        .file-info {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .file-info img {
            max-width: 100px;
            max-height: 100px;
            margin-right: 20px;
        }
        .file-preview {
            max-width: 200px;
            max-height: 200px;
            margin: 10px 0;
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 3px;
        }
        .file-actions {
            margin-left: auto;
        }
        .delete-button {
            background-color: #dc3545;
        }
        .delete-button:hover {
            background-color: #c82333;
        }
        .upload-folder {
            padding: 10px;
            background-color: #e2e3e5;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PHP File Upload Manager</h1>
        
        <?php
        // Create uploads directory if it doesn't exist
        $uploadDir = 'uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Process file upload
        if (isset($_POST['submit'])) {
            // Check if file was uploaded without errors
            if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                $file = $_FILES['file'];
                $fileName = $file['name'];
                $fileTmpName = $file['tmp_name'];
                $fileSize = $file['size'];
                $fileError = $file['error'];
                $fileType = $file['type'];
                
                // Extract file extension
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                // File size limits (5MB)
                $maxFileSize = 5 * 1024 * 1024;
                
                // Allowed file types
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'txt', 'doc', 'docx'];
                
                // Check file size
                if ($fileSize > $maxFileSize) {
                    echo "<div class='error'>File size is too large! Maximum file size is 5MB.</div>";
                }
                // Check file extension
                elseif (!in_array($fileExtension, $allowedExtensions)) {
                    echo "<div class='error'>File type not allowed! Allowed types: " . implode(', ', $allowedExtensions) . "</div>";
                }
                else {
                    // Generate unique filename to prevent overwriting
                    $newFileName = uniqid('', true) . '.' . $fileExtension;
                    $uploadPath = $uploadDir . $newFileName;
                    
                    // Move file from temporary location to uploads directory
                    if (move_uploaded_file($fileTmpName, $uploadPath)) {
                        echo "<div class='result'>File uploaded successfully!</div>";
                        
                        // Display file information
                        echo "<div class='example'>";
                        echo "<h3>File Information</h3>";
                        echo "<ul>";
                        echo "<li><strong>Original filename:</strong> " . htmlspecialchars($fileName) . "</li>";
                        echo "<li><strong>Stored as:</strong> " . htmlspecialchars($newFileName) . "</li>";
                        echo "<li><strong>File type:</strong> " . htmlspecialchars($fileType) . "</li>";
                        echo "<li><strong>File size:</strong> " . round($fileSize / 1024, 2) . " KB</li>";
                        echo "</ul>";
                        
                        // Preview image if file is an image
                        if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                            echo "<h3>Preview:</h3>";
                            echo "<img src='" . $uploadPath . "' class='file-preview' alt='File Preview'>";
                        }
                        echo "</div>";
                    } else {
                        echo "<div class='error'>Error uploading file! Please try again.</div>";
                    }
                }
            } elseif ($_FILES['file']['error'] != 4) { // Error 4 is "no file uploaded", which we don't need to report
                echo "<div class='error'>Error: " . getFileUploadErrorMessage($_FILES['file']['error']) . "</div>";
            }
        }
        
        // Function to get error message for file upload errors
        function getFileUploadErrorMessage($error) {
            switch ($error) {
                case UPLOAD_ERR_INI_SIZE:
                    return "The uploaded file exceeds the upload_max_filesize directive in php.ini";
                case UPLOAD_ERR_FORM_SIZE:
                    return "The uploaded file exceeds the MAX_FILE_SIZE directive specified in the HTML form";
                case UPLOAD_ERR_PARTIAL:
                    return "The uploaded file was only partially uploaded";
                case UPLOAD_ERR_NO_FILE:
                    return "No file was uploaded";
                case UPLOAD_ERR_NO_TMP_DIR:
                    return "Missing a temporary folder";
                case UPLOAD_ERR_CANT_WRITE:
                    return "Failed to write file to disk";
                case UPLOAD_ERR_EXTENSION:
                    return "File upload stopped by extension";
                default:
                    return "Unknown upload error";
            }
        }
        
        // Process file delete request
        if (isset($_POST['delete']) && isset($_POST['filename'])) {
            $fileToDelete = $uploadDir . $_POST['filename'];
            if (file_exists($fileToDelete)) {
                if (unlink($fileToDelete)) {
                    echo "<div class='result'>File deleted successfully!</div>";
                } else {
                    echo "<div class='error'>Error deleting file!</div>";
                }
            } else {
                echo "<div class='error'>File not found!</div>";
            }
        }
        ?>
        
        <div class="section">
            <h2>Upload File</h2>
            
            <div class="upload-folder">
                <strong>Upload Directory:</strong> <?php echo realpath($uploadDir); ?>
            </div>
            
            <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="hidden" name="MAX_FILE_SIZE" value="5242880"> <!-- 5MB -->
                <div>
                    <label for="file">Select file to upload:</label><br>
                    <input type="file" id="file" name="file" required>
                    <p class="note">Maximum file size: 5MB</p>
                    <p class="note">Allowed file types: jpg, jpeg, png, gif, pdf, txt, doc, docx</p>
                </div>
                <input type="submit" name="submit" value="Upload File">
            </form>
            
            <div class="example">
                <h3>How File Upload Works in PHP</h3>
                <pre><code>// HTML Form requirements:
// 1. method="post"
// 2. enctype="multipart/form-data"
// 3. input type="file"

// PHP processing:
// 1. Access files through $_FILES superglobal
// 2. Check for errors ($_FILES['file']['error'])
// 3. Validate file type and size
// 4. Move from temporary location using move_uploaded_file()
// 5. Store with unique name to prevent overwriting</code></pre>
            </div>
        </div>
        
        <div class="section">
            <h2>Uploaded Files</h2>
            
            <?php
            // List all files in the uploads directory
            $files = array_diff(scandir($uploadDir), array('..', '.'));
            
            if (empty($files)) {
                echo "<p>No files have been uploaded yet.</p>";
            } else {
                foreach ($files as $file) {
                    $filePath = $uploadDir . $file;
                    $fileSize = filesize($filePath);
                    $fileType = mime_content_type($filePath);
                    $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    
                    echo "<div class='file-info'>";
                    
                    // Display preview for images
                    if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                        echo "<img src='" . $filePath . "' alt='Preview'>";
                    } else {
                        // Display icon for non-image files
                        echo "<div style='font-size: 48px; margin-right: 20px;'>📄</div>";
                    }
                    
                    echo "<div>";
                    echo "<strong>" . htmlspecialchars($file) . "</strong><br>";
                    echo "Type: " . htmlspecialchars($fileType) . "<br>";
                    echo "Size: " . round($fileSize / 1024, 2) . " KB";
                    echo "</div>";
                    
                    echo "<div class='file-actions'>";
                    echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
                    echo "<input type='hidden' name='filename' value='" . htmlspecialchars($file) . "'>";
                    echo "<button type='submit' name='delete' class='delete-button'>Delete</button>";
                    echo "</form>";
                    echo "</div>";
                    
                    echo "</div>";
                }
            }
            ?>
        </div>
        
        <div class="section">
            <h2>PHP File Handling Functions</h2>
            
            <div class="example">
                <h3>Common File Operations:</h3>
                <table>
                    <tr>
                        <th>Function</th>
                        <th>Description</th>
                    </tr>
                    <tr>
                        <td><code>file_exists($path)</code></td>
                        <td>Checks if a file or directory exists</td>
                    </tr>
                    <tr>
                        <td><code>filesize($file)</code></td>
                        <td>Returns the file size in bytes</td>
                    </tr>
                    <tr>
                        <td><code>filetype($file)</code></td>
                        <td>Returns the file type</td>
                    </tr>
                    <tr>
                        <td><code>is_file($path)</code></td>
                        <td>Checks if the path is a regular file</td>
                    </tr>
                    <tr>
                        <td><code>is_dir($path)</code></td>
                        <td>Checks if the path is a directory</td>
                    </tr>
                    <tr>
                        <td><code>unlink($file)</code></td>
                        <td>Deletes a file</td>
                    </tr>
                    <tr>
                        <td><code>copy($source, $dest)</code></td>
                        <td>Copies a file</td>
                    </tr>
                    <tr>
                        <td><code>rename($old, $new)</code></td>
                        <td>Renames a file or directory</td>
                    </tr>
                    <tr>
                        <td><code>mkdir($path)</code></td>
                        <td>Creates a directory</td>
                    </tr>
                    <tr>
                        <td><code>rmdir($path)</code></td>
                        <td>Removes a directory</td>
                    </tr>
                </table>
            </div>
            
            <div class="example">
                <h3>File Content Operations:</h3>
                <table>
                    <tr>
                        <th>Function</th>
                        <th>Description</th>
                    </tr>
                    <tr>
                        <td><code>file_get_contents($file)</code></td>
                        <td>Reads entire file into a string</td>
                    </tr>
                    <tr>
                        <td><code>file_put_contents($file, $data)</code></td>
                        <td>Writes data to a file</td>
                    </tr>
                    <tr>
                        <td><code>file($file)</code></td>
                        <td>Reads file into an array</td>
                    </tr>
                    <tr>
                        <td><code>fopen($file, $mode)</code></td>
                        <td>Opens file or URL</td>
                    </tr>
                    <tr>
                        <td><code>fread($handle, $length)</code></td>
                        <td>Reads from file (up to length bytes)</td>
                    </tr>
                    <tr>
                        <td><code>fwrite($handle, $data)</code></td>
                        <td>Writes to file</td>
                    </tr>
                    <tr>
                        <td><code>fclose($handle)</code></td>
                        <td>Closes an open file pointer</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
