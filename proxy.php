<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type: application/json");

$page = $_GET['page'] ?? 1;
$size = $_GET['size'] ?? 10;
$sort = $_GET['sort'] ?? '-published_at';

$url = "https://suitmedia-backend.suitdev.com/api/ideas"
     . "?page[number]=" . urlencode($page)
     . "&page[size]=" . urlencode($size)
     . "&append[]=small_image"
     . "&append[]=medium_image"
     . "&sort=" . urlencode($sort);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json',
    'User-Agent: Suitmedia-Client' 
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    http_response_code(500);
    echo json_encode(["error" => curl_error($ch)]);
    curl_close($ch);
    exit;
}

curl_close($ch);
echo $response;