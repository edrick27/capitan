<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once './dbclass.php';


    $dbclass = new Database();
    $connection = $dbclass->getConnection();
    $response = array();

    $limit = htmlspecialchars(strip_tags($_GET['limit']));

    $query = "SELECT distinct f.sponsor FROM `funds` AS f  ORDER BY f.money DESC limit $limit";

    $stmt = $connection->query($query);

    $count = $stmt->num_rows;

    if($count > 0){

        while ($row = $stmt->fetch_assoc()){

            extract($row);

            $p  = array(
                "sponsor" => $sponsor,
            );

            array_push($response, $p);
        }

        echo json_encode($response);
    } else {
        echo json_encode(
            array()
        );
    }
?>