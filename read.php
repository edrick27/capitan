<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once './dbclass.php';

    $dbclass = new Database();
    $connection = $dbclass->getConnection();

    $query = "SELECT 
                f.id, 
                f.sponsor, 
                ft.name AS type, 
                f.money 
            FROM funds AS f 
            LEFT JOIN funds_type AS ft on ft.id = f.type
            ORDER BY f.id DESC;";

    $stmt = $connection->query($query);

    if($stmt->num_rows > 0){


        $response = array();
        $response["data"] = array();

        while ($row = $stmt->fetch_assoc()){

            extract($row);

            $item  = array(
                "id" => $id,
                "sponsor" => $sponsor,
                "type" => $type,
                "money" => $money,
            );

            array_push($response["data"], $item);
        }

        echo json_encode($response);
    } else {
        echo json_encode([]);
    }
?>