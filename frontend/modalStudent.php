<?php
include("../include/connect.inc.php");
$idStudent = $_POST['studentCode'];

$qStudent = $conn->prepare("SELECT * FROM member WHERE studentCode = :studentCode");
$qStudent->bindParam(":studentCode", $idStudent, PDO::PARAM_STR);
$qStudent->execute();
$numRowStudent = $qStudent->rowCount();
if($numRowStudent != 1){
    echo json_encode(5);
    exit();
}
$dataStu = $qStudent->fetchObject();

function grade($score){
    $grade = 0;
    if($score >79){$grade = 4;}
    else if($score>74){$grade = 3.5;}
    else if($score>69){$grade = 3;}
    else if($score>64){$grade = 2.5;}
    else if($score>59){$grade = 2;}
    else if($score>54){$grade = 1.5;}
    else if($score>49){$grade = 1;}
    else{ $score = 0;}
    return $grade;
}
?>

<h3 class="d-flex justify-content-center fw-semibold mt-5">วิทยาลัยอาชีวศึกษานครปฐม</h3>
<p class="d-flex justify-content-center mt-3">90 ต. พระปฐมเจดีย์ อ.เมืองนครปฐม จ.นครปฐม 73000</p>

<h5 class="d-flex justify-content-center fw-semibold mt-5">รายงานผลการศึกษา</h5>
<div class="justify-content-center ">
    <div class="d-flex justify-content-around mt-2">
        <p>รหัสนักศึกษา :<span>
                <?php echo $idStudent ?>
            </span></p>
        <p>ชื่อ - สกุล : <span><?php echo $dataStu->name ?></span></p>
    </div>
</div>


<table class="table table-hover" style="width: 1100px;">
    <thead class="table-secondary">
        <tr>
            <th scope="col">รหัสวิชา</th>
            <th scope="col">ชื่อวิชา</th>
            <th scope="col">หน่วยกิต</th>
            <th scope="col">คะแนนที่ได้</th>
            <th scope="col">เกรด</th>
        </tr>
    </thead>
    <tbody>
        <?php

        $stu = $conn->prepare("SELECT * FROM log WHERE memberId = :memberId");
        $stu->bindParam(":memberId", $dataStu->memberId,PDO::PARAM_INT);
        $stu->execute();
        $scoreTotal = 0;
        $creditTotal = 0;
        while ($row = $stu->fetchObject()) {
            $qSubject = $conn->prepare("SELECT * FROM subject WHERE subjectId = :subjectId");
            $qSubject->bindParam(":subjectId", $row->subjectId, PDO::PARAM_INT);
            $qSubject->execute();
            $dataSubject = $qSubject->fetchObject();
            $grade = grade($row->score);
            $scoreTotal = $scoreTotal+($grade * $dataSubject->credit);
            $creditTotal = $creditTotal+$dataSubject->credit;
            ?>
            <tr>
                <td>
                    <?php echo $dataSubject->numSubject; ?>
                </td>
                <td>
                    <?php echo $dataSubject->subjectName; ?>
                </td>
                <td>
                    <?php echo $dataSubject->credit; ?>
                </td>
                <td><?php echo $row->score; ?></td>
                <td><?php echo $grade; ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot class="table-active">
        <tr>
            <td colspan="4" class="text-center">เกรดเฉลี่ยประจำภาค</td>
            <td><?php echo number_format($scoreTotal/$creditTotal,2) ?></td>
        </tr>
    </tfoot>
</table>