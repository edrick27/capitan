<?php
header("Content-Type: application/json; charset=UTF-8");

include_once './dbclass.php';

    $dbclass = new Database();
    $connection = $dbclass->getConnection();

    $query = "SELECT 
                    f.type as `type`,
                    SUM(f.money) as `total`,
                    ((SUM(f.money) / 20000) * 100)  as `porcent`
                FROM funds as f            
                GROUP BY type;";

    $stmt = $connection->query($query);

    $count = $stmt->num_rows;

    if($count > 0){


        $response = array();
        $response["body"] = array();
        $response["count"] = $count;

        while ($row = $stmt->fetch_assoc()){

            extract($row);

            $p  = array(
                "type" => $type,
                "total" => $total,
                "porcent" => $porcent,
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