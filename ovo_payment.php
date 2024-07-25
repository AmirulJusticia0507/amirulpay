<?php
include 'konekke_local.php';

function initiateOvoPayment($amount, $phone, $transactionId) {
    $url = "https://api.ovo.id/v1/payments"; // Sesuaikan dengan endpoint OVO API
    $apiKey = "YOUR_API_KEY"; // Ganti dengan API key Anda

    $data = array(
        "amount" => $amount,
        "phone" => $phone,
        "transaction_id" => $transactionId,
    );

    $payload = json_encode($data);

    // Enkripsi payload
    $encryptedPayload = encryptPayload($payload);

    // Tanda tangani payload terenkripsi
    $signature = signPayload($encryptedPayload);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey,
        'X-Signature: ' . $signature
    ));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $encryptedPayload);

    $response = curl_exec($ch);
    curl_close($ch);

    saveOvoResponse($transactionId, $response);

    return json_decode($response, true);
}

function encryptPayload($payload) {
    $publicKey = file_get_contents('id_rsa.pub.pem');
    openssl_public_encrypt($payload, $encryptedPayload, $publicKey);
    return base64_encode($encryptedPayload);
}

function signPayload($payload) {
    $privateKey = file_get_contents('private.pem');
    openssl_sign($payload, $signature, $privateKey, OPENSSL_ALGO_SHA256);
    return base64_encode($signature);
}

function saveOvoResponse($transactionId, $response) {
    global $koneklocalhost;

    $query = "INSERT INTO ovo_payments (transaction_id, ovo_response) VALUES (?, ?)";
    $stmt = $koneklocalhost->prepare($query);
    $stmt->bind_param("ss", $transactionId, $response);
    $stmt->execute();
    $stmt->close();
}
?>
