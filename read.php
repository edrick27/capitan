<?php
header("Content-Type: application/json; charset=UTF-8");

include_once './dbclass.php';

    $dbclass = new Database();
    $connection = $dbclass->getConnection();

    $query = "SELECT f.id, f.sponsor, f.type, f.money FROM funds as f;";

    $stmt = $connection->query($query);

    $count = $stmt->num_rows;

    if($count > 0){


        $response = array();
        $response["body"] = array();
        $response["count"] = $count;

        while ($row = $stmt->fetch_assoc()){

            extract($row);

            $p  = array(
                "id" => $id,
                "sponsor" => $sponsor,
                "type" => $type,
                "money" => $money,
            );

            array_push($response["body"], $p);
        }

        echo json_encode($response);
    } else {
        echo json_encode(
            array("body" => array(), "count" => 0)
        );
    }
?>