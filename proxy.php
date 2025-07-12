<?php
// Aktifkan error (saat development)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Ambil parameter dari URL frontend
$page = $_GET['page'] ?? 1;
$size = $_GET['size'] ?? 10;
$sort = $_GET['sort'] ?? '-published_at';

// Bangun query parameter sesuai kebutuhan API
$queryParams = http_build_query([
    'page[number]' => $page,
    'page[size]'   => $size,
    'append'       => ['small_image', 'medium_image'],
    'sort'         => $sort
]);

// API URL
$apiUrl = "https://suitmedia-backend.suitdev.com/api/ideas?$queryParams";

// Inisialisasi cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

// Eksekusi request
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Jika ada error di cURL
if (curl_errno($ch)) {
    http_response_code(500);
    echo json_encode(['error' => curl_error($ch)]);
    curl_close($ch);
    exit;
}

curl_close($ch);

// Validasi response
if ($httpCode !== 200 || empty($response)) {
    http_response_code($httpCode);
    echo json_encode(['error' => "Gagal mengambil data dari API (HTTP $httpCode)"]);
    exit;
}

// Berhasil
header('Content-Type: application/json');
echo $response;
