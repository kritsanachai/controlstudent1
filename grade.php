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
    <link rel="stylesheet" href="frontend/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bulma@4/bulma.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <div class="row height d-flex justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="form">
                    <i class="fa fa-search"></i>
                    <input type="text" id="studentIdInput" class="form-control form-input"
                        placeholder="กรอกรหัสนักศึกษา">

                    <span class="left-pan"><button onclick="checkAndDisplayData()"><i
                                class="fa-solid fa-magnifying-glass"></i></button></span>
                </div>
            </div>
        </div>
    </div>








    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        function checkAndDisplayData() {
            var studentId = document.getElementById('studentIdInput').value;
            if (studentId.trim() === '') {
                Swal.fire({
                    title: "ไม่สามารถค้นหาได้",
                    text: "โปรดกรอกรหัสนักศึกษา!!",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 1200
                });

            } else {
                // alert('Fetching data for student ID: ' + studentId);
                var formdata = new FormData();
                formdata.append("studentCode", studentId);
                $.ajax({
                    url: "frontend/modalStudent.php",
                    type: "POST",
                    data: formdata,
                    dataType: "html",
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data == 5) {
                            Swal.fire({
                                icon:"error",
                                title:"ไม่พบเลขประจำตัวนักศึกษา",
                                showConfirmButton:false,
                                timer:900
                            })
                        } else {
                            Swal.fire({
                                width: '1200px',
                                showConfirmButton: false,
                                html: data
                            });
                        }

                    }
                })
            }

        }
    </script>
</body>

</html>