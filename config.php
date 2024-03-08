<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbname = 'real_estate_project';
$dbpass = 'new_password';

try {
    global $conn; 
    $conn = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection error: " . $e->getMessage();
}

define("BASE_URL", "http://localhost:8888/real_estate_project/");
define("ADMIN_URL", BASE_URL."/admin/");

define("SMTP_HOST", "sandbox.smtp.mailtrap.io");
define("SMTP_PORT", "587");
define("SMTP_USERNAME", "348111d71b240c");
define("SMTP_PASSWORD", "b7da71c7834cf5");
define("SMTP_ENCRYPTION", "tls");
define("SMTP_FROM", "contact@yourwebsite.com");

// Paypal

require_once 'vendor/autoload.php';
use Omnipay\Omnipay;

define('CLIENT_ID', 'ASo10NVMnNGMIz6Pc4TciNsLo2VxdbeP9jCufjO8-3cnm_rpbx-wXSJYRGNhVfVATmAd9WOID6_aOmaq');
define('CLIENT_SECRET', 'ENqN-oOAkyRsxoybnKSG3v0WG0y0bd-z9beCicgSgr1TmEB9ghyuz0L6p2Bsj9qjRNbZYIhKQsYGbb5Z');

define('PAYPAL_RETURN_URL', BASE_URL.'/agent-paypal-success.php');
define('PAYPAL_CANCEL_URL', BASE_URL.'/agent-paypal-cancel.php');
define('PAYPAL_CURRENCY', 'USD');

$gateway = Omnipay::create('PayPal_Rest');
$gateway->setClientId(CLIENT_ID);
$gateway->setSecret(CLIENT_SECRET);
$gateway->setTestMode(true);

// Stripe

define('STRIPE_TEST_PK', 'pk_test_51Jl3YSIXhVcRmDYYKjDBvrXSU5r1E0GS0891gTFwzQNStz7W7s6iCv91Fgv3WKPHXcSsivCNq63aD7hXlX51t6pE003KvNEAJD');
define('STRIPE_TEST_SK', 'sk_test_51Jl3YSIXhVcRmDYYRNURpF3LGA6CQPbGd5xEoYu0h7hstTwKC8tJF9xSvwDzdeLXmRPAjgL0yx5kNsd1SmTJXpDL002CxIPzwm');

define('STRIPE_SUCCESS_URL', BASE_URL.'agent-stripe-success.php');
define('STRIPE_CANCEL_URL', BASE_URL.'agent-stripe-cancel.php');
