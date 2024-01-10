<?php
include("../include/connect.inc.php");
$page = $_POST['page'];

if ($page == "home") {

}

if ($page == "timetable") { ?>


    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <label for="" class="form-label">โปรดเลือกวัน</label>
                <select class="form-select form-select-lg" id="Date">
                    <option selected>โปรดเลือกวัน</option>
                    <option value="1">วันจันทร์</option>
                    <option value="2">วันอังคาร</option>
                    <option value="3">วันพุธ</option>
                    <option value="4">วันพฤหัสบดี</option>
                    <option value="5">วันศุกร์</option>
                    <option value="6">วันเสาร์</option>
                    <option value="7">วันอาทิตย์</option>
                </select>

                <hr>
                <button class="btn btn-primary form-control" id="Insert">เพิ่มตารางเรียน</button>
                <hr>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">วัน</th>
                                <th scope="col">วิขา</th>
                                <th scope="col">เวลาเริ่ม</th>
                                <th scope="col">เวลาสิ้นสุด</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="iCenTable">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).on("click", "#btnInsert", function () {
            var date = $('#date').val();
            var subject = $('#subjectName').val();
            var timee = $('#timee').val();
            var times = $('#times').val();

            var body = {
                sheet1: {
                    "วันที่": date,
                    "วิชา": subject,
                    "เวลาเริ่มต้น": times,
                    "สิ้นสุด": timee
                }
            };

            $.ajax({
                url: 'https://api.sheety.co/f9e439f0d8659ccc4b62e877905aabc9/แจ้งเตือนเวลาเข้าเรียน/sheet1',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(body),
                success: function (json) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "เพิ่มลงตารางสอนเสร็จสิ้น",
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                }
            });
        });

        $(document).on("click", "#Insert", function () {
            $.ajax({
                url: "insert.timetable.php",
                type: "POST",
                dataType: "html",
                success: function (data) {
                    Swal.fire({
                        title: "เพิ่มรายวิชาในตาราง",
                        html: data,
                        showConfirmButton: false,
                    })
                }
            })

        });

        $(document).on("input", "#Date", function () {
            let url = 'https://api.sheety.co/f9e439f0d8659ccc4b62e877905aabc9/แจ้งเตือนเวลาเข้าเรียน/sheet1';
            var date = $(this).val();
            var dataTable = "";
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function (json) {
                    json.sheet1.sort(function (a, b) {
                        if (a.เวลาเริ่มต้น < b.เวลาเริ่มต้น) return -1;
                        if (a.เวลาเริ่มต้น > b.เวลาเริ่มต้น) return 1;
                        return 0;
                    });

                    json.sheet1.map(function (res) {
                        if (res.วันที่ == date) {
                            dataTable = dataTable + "<tr>" +
                                "<td>" + res.วันที่ + "</td>" +
                                "<td>" + res.วิชา + "</td>" +
                                "<td>" + res.เวลาเริ่มต้น + "</td>" +
                                "<td>" + res.สิ้นสุด + "</td>" +
                                "<td><button class='btn btn-warning' data-timee=" + res.สิ้นสุด + "  data-times=" + res.เวลาเริ่มต้น + " data-id=" + res.id + " data-date=" + res.วันที่ + " data-subject=" + res.วิชา + " id='btnEdit'>แก้ไข</button><td>" +
                                "<td><button class='btn btn-danger' data-id=" + res.id + " id='btnDel'>ลบ</button></td>" +
                                "</tr>";
                        }
                    });
                    $('#iCenTable').html(dataTable);
                }
            });


        }); // สิ้นสุด

        $(document).on("click", "#btnDel", function () {
            try {
                var id = $(this).data("id");
            let url = 'https://api.sheety.co/f9e439f0d8659ccc4b62e877905aabc9/แจ้งเตือนเวลาเข้าเรียน/sheet1/' + id;
            console.log(url);
            fetch(url, {
                method: 'DELETE',
            })
                .then(() => {
                    console.log('Object deleted');
                })
            Swal.fire({
                position: "top-end",
                icon: "success",
                showConfirmButton: false,
                title: "ลบเสร็จสิ้น",
                timer: 1000
            }).then(() => {
                window.location.reload();
            });
            } catch (error) {
                console.log(error)
            }
            
        });

        $(document).on("click", "#btnEdit", function () {
            var id = $(this).data("id");
            var date = $(this).data("date");
            var subject = $(this).data("subject");
            var times = $(this).data("times");
            var timee = $(this).data("timee");
            var formdata = new FormData();
            formdata.append("id", id);
            formdata.append("date", date);
            formdata.append("subject", subject);
            formdata.append("times", times);
            formdata.append("timee", timee);
            $.ajax({
                url: "edit.timetable.php",
                type: "POST",
                data: formdata,
                dataType: "html",
                contentType: false,
                processData: false,
                success: function (data) {
                    Swal.fire({
                        title: "แก้ไขตารางเรียน",
                        showConfirmButton: false,
                        html: data
                    })
                }
            });



        });

        $(document).on("click", "#btnSubmit", function () {
            var id = $(this).data("id");
            var date = $('#date').val();
            var subject = $('#subject').val();
            var times = $('#times').val();
            var timee = $('#timee').val();

            let url = 'https://api.sheety.co/f9e439f0d8659ccc4b62e877905aabc9/แจ้งเตือนเวลาเข้าเรียน/sheet1/' + id;
            let body = {
                sheet1: {
                    "วันที่": date,
                    "วิชา": subject,
                    "เวลาเริ่มต้น": times,
                    "สิ้นสุด": timee
                }
            };

            $.ajax({
                url: url,
                type: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify(body),
                success: function (response) {
                    Swal.fire({
                        position: "top-end",
                        title: "เสร็จสิ้น",
                        showConfirmButton: false,
                        timer: 1000
                    }).then((result) => {
                        window.location.reload();
                    });
                }
            });
        });
    </script>



