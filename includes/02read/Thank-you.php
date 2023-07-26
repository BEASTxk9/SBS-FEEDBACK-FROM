<?php
// Function to fetch and display the answers data in a table
function thanks() {
    global $wpdb;

$output = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        h1 {
            color: #007BFF;
        }
    </style>
</head>
<body>
    <h1>Thank You for Your Submission!</h1>
    <p>Your answers have been successfully submitted.</p>
    <!-- Add any additional content or styling as needed -->
</body>
</html>
';

return $output; 
}

add_shortcode('thanks', 'thanks');
?>

