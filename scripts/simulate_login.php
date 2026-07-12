<?php
function get($url, &$cookies = []){
    $opts = [
        'http' => [
            'method' => 'GET',
            'header' => "User-Agent: PHP\r\n",
            'ignore_errors' => true,
        ]
    ];
    $context = stream_context_create($opts);
    $response = file_get_contents($url, false, $context);
    foreach ($http_response_header as $h) {
        if (preg_match('/^Set-Cookie:\s*([^=]+)=([^;]+)/i', $h, $m)) {
            $cookies[$m[1]] = $m[2];
        }
    }
    return $response;
}

function post($url, $data, &$cookies = []){
    $cookieHeader = '';
    if ($cookies) {
        $pairs = [];
        foreach ($cookies as $k=>$v) $pairs[] = "$k=$v";
        $cookieHeader = "Cookie: " . implode('; ', $pairs) . "\r\n";
    }
    $postdata = http_build_query($data);
    $opts = [
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n" . $cookieHeader . "User-Agent: PHP\r\n",
            'content' => $postdata,
            'ignore_errors' => true,
        ]
    ];
    $context = stream_context_create($opts);
    $response = file_get_contents($url, false, $context);
    return [$response, $http_response_header];
}

$base = 'http://127.0.0.1:8000';
$loginUrl = $base . '/admin/login';
$loginPost = $base . '/admin/login';

$cookies = [];
$loginPage = get($loginUrl, $cookies);
if (!$loginPage) { echo "Failed to fetch login page\n"; exit(1); }

if (!preg_match('/name="_token" value="([^"]+)"/', $loginPage, $m)) {
    // Try meta csrf
    if (preg_match('/<meta name="csrf-token" content="([^"]+)">/', $loginPage, $m)) {
        $token = $m[1];
    } else {
        echo "CSRF token not found\n";
        exit(1);
    }
} else {
    $token = $m[1];
}

list($resp, $hdr) = post($loginPost, [
    '_token' => $token,
    'username' => 'admin@example.com',
    'password' => 'password123',
], $cookies);

echo "=== RESPONSE HEADERS ===\n";
foreach ($hdr as $h) echo $h . "\n";
echo "\n=== RESPONSE BODY ===\n";
echo $resp;
