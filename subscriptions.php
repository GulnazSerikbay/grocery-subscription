<?php
include 'db_connect.php';


// sending in form: 'x-www-form-urlencoded' -> accessing $_POST['key'] is fine

// GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $sql = "SELECT s.id as subscription_id, s.customerName, s.phoneNumber, s.deliveryAddress, s.deliveryDay, s.deliveryTime, s.subscriptionPeriod, si.quantity, p.name as product_name, p.type, p.weight 
            FROM Subscriptions s
            JOIN SubscriptionItems si ON s.id = si.subscriptionID
            JOIN Products p ON p.id = si.productID";

    $result = mysqli_query($conn, $sql);

    $subscriptions = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $subscriptions[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($subscriptions);
}


// POST requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customerName = mysqli_real_escape_string($conn, $_POST['customerName']);
    $phoneNumber = mysqli_real_escape_string($conn, $_POST['phoneNumber']);
    $deliveryAddress = mysqli_real_escape_string($conn, $_POST['deliveryAddress']);
    $deliveryDay = mysqli_real_escape_string($conn, $_POST['deliveryDay']);
    $deliveryTime = mysqli_real_escape_string($conn, $_POST['deliveryTime']);
    $subscriptionPeriod = mysqli_real_escape_string($conn, $_POST['subscriptionPeriod']);

    $sql = "INSERT INTO Subscriptions (customerName, phoneNumber, deliveryAddress, deliveryDay, deliveryTime, subscriptionPeriod) VALUES ('$customerName', '$phoneNumber', '$deliveryAddress', '$deliveryDay', '$deliveryTime', '$subscriptionPeriod')";

    if (mysqli_query($conn, $sql)) {
        http_response_code(201);
        $subscription = [
            'customerName' => $customerName,
            'phoneNumber' => $phoneNumber,
            'deliveryAddress' => $deliveryAddress,
            'deliveryDay' => $deliveryDay,
            'deliveryTime' => $deliveryTime,
            'subscriptionPeriod' => $subscriptionPeriod,
            'id' => mysqli_insert_id($conn)
        ];
        echo json_encode($subscription);
    } else {
        http_response_code(422);
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);

    }
}

mysqli_close($conn);
?>
