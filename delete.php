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
    $id_donation = htmlspecialchars(strip_tags($_POST['id_donation']));

    $query = "DELETE FROM `funds` WHERE id = $id_donation";

    if ($connection->query($query) === TRUE) {
        echo "success";
    } else {
        echo "Error: " . $query . "<br>" . $connection->error;
    }
?>