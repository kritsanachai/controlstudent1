<?php  
    include("../include/connect.inc.php");
    $id = $_POST['id'];

    $qStudent = $conn->prepare("SELECT * FROM member WHERE memberId = :memberId");
    $qStudent->bindParam(":memberId",$id,PDO::PARAM_INT);
    $qStudent->execute();
    $data = $qStudent->fetchObject();
?>
<label for="">รหัสนักศึกษา</label>
<input type="text" class="form-control my-2" id="codeStudent" value="<?php echo $data->studentCode ?>">
<label for="">ชื่อ - นามสกุล</label>
<input type="text" class="form-control my-2" id="name" value="<?php echo $data->name ?>">
<button class="btn btn-success form-control my-3" id="btnEditStudent" data-id="<?php echo $id ?>">ยืนยัน</button>