<?php

require_once("../vendor/autoload.php");

$dotenv = Dotenv\Dotenv::create(__DIR__."/..");
$dotenv->load();


$stripe_pkey = getenv('STRIPE_PK');