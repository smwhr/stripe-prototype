<?php

require_once("../src/init.php");
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// EFFECTUE LE PAIEMENT
$payment_intent = $data["payment_intent"];

$intent = \Stripe\PaymentIntent::retrieve($payment_intent);

echo $intent->status;
$intent->confirm();

