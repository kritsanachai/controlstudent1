<?php 
    include("../include/connect.inc.php");
    $numSubject = $_POST['numSubject'];
    $subjectName = $_POST['subjectName'];
    $credit = $_POST['credit'];

    $qInSubject = $conn->prepare("INSERT INTO subject (numSubject,subjectName,credit) VALUES (:numSubject,:subjectName,:credit)");
    $qInSubject->bindParam(":numSubject",$numSubject,PDO::PARAM_STR);
    $qInSubject->bindParam(":subjectName",$subjectName,PDO::PARAM_STR);
    $qInSubject->bindParam(":credit",$credit,PDO::PARAM_STR);

    if($qInSubject->execute()){
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }

?>