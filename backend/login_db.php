<?php 
    include("../include/connect.inc.php");
    session_start();

    $studentCode = $_POST['studentCode'];
    $codePass = $_POST['codePass'];
    $status = "admin";

    // echo json_encode($studentCode . $codePass);
    // echo json_encode(0);
    $user = $conn->prepare("SELECT * FROM member WHERE studentCode = :studentCode AND codePass = :codePass AND status = :status");
    $user->bindParam(":studentCode", $studentCode, PDO::PARAM_STR);
    $user->bindParam(":status", $status, PDO::PARAM_STR);
    $user->bindParam(":codePass", $codePass, PDO::PARAM_STR);
    $user->execute();

    $row = $user->rowCount();
// echo json_encode(0);
    if($row == 1){
        $data = $user->fetch(PDO::FETCH_ASSOC);
        $_SESSION['iUser'] = $data;
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }

?>