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

    $query = "SELECT 
                f.id,
                f.sponsor,
                f.money
            FROM `funds` AS f 
            WHERE f.type = $type";

    $stmt = $connection->query($query);

    $count = $stmt->num_rows;

    if($count > 0){


        $response = array();
        $response["body"] = array();

        while ($row = $stmt->fetch_assoc()){

            extract($row);

            $p  = array(
                "id" => $id,
                "sponsor" => $sponsor,
                "money" => $money
            );

            array_push($response["body"], $p);
        }

        $response["general"] = array();

        $query = "SELECT 
                    ((SUM(f.money) / ft.total) * 100)  AS `porcent`  
                FROM `funds` AS f 
                LEFT JOIN funds_type ft ON ft.id = f.type
                WHERE f.type = $type";

        $stmt = $connection->query($query);
        setlocale(LC_MONETARY, 'en_US');
        while ($row = $stmt->fetch_assoc()){

            extract($row);
            
            $p  = array(
                "porcent" => is_null($porcent) ? "0%" : floor($porcent) . "%" ,
            );

            array_push($response["general"], $p);
        }

        echo json_encode($response);
    } else {
        echo json_encode(
            array("body" => array(), "general" => array())
        );
    }
?>