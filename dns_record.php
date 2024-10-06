<?php
// Cloudflare API credentials
$apiToken = ""; // Your Cloudflare API token
$zoneId = ""; // Your Zone ID for the domain
$server_ip = ""; // Your server's IP address
$subdomain = ""; // The subdomain you want to create (e.g., 'example' for example.yourdomain.com)
// DNS record data
$dnsRecordData = [
    'type' => 'A',                // The type of DNS record (e.g., A, CNAME, MX)
    'name' => $subdomain,         // The subdomain for the DNS record
    'content' => $server_ip,      // The IP address or value for the DNS record
    'ttl' => 3600,                // Time to live (TTL) in seconds
    'proxied' => false            // Whether the record is proxied through Cloudflare or not
];
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.cloudflare.com/client/v4/zones/$zoneId/dns_records",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode($dnsRecordData), // Convert DNS record data to JSON
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $apiToken",             // API token in the Authorization header
        "Content-Type: application/json"
    ],
]);
$response = curl_exec($curl);
if ($response === false) {
    // Capture and display cURL error
    $error = curl_error($curl);
    echo "cURL Error: " . $error;
} else {
    // Parse the API response
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $responseData = json_decode($response, true); // Convert the JSON response into a PHP array

    // Check if the response indicates success
    if ($httpCode >= 200 && $httpCode < 300) {
        echo "DNS record created successfully:<br>";
        print_r($responseData); // Print the full response for debugging
    } else {
        // If not successful, print the error message from Cloudflare's response
        echo "Failed to create DNS record. HTTP Code: " . $httpCode . "<br>";
        if (isset($responseData['errors'])) {
            foreach ($responseData['errors'] as $error) {
                echo "Error: " . $error['message'] . "<br>";
            }
        } else {
            echo "Unexpected error: ";
            print_r($responseData);
        }
    }
}

// Close the cURL session
curl_close($curl);