<?php }

if ($page == "score") {
    $qSubject = $conn->prepare("SELECT * FROM subject");
    $qSubject->execute();
    ?>
    <label for="" class="form-label">เลือกวิชา</label>
    <select class="form-select form-select-lg" id="subjectSL">
        <option selected>Select one</option>
        <?php
        while ($data = $qSubject->fetchObject()) { ?>
            <option value="<?php echo $data->subjectId ?>">
                <?php echo $data->subjectName ?>
            </option>
        <?php } ?>

    </select>
    <hr>
    <div class="table-responsive">
        <table class="table ">
            <thead>
                <tr>
                    <th scope="col">รหัสนักศึกษา</th>
                    <th scope="col">ชื่อ</th>
                    <th scope="col">คะแนน </th>
                </tr>
            </thead>
            <tbody id="tableScore">

            </tbody>
        </table>
    </div>






    <script>
        $(document).on("click", "#submitScore", function () {
            var count = $(this).data("count");
            var subjectId = $(this).data("subjectid");
            var i = 1;
            var formdata = new FormData();
            formdata.append("count", count);
            formdata.append("subjectId", subjectId);
            while (i <= count) {
                var obj = "score_" + i;
                var score = $("#" + obj).val();
                formdata.append(obj, score);
                i++;
            }

            $.ajax({
                url: "../backend/insert.score.php",
                type: "POST",
                data: formdata,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data);
                    if (data == 1) {
                        Swal.fire({
                            position: "center",
                            title: "เสร็จสิ้น",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 900
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            position: "center",
                            title: "เกิดข้อผิดพลาด",
                            icen: "error",
                            showConfirmButton: false,
                            timer: 900
                        })
                    }
                }
            })
        })
        $(document).on("input", "#subjectSL", function () {
            var subjectId = $(this).val();
            var formdata = new FormData();
            formdata.append("id", subjectId);
            $.ajax({
                url: "table.score.php",
                type: "POST",
                data: formdata,
                dataType: "html",
                contentType: false,
                processData: false,
                success: function (data) {
                    $('#tableScore').html(data)
                }
            })
        });
    </script>
