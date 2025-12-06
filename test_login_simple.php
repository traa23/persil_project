<?php
// test_login_powershell.php - Use a simpler method to test
$url_login_get  = 'http://127.0.0.1:8000/login';
$url_login_post = 'http://127.0.0.1:8000/login';

// Try with file_get_contents instead
echo "Attempting to get login form...\n";
$html = @file_get_contents($url_login_get);
if (! $html) {
    echo "ERROR: Could not retrieve login page!\n";
    echo "Last error: " . error_get_last()['message'] . "\n";
    exit;
}

echo "Got login page (" . strlen($html) . " bytes)\n";

// Extract CSRF token
if (preg_match('/<input[^>]*name="_token"[^>]*value="([^"]*)"/', $html, $matches)) {
    $csrf_token = $matches[1];
    echo "CSRF Token found: " . substr($csrf_token, 0, 30) . "...\n";
} else {
    echo "ERROR: Could not find CSRF token!\n";
    // Print first 2000 chars to see what we got
    echo "First 2000 characters of response:\n";
    echo substr($html, 0, 2000) . "\n";
    exit;
}

// Now test POST
echo "\nAttempting to POST credentials...\n";
$data = http_build_query([
    '_token'   => $csrf_token,
    'email'    => 'admin@persil.test',
    'password' => 'password',
]);

$opts = [
    'http' => [
        'method'        => 'POST',
        'header'        => "Content-type: application/x-www-form-urlencoded\r\n",
        'content'       => $data,
        'ignore_errors' => true,
    ],
];

$context  = stream_context_create($opts);
$response = @file_get_contents($url_login_post, false, $context);

// Get HTTP status from response headers
if ($response === false) {
    echo "ERROR: POST request failed!\n";
    echo "Last error: " . error_get_last()['message'] . "\n";
} else {
    // Check HTTP response code from headers
    $headers = $http_response_header ?? [];
    $status  = count($headers) > 0 ? $headers[0] : 'Unknown';
    echo "Response status: $status\n";

    // Check for redirects
    foreach ($headers as $header) {
        if (strtolower(substr($header, 0, 8)) === 'location') {
            echo "Redirect: $header\n";
        }
    }

    // Check response content
    if (strpos($response, 'admin/dashboard') !== false) {
        echo "SUCCESS: Login worked! (Response contains admin dashboard reference)\n";
    } elseif (strpos($response, 'Email atau password') !== false) {
        echo "ERROR: Login failed with credentials error\n";
    } elseif (strpos($response, 'PAGE EXPIRED') !== false || strpos($response, '419') !== false) {
        echo "ERROR: Got 419 PAGE EXPIRED error\n";
    } else {
        echo "Response preview (" . strlen($response) . " bytes):\n";
        echo substr($response, 0, 500) . "\n";
    }
}
