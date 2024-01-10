<?php  
    include("../include/connect.inc.php");
    $id = $_POST['id'];
    $codeStudent = $_POST['codeStudent'];
    $name = $_POST['name'];

    $qEditStudent = $conn->prepare("UPDATE member SET studentCode = :studentCode , name = :name WHERE memberId = :id");
    $qEditStudent->bindParam(":studentCode",$codeStudent,PDO::PARAM_STR);
    $qEditStudent->bindParam(":name",$name,PDO::PARAM_STR);
    $qEditStudent->bindParam(":id",$id,PDO::PARAM_STR);

    if($qEditStudent->execute()){
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }
?>