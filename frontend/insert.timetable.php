<?php
include("../include/connect.inc.php");
$qSubject = $conn->prepare("SELECT * FROM subject");
$qSubject->execute();
?>

<label for="">วันที่</label>
<select id="date" class="form-select my-2">
    <option value="" selected>โปรดเลือกวัน</option>
    <option value="1">วันจันทร์</option>
    <option value="2">วันอังคาร</option>
    <option value="3">วันพุธ</option>
    <option value="4">วันพฤหัสบดี</option>
    <option value="5">วันศุกร์</option>
</select>
<label for="">รายวิชา</label>
<select id="subjectName" class="form-select my-2">
    <option value="" selected>โปรดเลือกวิชา</option>
    <?php
    while ($data = $qSubject->fetchObject()) {
    ?>
        <option value="<?php echo $data->subjectName ?>"><?php  echo $data->subjectName ?></option>
    <?php
    }
    ?>
</select>
<label for="">เวลาเริ่ม</label>
<input type="text" class="form-control my-2" id="times">
<label for="">เวลาจบ</label>
<input type="text" class="form-control my-2" id="timee">
<button class="btn btn-success form-control" id="btnInsert">ยืนยัน</button>