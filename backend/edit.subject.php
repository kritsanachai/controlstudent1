<?php  
    include("../include/connect.inc.php");

    $numSubject = $_POST['numSubject'];
    $subjectName = $_POST['subjectName'];
    $credit = $_POST['credit'];

    $qUpdate = $conn->prepare("UPDATE subject SET numSubject = :numSubject , subjectName = :subjectName , credit = :credit");
    $qUpdate->bindParam(":numSubject",$numSubject,PDO::PARAM_STR);
    $qUpdate->bindParam(":subjectName",$subjectName, PDO::PARAM_STR);
    $qUpdate->bindParam(":credit",$credit,PDO::PARAM_STR);
    $qUpdate->execute();

    if($qUpdate->execute()){
        echo json_encode("1");
    }else{
        echo json_encode("0");
    }
?>