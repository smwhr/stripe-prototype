<?php

require_once("../src/init.php");

// PREPARE LA TRANSACTION

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$payment_method = $data["payment_method"];

$intent = \Stripe\PaymentIntent::create([
            "amount" => 50000,
            "currency" => "eur",
            "payment_method" => $payment_method,
            'confirm' => true,
            'confirmation_method' => 'manual',
            //'capture_method' => 'manual'
        ]);


if ($intent->status == 'requires_action'){
  echo json_encode(["error" => 'requires_action']);
  return http_response_code(400);
}else if (in_array($intent->status, ['succeeded','requires_capture','requires_confirmation'])) {

  echo json_encode([
        "message" => "Payment intent créé",
        "intent_status" => $intent->status,
        "intent"  => $intent
      ]);
  return http_response_code(201);
}else{
  http_response_code(400);
  echo json_encode([
        "message" => "Souci",
        "intent_status" => $intent->status,
        "intent"  => $intent
      ]);
  return;
}
