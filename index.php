<?php
$serverKey = "SB-Mid-server-srTkZzsKuZbUO-bnPOb1eza6"; // Ganti dengan server key sandbox kamu
$auth = base64_encode($serverKey . ":");

// Baca JSON dari input
$rawData = file_get_contents("php://input");
$input = json_decode($rawData, true);

$amount = isset($input['amount']) ? (int)$input['amount'] : 0;
$name = isset($input['name']) ? $input['name'] : "User";

$data = [
    'transaction_details' => [
        'order_id' => uniqid('ORDER-'),
        'gross_amount' => $amount,
    ],
    'customer_details' => [
        'first_name' => $name
    ]
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://app.sandbox.midtrans.com/snap/v1/transactions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Accept: application/json",
    "Content-Type: application/json",
    "Authorization: Basic $auth"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
$response = curl_exec($ch);
curl_close($ch);

// Output JSON dari Midtrans
echo $response;
?>
