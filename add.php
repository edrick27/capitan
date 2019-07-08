<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once './dbclass.php';

    $dbclass = new Database();
    $connection = $dbclass->getConnection();

    // sanitize
    $type = htmlspecialchars(strip_tags($_POST['type']));
    $sponsor = htmlspecialchars(strip_tags($_POST['sponsor']));
    $money = htmlspecialchars(strip_tags($_POST['money']));

    $query = "INSERT INTO `funds` (`sponsor`, `type`, `money`) 
                VALUES ('$sponsor', '$type', '$money');";

    if ($connection->query($query) === TRUE) {
        echo "success";
    } else {
        echo "Error: " . $query . "<br>" . $connection->error;
    }
?>