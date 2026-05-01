<?php
// 1. Ensure NO white space exists before the <?php tag above.
// 2. Turn off all error reporting that might leak text into the image
error_reporting(0);
ini_set('display_errors', 0);

if (isset($_GET['file'])) {
    // Sanitize the filename for security
    $fileName = basename($_GET['file']);
    $filePath = 'img/' . $fileName;

    if (file_exists($filePath)) {
        
        // 3. Clear any previous output buffers to ensure a "clean" file stream
        if (ob_get_level()) {
            ob_end_clean();
        }

        // Define headers to force download
        header('Content-Description: File Transfer');
        
        // Use a generic stream if you aren't 100% sure if it's JPG or PNG
        header('Content-Type: application/octet-stream'); 
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        
        // 4. Read the file directly
        readfile($filePath);
        
        // 5. CRITICAL: Exit immediately so no extra spaces are added at the end
        exit;
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "File not found.";
    }
}
?>