<?php
session_start();
$paymentMessage = '';
if (!empty($_POST['stripeToken'])) {

    // get token and user details
    $stripeToken = $_POST['stripeToken'];
    $customerName = $_POST['customerName'];
    $customerEmail = $_POST['emailAddress'];
    $readingName = $_POST['readingName'];
    $gender = $_POST['gender'];
    $birthDate = $_POST['birthDate'];
    $birthTime = $_POST['birthTime'];
    $birthPlace = $_POST['birthPlace'];

    $customerAddress = $_POST['customerAddress'];
    $customerCity = $_POST['customerCity'];
    $customerZipcode = $_POST['customerZipcode'];
    $customerState = $_POST['customerState'];
    $customerCountry = $_POST['customerCountry'];

    //include Stripe PHP library
    require_once('stripe-php/init.php');

    //set stripe secret key and publishable key
    $stripe = array(
        "secret_key" => "sk_test_51Nz1wNCmiZOJOWEhDcH6FJVWx4kGnTyM2ntwIp5QoJfAIM8dTns4s7tbxWpODF8Gkd6MhWSZZRR7aqReWnJ2iawm00VTJc2QqP",
        "publishable_key" => "pk_test_51Nz1wNCmiZOJOWEhUMpbqlBLazZ8ZSJXYGuZIXFzkDx5Y9vzz2J6UH2wMHF1eCKsiAdlem4Q9x2HQ9VCbyCoy6fz00Ws1QSEPt"
    );

    \Stripe\Stripe::setApiKey($stripe['secret_key']);

    //add customer to stripe
    $customer = \Stripe\Customer::create(
        array(
            'name' => $customerName,
            'description' => 'test description',
            'email' => $customerEmail,
            'source' => $stripeToken,
            "address" => ["city" => $customerCity, "country" => $customerCountry, "line1" => $customerAddress, "line2" => "", "postal_code" => $customerZipcode, "state" => $customerState],
            // 'readingName' => $readingName,
            // 'gender' => $gender,
            // 'birthDate' => $birthDate,
            // 'birthTime' => $birthTime,
            // 'birthPlace' => $birthPlace
        )
    );

    // item details for which payment made
    $itemName = $_POST['item_details'];
    $itemNumber = $_POST['item_number'];
    $itemPrice = $_POST['price'];
    $totalAmount = $_POST['total_amount'];
    $currency = $_POST['currency_code'];
    $orderNumber = $_POST['order_number'];

    // details for which payment performed
    $payDetails = \Stripe\Charge::create(
        array(
            'customer' => $customer->id,
            'amount' => $totalAmount,
            'currency' => $currency,
            'description' => $itemName,
            'metadata' => array(
                'order_id' => $orderNumber
            )
        )
    );

    // get payment details
    $paymenyResponse = $payDetails->jsonSerialize();

    // check whether the payment is successful
    if ($paymenyResponse['amount_refunded'] == 0 && empty($paymenyResponse['failure_code']) && $paymenyResponse['paid'] == 1 && $paymenyResponse['captured'] == 1) {

        // transaction details 
        $balanceTransaction = $paymentResponse['balance_transaction'];
        $paymentStatus = $paymenyResponse['status'];
        $paymentDate = date("Y-m-d H:i:s");

        //insert tansaction details into database
        include_once("include/db_connect.php");

        $insertTransactionSQL = "INSERT INTO transaction(reading_name, gender, birth_date, birth_time, birth_place, cust_name, cust_email, item_name, txn_id, payment_status, created) 
		VALUES('" . $readingName . "','" . $gender . "','" . $birthDate . "','" . $birthTime . "','" . $birthPlace . "','" . $customerName . "','" . $customerEmail . "','" . $itemName . "','" . $balanceTransaction . "','" . $paymentStatus . "','" . $paymentDate . "')";

        mysqli_query($conn, $insertTransactionSQL) or die("database error: " . mysqli_error($conn));

        $lastInsertId = mysqli_insert_id($conn);

        //if order inserted successfully
        if ($lastInsertId && $paymentStatus == 'succeeded') {
            $paymentMessage = "The payment was successful!";
        } else {
            $paymentMessage = "failed";
        }

    } else {
        $paymentMessage = "failed";
    }
} else {
    $paymentMessage = "failed";
}
$_SESSION["message"] = $paymentMessage;
header('location:checkout.php');