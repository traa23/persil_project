<?php

// test_login_with_curl.php - Test the login flow end-to-end using cURL
// This simulates what a browser does

$ch = curl_init();

// Step 1: GET /login to get the form (and session cookie)
echo "Step 1: GET /login\n";
curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__.'/cookies.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__.'/cookies.txt');

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo "Status: $http_code\n";

if ($http_code != 200) {
    echo "ERROR: Failed to get login form!\n";
    echo $response;
    exit;
}

// Extract CSRF token from HTML
if (preg_match('/<input[^>]*name="_token"[^>]*value="([^"]*)"/', $response, $matches)) {
    $csrf_token = $matches[1];
    echo 'CSRF Token found: '.substr($csrf_token, 0, 20)."...\n";
} else {
    echo "ERROR: CSRF token not found in response!\n";
    exit;
}

// Step 2: POST /login with credentials
echo "\nStep 2: POST /login with credentials\n";
curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/login');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    '_token' => $csrf_token,
    'email' => 'admin@persil.test',
    'password' => 'password',
]));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$location = curl_getinfo($ch, CURLINFO_REDIRECT_URL);

echo "Status: $http_code\n";
echo 'Location: '.($location ?: 'N/A')."\n";

if ($http_code == 302 && strpos($location, 'admin') !== false) {
    echo "\nSUCCESS! Admin login worked and redirected to admin dashboard\n";
} elseif ($http_code == 302) {
    echo "\nSUCCESS! Login successful and redirected to: $location\n";
} elseif ($http_code == 419) {
    echo "\nERROR 419 PAGE EXPIRED - CSRF token issue!\n";
} else {
    echo "\nUnexpected response:\n";
    echo $response;
}

curl_close($ch);
@unlink(__DIR__.'/cookies.txt');