<?php }
if ($page == "subject") {
    $qSubject = $conn->prepare("SELECT * FROM subject");
    $qSubject->execute();
    ?>
    <div class="container">

        <div class="table-responsive">
            <button class='btn btn-warning form-control my-3 shadow' id="insertSubject">เพิ่มรายวิชา</button>
            <table class="table ">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ชื่อรายวิชา</th>
                        <th scope="col">หน่วยกิต</th>
                        <th scope="col"></th>
                        <th scope="col"></th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($data = $qSubject->fetchObject()) {
                        ?>
                        <tr class="">
                            <td scope="row">
                                <?php echo $data->numSubject ?>
                            </td>
                            <td>
                                <?php echo $data->subjectName ?>
                            </td>
                            <td>
                                <?php echo $data->credit ?>
                            </td>
                            <td><button class="btn btn-warning" id="subjectEdit"
                                    data-id="<?php echo $data->subjectId ?>">แก้ไข</button></td>
                            <td><button class="btn btn-danger" id="subjectDel"
                                    data-id="<?php echo $data->subjectId ?>">ลบ</button></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>

        $(document).on("click", "#btnInsertSubject", function () {
            var numSubject = $('#numSubject').val();
            var subjectName = $('#subjectName').val();
            var credit = $('#credit').val();
            var formdata = new FormData();
            formdata.append("numSubject", numSubject);
            formdata.append("subjectName", subjectName);
            formdata.append("credit", credit);

            $.ajax({
                url: "../backend/insert.subject.php",
                type: "POST",
                data: formdata,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 1) {
                        Swal.fire({
                            position: "top-end",
                            title: "เสร็จสิ้น",
                            timer: 800,
                            showConfirmButton: false,
                            icon: "success"
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            position: "top-end",
                            title: "เกิดข้อผิดพลาด",
                            icon: "error",
                            showConfirmButton: false,
                            timer: 900
                        });
                    }
                }

            })
        })
        $(document).on("click", "#insertSubject", function () {
            $.ajax({
                url: "insert.subject.php",
                dataType: "html",
                success: function (data) {
                    Swal.fire({
                        title: "เพิ่มรายวิชา",
                        showConfirmButton: false,
                        html: data
                    })
                }
            })
        })

        $(document).on("click", "#submitSubject", function () {
            var numSubject = $('#numSubject').val();
            var subjectName = $('#subjectName').val();
            var credit = $('#credit').val();
            var formdata = new FormData();
            formdata.append("numSubject", numSubject);
            formdata.append("subjectName", subjectName);
            formdata.append("credit", credit);

            $.ajax({
                url: "../backend/edit.subject.php",
                type: "POST",
                data: formdata,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 1) {
                        Swal.fire({
                            position: "top-end",
                            title: "แก้ไขเสร็จสิ้น",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1000
                        }).then(() => {
                            window.location.reload();
                        })
                    } else {
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: "เกิดข้อผิดพลาด",
                            showConfirmButton: false
                        })
                    }

                }
            })
        })

        $(document).on("click", "#subjectEdit", function () {
            var formdata = new FormData();
            var id = $(this).data("id");
            formdata.append("id", id);
            $.ajax({
                url: "edit.subject.php",
                type: "POST",
                data: formdata,
                dataType: "html",
                contentType: false,
                processData: false,
                success: function (data) {
                    Swal.fire({
                        title: "แก้ไขรายวิขา",
                        showConfirmButton: false,
                        html: data
                    });
                }
            });
        });

        $(document).on("click", "#subjectDel", function () {
            var formdata = new FormData();
            var id = $(this).data("id");
            formdata.append("id", id);
            $.ajax({
                url: "../backend/del.subject.php",
                type: "POST",
                data: formdata,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 1) {
                        Swal.fire({
                            title: "แก้ไขรายวิขา",
                            showConfirmButton: false,
                            icon: "success",
                            timer: 800
                        }).then(() => {
                            window.location.reload();
                        })
                    } else {
                        Swal.fire({
                            position: "top-end",
                            title: "เกิดข้อผิดพลาด",
                            icon: "error",
                            timer: 1000,
                            showConfirmButton: false
                        })
                    }

                }
            });
        });
    </script>



