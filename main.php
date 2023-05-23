<?php
include 'db_connect.php';
// $conn is defined in db_connect.php file, importing here.

if ($conn) {
    echo "Connected Successfully";
    mysqli_close($conn);  // close the conn
}
?>
