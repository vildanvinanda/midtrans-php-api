<?php
    $serverKey = getenv('MIDTRANS_SERVER_KEY'); // dari environment
    $auth = base64_encode($serverKey . ":");

    $json = file_get_contents('php://input');
    $postData = json_decode($json, true);

    $data = [
        'transaction_details' => [
            'order_id' => uniqid('ORDER-'),
            'gross_amount' => (int)$postData['amount'],
        ],
        'customer_details' => [
            'first_name' => $postData['name']
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

    echo $response;
?>
