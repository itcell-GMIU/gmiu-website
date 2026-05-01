<?php
include './dbconnect.php';
include './operations.php';

$cndComp = array("is_active" => 1);
$recComp = $crud->readRecordsWithConditions("tbl_competetion", $cndComp);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sahitya Parishad</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!--Use latest version-->
    <!--<script disable-devtool-auto src='https://cdn.jsdelivr.net/npm/disable-devtool@latest'></script>-->

    <style>
        .form_error_message {
            color: red;
        }

        span.error {
            color: #a94442;
            padding: 10px;
        }

        .square {
            height: auto;
            width: auto;
            border: 0.3px solid #727272;
            padding: 10px;
            border-radius: 5px;
        }

        .box-title .caption span {
            /* color: black; */
            /* text-decoration: underline; */
            font-size: 21px;
            padding: 0 0 10px;
            font-family: "Open Sans", sans-serif;
            color: #727272;
            line-height: 24px;
        }

        /* .box-form .form-body {
        padding: 20px !important;
        } */
        body {
            margin: 0;
            padding: 0;
            background: url('./1.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            /* Ensures image stays fixed while scrolling */
            position: relative;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(0deg, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.3));
            mix-blend-mode: multiply;
            /* Blends the overlay with the image */
            pointer-events: none;
            /* Ensures it doesn't block interactions */
            z-index: -1;
            /* Keeps it in the background */
        }


        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 5px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            font-size: 0.9rem;
            height: fit-content;
            padding: 10px;
        }

        .blink-soft {
            animation: blinker 1.5s linear infinite;
            color: #dd7469;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }

        .animated-text {
            /*font-size: 3rem;*/
            font-weight: bold;
            background: linear-gradient(to right, rgb(255, 0, 0), #ffe283, rgb(0, 255, 0));
            background-size: 200% auto;
            /* Ensures the gradient can move smoothly */
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradient-move 5s linear infinite;
        }

        @keyframes gradient-move {
            0% {
                background-position: 0% 50%;
                /* Start position */
            }

            50% {
                background-position: 100% 50%;
                /* Middle position */
            }

            100% {
                background-position: 0% 50%;
                /* Reset to start */
            }
        }
    </style>
    <!-- <script>
        // JavaScript to show the modal on page load
        window.onload = function() {
            const modal = document.getElementById('myModal');
            const closeBtn = document.getElementById('closeBtn');

            // Check if modal has been shown in the past hour
            const lastShown = localStorage.getItem('modalLastShown');
            const oneHour = 60 * 60 * 1000;

            if (!lastShown || Date.now() - parseInt(lastShown, 10) > oneHour) {
                modal.style.display = 'block';
                localStorage.setItem('modalLastShown', Date.now().toString());
            }

            // Close modal when the close button is clicked
            closeBtn.onclick = () => {
                modal.style.display = 'none';
            };

            // Close modal when clicking outside the modal
            window.onclick = (event) => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            };
        };
    </script> -->
</head>

<body id="body">
    <!-- <div id="myModal" class="modal">
        <div class="card border border-white">
            <div class="card-header d-flex justify-content-between">
                <h5 class="mx-auto"><b>Welcome To Youthfest</b></h5>
                <button class="btn btn-dark" id="closeBtn">X</button>
            </div>
            <div class="card-body p-3">
                <img src="./poster-min.jpg" alt="" style="width: 100%;">
            </div>
        </div>
        <div class="text-right bg-white">
            <button class="btn btn-dark" id="closeBtn2">Close</button>
        </div>
    </div> -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 order-md-2 order-xs-3 order-sm-3 mb-3">
                <?php $show = 0;
                if ($show == 1) {
                ?>
                    <form method="post" id="paymentForm" action="./payment.php">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title p-0 m-0 text-center">
                                    <h4 class="m-0 p-0 animated-text">Gyanmanjari Innovative University & Gujarat Sahitya Academy</h4>
                                </div>
                            </div>
                            <div class="card-body bg-light">
                                <div class="form-group">
                                    <label for="category">Category<span style="color: red;"> *</span></label>
                                    <select name="games[]" id="category" class="form-control" required>

                                        <option value=""> --- Select Category --- </option>
                                        <?php
                                        if (is_array($recComp)) {
                                            foreach ($recComp as $comp) {
                                        ?>
                                                <option value="<?= $comp['id'] ?>"> <?= $comp['name'] ?> - [Fees : ₹<?= $comp['fees'] ?>]</option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Name<span style="color: red;"> *</span></label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Your Name" required>
                                </div>
                                <div class="form-group">
                                    <label>Contact Number<span style="color: red;"> *</span></label>
                                    <input type="text" pattern="[6789][0-9]{9}" class="form-control" name="contact" id="contact" placeholder="Enter Contact Number" required>
                                </div>
                                <div class="form-group">
                                    <label>Email Address<span style="color: red;"> *</span></label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email Address" required>
                                </div>
                                <div class="form-group">
                                    <label>Institute Name<span style="color: red;"> *</span></label>
                                    <input type="text" class="form-control" name="clgname" id="clgname" placeholder="Enter College Name" required>
                                </div>
                                <div class="form-group">
                                    <label>Designation</label>
                                    <input type="text" class="form-control" name="deptname" id="deptname" value="" placeholder="" >
                                </div>
                                <div class="form-group">
                                    <label>Research Paper Title (Optional)</label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter Research Paper Title">
                                </div>
                                <hr>
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary">Register</button>
                                </div>
                            </div>
                            <div class="card-body bg-light text-center" hidden>
                                <h4 class="text-warning">Registration Closed!</h4>
                            </div>
                        </div>
                    </form>
                <?php
                } else {
                ?>
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title p-0 m-0 text-center">
                                <h2 class="m-0 p-0 animated-text">Gyanmanjari Innovative University & Gujarat Sahitya Academy</h2>
                            </div>
                            <div class="card-body text-center">
                                <div class="badge badge-warning ">Registration Closed!</div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>

        </div>
    </div>

    <footer class="main-footer text-center" style="    
    background-color: #ffffffb5;
    bottom: 0;
    left: 0;
    width: 100%;
    position:fixed;">
        <strong>Copyright &copy; <?php echo date("Y"); ?> <a href="https://gmiu.edu.in/">Gyanmanjari Innovative University</a>.</strong>
        All rights reserved.
        <br>
        Developed by
        <a _ngcontent-caj-c32="" href="http://ombhatt.42web.io/" target="_blank" style="font-weight: bold; color:#696970;">Om Bhatt</a>
        <!--<div class="float-right d-none d-sm-inline-block">-->
        <!--    <b>Version</b> 1.1.0-->
        <!--</div>-->
    </footer>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Function to get a cookie value by name
            function getCookie(name) {
                let cookies = document.cookie.split('; ');
                for (let i = 0; i < cookies.length; i++) {
                    let cookie = cookies[i].split('=');
                    if (cookie[0] === name) {
                        return cookie[1]; // Return cookie value
                    }
                }
                return null; // Return null if not found
            }

            // Check if 'rid' cookie exists
            if (getCookie("rid")) {
                let rid = getCookie("rid");
                // Ask for user confirmation before redirecting
                let confirmRedirect = confirm("You already have registered. Do you want to see the Receipt?");
                if (confirmRedirect) {
                    window.location.href = "reciept.php?rid=" + rid; // Change to your target page
                }
            }
        });
    </script>

    <script>
        $("#single").select2({
            placeholder: " Select Games",
            allowClear: true
        });
        $("#multiple").select2({
            placeholder: " Select Games",
            allowClear: true
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://ebz-static.s3.ap-south-1.amazonaws.com/easecheckout/easebuzz-checkout.js"></script>

</body>

</html>