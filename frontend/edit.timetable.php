<?php 
    $id = $_POST['id'];
    $date = $_POST['date'];
    $subject = $_POST['subject'];
    $times = $_POST['times'];
    $timee = $_POST['timee'];
?>

<label for="" class="">วันที่</label>
<input type="text" class="form-control my-2" id="date" value="<?php echo $date; ?>">
<label for="" class="">วิชา</label>
<input type="text" class="form-control my-2" id="subject" value="<?php echo $subject; ?>">
<label for="" class="">เวลาเริ่มคาบ</label>
<input type="text" class="form-control my-2" id="times" value="<?php echo $times; ?>">
<label for="" class="">เวลาจบคาบ</label>
<input type="text" class="form-control my-2" id="timee" value="<?php echo $timee; ?>">
<button class="btn btn-success form-control" id="btnSubmit" data-id="<?php echo $id; ?>">ยืนยัน</button>