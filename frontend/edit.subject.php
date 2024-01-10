<?php  
    $id = $_POST['id'];
    include("../include/connect.inc.php");
    $qSubject = $conn->prepare("SELECT * FROM subject WHERE subjectId = :subjectId");
    $qSubject->bindParam(":subjectId",$id,PDO::PARAM_INT);
    $qSubject->execute();
    $data = $qSubject->fetchObject();
?>
<label for="">รหัสวิชา</label>
<input type="text" class="form-control my-2" id="numSubject" value="<?php echo $data->numSubject ?>">
<label for="">ชื่อวิชา</label>
<input type="text" class="form-control my-2" id="subjectName" value="<?php echo $data->subjectName ?>">
<label for="">หน่วยกิต</label>
<input type="text" class="form-control my-2" id="credit" value="<?php echo $data->credit ?>">
<button class="btn btn-success form-control my-2" id="submitSubject" data-id="<?php echo $id ?>">ยืนยัน</button>