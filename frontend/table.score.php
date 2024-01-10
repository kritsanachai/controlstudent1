
<?php  
    include("../include/connect.inc.php");
    $subjectId = $_POST['id'];

    $qStudent = $conn->prepare("SELECT * FROM member WHERE status='user' ORDER BY studentCode ASC");
    $qStudent->execute();
    $row = $qStudent->rowCount();
    $i = 1;
    while($data = $qStudent->fetchObject()){
        $qLogScore = $conn->prepare("SELECT * FROM log WHERE memberId = :memberId AND subjectId = :subjectId");
        $qLogScore->bindParam(":memberId",$data->memberId,PDO::PARAM_INT);
        $qLogScore->bindParam(":subjectId",$subjectId,PDO::PARAM_INT);
        $qLogScore->execute();
        $dataLog = $qLogScore->fetchObject();
        $rowLog = $qLogScore->rowCount();
        ?>
        <tr>
            <td><?php echo $data->studentCode ?></td>
            <td><?php echo $data->name ?></td>
            <td><input type="number" id="score_<?php echo $i; ?>" class="form-control" min="0" value="<?php if($rowLog == 0){
                echo 0;
            }else{
                echo $dataLog->score;
            }
     
                
             ?>" max="100" style="width: 100px;"></td>
        </tr>
   <?php $i++ ; }
?>
<tr>
    <td colspan="3"><button class="btn btn-success form-control" id="submitScore" data-subjectid="<?php echo $subjectId ?>" data-count="<?php echo $row ?>">บันทึกคะแนน</button></td>
</tr>
