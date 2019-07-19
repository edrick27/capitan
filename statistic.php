<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once './dbclass.php';

    $dbclass = new Database();
    $connection = $dbclass->getConnection();

    $query = "SELECT 
                    ft.id AS `id`,
                    ft.name AS `name`,
                    ft.color AS `color`,
                    ft.icon AS `icon`,
                    f.total AS `total`,
                    f.porcent AS `porcent`
                    
                FROM funds_type AS ft  
                    LEFT JOIN 
                        (SELECT
                            funds.type AS `type`,
                            SUM(funds.money) AS `total`,
                            ((SUM(funds.money) / 250000) * 100)  AS `porcent`
                        FROM funds
                        GROUP BY funds.type) AS f
                    ON f.type = ft.id";

    $stmt = $connection->query($query);

    $count = $stmt->num_rows;

    if($count > 0){


        $response = array();
        $response["body"] = array();

        while ($row = $stmt->fetch_assoc()){

            extract($row);

            $p  = array(
                "id" => $id,
                "name" => $name,
                "color" => $color,
                "icon" => $icon,
                "total" => $total,
                "porcent" => is_null($porcent) ? "0%" : floor($porcent) . "%" ,
            );

            array_push($response["body"], $p);
        }

        $response["general"] = array();

        $query = "SELECT
                    SUM(funds.money) AS `raised`,
                    ((SUM(funds.money) / 250000) * 100)  AS `funded`,
                    COUNT(DISTINCT funds.sponsor)  AS `sponsors`
                FROM funds";

        $stmt = $connection->query($query);
        setlocale(LC_MONETARY, 'en_US');
        while ($row = $stmt->fetch_assoc()){

            extract($row);
            
            $p  = array(
                "raised" => "$" . number_format( $raised, 0 ),
                "funded" => is_null($funded) ? "0%" : floor($funded) . "%" ,
                "sponsors" => $sponsors,
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