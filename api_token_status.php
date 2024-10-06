<?php
$apiToken = ""; // Your Cloudflare API token
$zoneId = ""; // Your Zone ID for the domain
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.cloudflare.com/client/v4/accounts/$zoneId/tokens/verify",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $apiToken",
        "Content-Type: application/json"
    ],
]);
$response = curl_exec($curl);
echo $response;
