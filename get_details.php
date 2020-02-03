<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once './dbclass.php';

    $dbclass = new Database();
    $connection = $dbclass->getConnection();
    $type = htmlspecialchars(strip_tags($_POST['type']));

    $response = array();
    $response["body"] = array();
    $response["general"] = array();

    $query = "SELECT 
                ((SUM(f.money) / ft.total) * 100)  AS `porcent`,
                ft.total  AS `total`
            FROM id10129394_lets_go_to_switzerland.funds_type ft 
            LEFT JOIN `funds` f ON f.type = ft.id
            WHERE ft.id = $type;";

    $stmt = $connection->query($query);
    
    setlocale(LC_MONETARY, 'en_US');
    while ($row = $stmt->fetch_assoc()){

        extract($row);
        
        $p  = array(
            "porcent" => is_null($porcent) ? "0%" : floor($porcent) . "%" ,
            "total" => $total
        );

        array_push($response["general"], $p);
    }

    $query = "SELECT 
                f.id,
                f.sponsor,
                f.money
            FROM `funds` AS f 
            WHERE f.type = $type
            ORDER BY f.money DESC";

    $stmt = $connection->query($query);

    $count = $stmt->num_rows;

    if($count > 0){

        while ($row = $stmt->fetch_assoc()){

            extract($row);

            $p  = array(
                "id" => $id,
                "sponsor" => $sponsor,
                "money" => $money
            );

            array_push($response["body"], $p);
        }

        echo json_encode($response);
    } else {
        echo json_encode($response);
    }
?>