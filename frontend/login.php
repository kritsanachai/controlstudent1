<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.0.0/mdb.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bulma@4/bulma.css" rel="stylesheet">
</head>

<body>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <div class="mb-md-2 mt-md-4 pb-5">

                                <h2 class="fw-bold mb-2 text-uppercase">เข้าสู่ระบบ</h2>
                                <p class="text-white-50 mb-5">กรุณาป้อนข้อมูลเข้าสู่ระบบและรหัสผ่านของคุณ!</p>

                                <div class="form-outline form-white mb-4" data-mdb-input-init>
                                    <input type="email" id="studentCode" class="form-control form-control-lg"
                                        required />
                                    <label class="form-label" for="typeEmailX">รหัสนักศึกษา</label>
                                </div>



                                <div class="form-outline form-white mb-4" data-mdb-input-init>
                                    <input type="password" id="codePass" class="form-control form-control-lg"
                                        required />
                                    <label class="form-label" for="typePasswordX">เลขบัตรประชาชน</label>
                                </div>

                                <button class="btn btn-outline-light btn-lg px-5" id="login">เข้าสู่ระบบ</button>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.0.0/mdb.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).on("click", "#login", function () {
            var studentCode = $('#studentCode').val();
            var codePass = $('#codePass').val();

            if (studentCode.trim() === '' || codePass.trim() === '') {
                Swal.fire({
                    title: "กรุณากรอกข้อมูลให้ครบถ้วน!!",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 1200
                }).then((result) => {
                    window.location.reload();
                });
            } else {
                // alert('Fetching data for student ID: ' + codePass);
                var formdata = new FormData();
                formdata.append("studentCode",studentCode);
                formdata.append("codePass",codePass);
                
                $.ajax({
                    url: "../backend/login_db.php",
                    type: "POST",
                    data: formdata,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        // alert(data)
                        // console.log(data)
                        if (data == 1) {
                            Swal.fire({
                                title: "เข้าสู่ระบบเรียบร้อย",
                                showConfirmButton: false,
                                icon: "success",
                                timer: 800,
                            }).then((result) => {
                                window.location.href = "index.php?page=home";
                            });
                        }else {
                            Swal.fire({
                                title: "ไม่พบข้อมูลผู้ใช้",
                                showConfirmButton: false,
                                icon: "error",
                                timer: 800,
                            });
                        }
                    },
                });
            }

        });
    </script>
</body>

</html>