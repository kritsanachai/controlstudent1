<?php  
    include("../include/connect.inc.php");
    $codeStudent = $_POST['codeStudent'];
    $name = $_POST['name'];

    $qInsert = $conn->prepare("INSERT INTO member (studentCode,name,status) VALUES (:codeStudent,:name,'user')");
    $qInsert->bindParam("codeStudent",$codeStudent,PDO::PARAM_STR);
    $qInsert->bindParam("name",$name,PDO::PARAM_STR);
    if($qInsert->execute()){
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }

?>