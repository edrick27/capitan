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
    $id = htmlspecialchars(strip_tags($_POST['id']));
    $type = htmlspecialchars(strip_tags($_POST['type']));
    $sponsor = htmlspecialchars(strip_tags($_POST['sponsor']));
    $money = htmlspecialchars(strip_tags($_POST['money']));

    if($id == 0){
        $query = "INSERT INTO `funds` (`sponsor`, `type`, `money`) 
            VALUES ('$sponsor', '$type', '$money');";
    }else{
        $query = "UPDATE `funds`
                    SET `sponsor` = '$sponsor',
                        `type` = '$type',
                        `money` = '$money'
                    WHERE id = '$id'";
    }
    
    if ($connection->query($query) === TRUE) {
        echo "success";
    } else {
        echo "Error: " . $query . "<br>" . $connection->error;
    }
?>