<?php

use Dom\Mysql;

include "config.php";

header("Content-Type: application/json");
header("Http-Methods: POST");

$rawdata = file_get_contents("php://input", true);
$data=json_decode($rawdata,true);

if (isset($data)) {
    $name = $data["name"];
    $email = $data['email'];
    $password = $data['password'];
    $mobile = $data['mobile'];

    $sql = "SELECT * FROM users WHERE email='{$email}';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $result = json_encode([
            "HTTP" => 501,
            "message" => "Email Already Exist!!"
        ]);
        echo $result;
        exit;
    }

    if (count_chars($password) < 6) {
        $result = json_encode([
            "HTTP" => 501,
            "message" => "Password length should be more then 6!"
        ]);
        echo $result;
        exit;
    }

    // if (count_chars($mobile) != 10) {
    //     $result = json_encode([
    //         "HTTP" => 501,
    //         "message" => "Mobile Number should be 10 digit!"
    //     ]);
    //     echo $result;
    //     exit;
    // }


    $hash = password_hash($password, PASSWORD_BCRYPT);
    $sql2 = "INSERT INTO users(name,email,password,mobile) VALUES('{$name}','{$email}','{$hash}','{$mobile}');";
    if (mysqli_query($conn, $sql2)) {
        $result = json_encode([
            "HTTP" => 200,
            "message" => "User Saved in DB successfully!"
        ]);
        echo $result;
        exit;
    } else {
        $result = json_encode([
            "HTTP" => 501,
            "message" => "Server Side Error"
        ]);
        echo $result;
        exit;
    }
} else {
    $result = json_encode([
        "http" => 501,
        "message" => "Unable to fetch Request"
    ]);
    echo $result;
    exit;
}
