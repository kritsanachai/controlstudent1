<?php
session_start();
$user = $_SESSION['iUser'];

if ($user['status'] != "admin") { ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: "คุณไม่มีสิทธิ์ใช้งานหน้านี้",
            icon: "error",
            showConfirmButton: false,
            timer: 900
        }).then(() => {
            window.location.href = "login.php";
        })
    </script>
<?php } else {
    ?>
    <!doctype html>
    <html lang="en">

    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS v5.2.1 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="styleIndex.css">
        <!-- Option 1: Include in HTML -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    </head>

    <body>
        <div class="row sticky-top">
            <div class="col-2 sidebarNavbar">
                <div class="my-2 ms-3 text-light">Student Control</div>
            </div>
            <div class="col-10 d-flex justify-content-end pe-5 navbar">
                <div class="dropdown">
                    <button class="btn btn-none dropdown-toggle" type="button" id="triggerId" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <?php echo $user['name'] ?>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="triggerId">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row rowcontent">
            <div class="col-2 sidebar sticky-top">
                <div class="d-flex justify-content-center">
                    <ul class="nav nav-pill flex-column">
                        <li class="nav-iten"><a href="?page=home" class="nav-link text-light py-auto ">หน้าหลัก</a></li>
                        <li class="nav-iten"><a href="?page=timetable" class="nav-link text-light">ตารางสอน</a></li>
                        <li class="nav-iten"><a href="?page=score" class="nav-link text-light">คะแนน</a></li>
                        <li class="nav-iten"><a href="?page=subject" class="nav-link text-light">รายวิชา</a></li>
                        <li class="nav-iten"><a href="?page=student" class="nav-link text-light">รายชื่อนักเรียน</a></li>
                    </ul>
                </div>

            </div>
            <div class="col-10 content">
                <div id="iCen">

                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <!-- Bootstrap JavaScript Libraries -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
            integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
            </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
            integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
            </script>

    </body>

    <script>
        var urlParams = new URLSearchParams(window.location.search);
        var page = urlParams.get('page');
        var formdata = new FormData();
        formdata.append("page", page);
        $.ajax({
            url: "page.all.php",
            type: "POST",
            data: formdata,
            dataType: "html",
            contentType: false,
            processData: false,
            success: function (data) {
                $("#iCen").html(data);
            }
        })
    </script>

    </html>
<?php } ?>