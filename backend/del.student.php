<?php  
    include("../include/connect.inc.php");

    $id = $_POST['id'];
    
    $qDelStudent = $conn->prepare("DELETE FROM member WHERE memberId = :id");
    $qDelStudent->bindParam(":id",$id,PDO::PARAM_INT);

    if($qDelStudent->execute()){
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }
?>