<?php

// Cloudflare API token
$apiToken = ""; // Your API token
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.cloudflare.com/client/v4/zones",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $apiToken",
        "Content-Type: application/json"
    ],
]);
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    // Convert the JSON response into a PHP array
    $zones = json_decode($response, true);

    // Output the zone information
    if (isset($zones['result'])) {
        foreach ($zones['result'] as $zone) {
            echo "Domain: " . $zone['name'] . "<br>";
            echo "Zone ID: " . $zone['id'] . "<br><br>";
        }
    } else {
        echo "Error retrieving zones.";
    }
}
