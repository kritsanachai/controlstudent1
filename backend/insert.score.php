<?php
include("../include/connect.inc.php");
$count = $_POST['count'];
$subjectId = $_POST['subjectId'];
$i = 1;
$dataSc = array();
$len = 0;

//เก็บค่าคะแนนใส่ในarray
while ($i <= $count) {
    $name = "score_" . $i;
    array_push($dataSc, $_POST[$name]);
    $i++;
}


$qStudent = $conn->prepare("SELECT * FROM member WHERE status='user' ORDER BY studentCode ASC");
$qStudent->execute();
$j = 0;
while ($data = $qStudent->fetchObject()) {
    $score = $dataSc[$j];
    
    $qlogCheck = $conn->prepare("SELECT * FROM log WHERE subjectId = :subjectId AND memberId = :memberId ");
    $qlogCheck->bindParam(":subjectId", $subjectId , PDO::PARAM_INT);
    $qlogCheck->bindParam(":memberId", $data->memberId, PDO::PARAM_INT);
    $qlogCheck->execute();
    $rowLogCheck = $qlogCheck->rowCount();
    
    if ($rowLogCheck == 1) {
        $qUpdateScore = $conn->prepare("UPDATE log SET score = :score WHERE subjectId = :subjectId AND memberId = :memberId ");
        $qUpdateScore->bindParam(":subjectId", $subjectId,PDO::PARAM_INT);
        $qUpdateScore->bindParam(":memberId", $data->memberId,PDO::PARAM_INT);
        $qUpdateScore->bindParam(":score", $score,PDO::PARAM_INT);
        $qUpdateScore->execute();
    } else if ($rowLogCheck > 1) {
        $qDellog = $conn->prepare("DELETE FROM log WHERE subjectId = :subjectId AND memberId = :memberId");
        $qDellog->bindParam(":subjectId", $subjectId,PDO::PARAM_INT);
        $qDellog->bindParam(":memberId", $data->memberId,PDO::PARAM_INT);
        if ($qDellog->execute()) {
            $qInlog = $conn->prepare("INSERT INTO log (subjectId,memberId,score) VALUES (:subjectId,:memberId,:score)");
            $qInlog->bindParam(":subjectId", $subjectId,PDO::PARAM_INT);
            $qInlog->bindParam(":memberId", $data->memberId,PDO::PARAM_INT);
            $qInlog->bindParam(":score", $score,PDO::PARAM_INT);
            $qInlog->execute();
        } else {
            

        }
    } else {
        $qInlog = $conn->prepare("INSERT INTO log (subjectId,memberId,score) VALUES (:subjectId,:memberId,:score)");
        $qInlog->bindParam(":subjectId", $subjectId ,PDO::PARAM_INT);
        $qInlog->bindParam(":memberId", $data->memberId ,PDO::PARAM_INT);
        $qInlog->bindParam(":score", $score, PDO::PARAM_INT);
        $qInlog->execute();
    }
    $j++;
}
    echo json_encode("1");
    
?>