<?php }
if ($page == "student") {
    $qStudent = $conn->prepare("SELECT * FROM member WHERE status = 'user'");
    $qStudent->execute();
    ?>
    <div class="container mt-5">
        <button class="btn btn-primary shadow form-control mb-5" id="insertStudent">เพิ่มนักศึกษา</button>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">เลขนักศึกษา</th>
                        <th scope="col">รายชื่อ</th>
                        <th></th>
                        <th></th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    while ($data = $qStudent->fetchObject()) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $i; ?>
                            </td>
                            <td>
                                <?php echo $data->studentCode; ?>
                            </td>
                            <td>
                                <?php echo $data->name; ?>
                            </td>
                            <td><button class="btn btn-warning" id="editStudent"
                                    data-id="<?php echo $data->memberId ?>">แก้ไข</button></td>
                            <td><button class="btn btn-danger" id="delStudent"
                                    data-id="<?php echo $data->memberId ?>">ลบ</button></td>

                        </tr>
                        <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div>

    </div>

    <script>
        $(document).on("click","#delStudent",function(){
            var id = $(this).data("id");
            var formdata = new FormData();
            formdata.append("id",id);

            $.ajax({
                url:"../backend/del.student.php",
                type:"POST",
                data:formdata,
                dataType:"json",
                contentType:false,
                processData:false,
                success:function(data){
                    if(data == 1){
                        Swal.fire({
                            position:"top-end",
                            icon:"success",
                            showConfirmButton:false,
                            timer:900,
                            title:"ลบข้อมูลเสร็จสิ้น",
                        }).then( () => {
                            window.location.reload();
                        })
                    }else{
                        Swal.fire({
                            position:"top-end",
                            icon:"error",
                            showConfirmButton:false,
                            timer:900,
                            title:"เกิดข้อผิดพลาด"
                        })
                    }
                }
            })
        });

        $(document).on("click", "#btnEditStudent", function () {
            var id = $(this).data("id");
            var codeStudent = $('#codeStudent').val();
            var name = $('#name').val();
            var formdata = new FormData();
            formdata.append("id", id);
            formdata.append("codeStudent", codeStudent);
            formdata.append("name", name);

            $.ajax({
                url: "../backend/edit.student.php",
                type: "POST",
                data: formdata,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 1) {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            showConfirmButton: false,
                            title: "แก้ไขข้อมูลเสร็จสิ้น",
                            timer: 900
                        }).then(() => {
                            window.location.reload();
                        })
                    } else {
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            showConfirmButton: false,
                            timer: 900,
                            title: "เกิดข้อผิดพลาด"
                        })
                    }
                }
            })
        })

        $(document).on("click", "#editStudent", function () {
            var id = $(this).data("id");
            var formdata = new FormData();
            formdata.append("id", id);
            console.log(id)
            $.ajax({
                url: "edit.student.php",
                type: "POST",
                data: formdata,
                dataType: "html",
                contentType: false,
                processData: false,
                success: function (data) {
                    Swal.fire({
                        title: "แก้ไขรายชื่อนักศึกษา",
                        showConfirmButton: false,
                        html: data
                    });
                }
            })
        });

        $(document).on("click", "#insertStudent", function () {
            $.ajax({
                url: "insert.student.php",
                dataType: "html",
                success: function (data) {
                    Swal.fire({
                        title: "เพิ่มรายชื่อนักศึกษา",
                        showConfirmButton: false,
                        html: data
                    });
                }
            })
        });

        $(document).on("click", "#btnInsertStudent", function () {
            var codeStudent = $('#codeStudent').val();
            var name = $('#name').val();
            var formdata = new FormData();
            formdata.append("codeStudent", codeStudent);
            formdata.append("name", name);

            $.ajax({
                url: "../backend/insert.student.php",
                type: "POST",
                data: formdata,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 1) {
                        Swal.fire({
                            position: "top-end",
                            showConfirmButton: false,
                            icon: "success",
                            title: "เพิ่มนักศึกษาเสร็จสิ้น",
                            timer: 800
                        }).then((result) => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            position: "top-end",
                            showConfirmButton: false,
                            icon: "error",
                            timer: 900,
                            title: "เกิดข้อผิดพลาด",
                        })
                    }

                }
            })
        })
    </script>
<?php }
?>