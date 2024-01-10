<?php  
    include("../include/connect.inc.php");
    $subjectId = $_POST['id'];

    $qDel = $conn->prepare("DELETE FROM subject WHERE subjectId = :subjectId");
    $qDel->bindParam(":subjectId",$subjectId,PDO::PARAM_INT);
    $qDel->execute();

    $qlogDel = $conn->prepare("DELETE FROM log WHERE subjectId = :subjectId");
    $qlogDel->bindParam(":subjectId",$subjectId,PDO::PARAM_INT);
    $qlogDel->execute();

    if($qDel->execute() && $qlogDel->execute()){
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }
?>