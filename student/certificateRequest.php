<?php
include './include/checklogin.php';

if (isset($_POST['submit'])) {
    @$certificate_id = mysqli_real_escape_string($con, $_POST['certificate_id']);
    $status = "Requested";
    $dateTime = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
    $datetime = $dateTime->format("y/m/d");
    
    $stmt = $con->prepare("INSERT INTO `tbl_certificate_request` (`certificate_id`, `status`, `student_id`, `date`) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isis", $certificate_id, $status, $student_id, $datetime);
    $result = $stmt->execute();
    

    if ($result) {
        $_SESSION['status'] = "Certificate Requested Inserted Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='certificateTrack.php'},1000);</script>";
    } else {
        // delete entry if get any update in upload
        $_SESSION['status'] = "Certificate Requested Insertion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='certificateRequest.php'},1000)</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>
    <style>
        
       

        .student-info {
            border: 1px solid #ccc;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
        }


        .profile-pic {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-pic img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 2px solid #ccc;
        }

        .details p {
            margin: 5px 0;
        }

        .details strong {
            font-weight: bold;
        }

        /* The existing styles remain the same */

        /* Additional CSS for the table form layout */
        /* The existing styles remain the same */

        /* Additional CSS for the table form layout */
        /* The existing styles remain the same */

/* Additional CSS for the table form layout */
table {
  width: 100%;
  border-collapse: collapse;
}

td {
  padding: 5px;
}

.profile1-pic {
  text-align: left;
  margin-top: 20px;
}

.profile1-pic img {
 
  height: 200px;
  
  object-fit: cover; 
}

    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">



        <!-- Navbar -->
        <?php include 'include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include 'include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">

                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>




                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>


            <!-- /.content-header -->

            <!-- /.card-header -->

            <section class="content">
                <div class="container-fluid">
                    <!-- Default box -->
                    <div class="card mb-3">
                        <div class="card-header">

                            <i class="far fa-hand-pointer" aria-hidden="true"></i>

                            <span> <b>Select Faculty to View Students</b></span>

                        </div>
                        <form method="POST" action="">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">


                                        <div class="col-md-8">
                                            <div class="form-label-group">
                                                <div class="input-group mb-3">

                                                    <select name="certificate_id" id="certificate_id" class="browser-default custom-select" style="color:black; border-color:#325d88; border-width:2px" required>
                                                        <option value="">---Select Certificate---</option>

                                                        <?php
                                                        $query = "SELECT * FROM tbl_certificate WHERE is_active = 1 and is_delete=0";
                                                        $result = $con->query($query);
                                                        if ($result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
                                                                echo '<option value=' . $row['id'] . '>' . $row['certificate_name'] . '</option>';
                                                                $certificate_id = $row['id'];
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <hidden name="certificate_id" value=<?php echo $certificate_id; ?>>

                                                    <div class="dive" name="div1" id="div1" style="display:none;">
                                                        
                                                            <div class="student-info">
                                                                
                                                                    <table>
                                                                        <tr>
                                                                            <td><strong>Name:</strong></td>
                                                                            <td><?php echo $name; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><strong>Enrollment Number:</strong></td>
                                                                            <td><?php echo $gr_no ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><strong>Level:</strong></td>
                                                                            <td><?php echo $level_name ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><strong>Program:</strong></td>
                                                                            <td><?php echo $program_name ?></td>
                                                                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td><strong>Faculty:</strong></td>
                                                                            <td><?php echo $faculty_name ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><strong>Semester:</strong></td>
                                                                            <td><?php echo $sem ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                        <td><strong>Photo:</strong></td>
                                                                            <td colspan="2" class="profile1-pic">
                                                                                <img src="../admission/uploads/<?php echo $student_id ?>/<?php echo $photo ?>" alt="Student Photo" id="studentPhoto">
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                    <label for="confirmCheckbox">
                                                                        <input type="checkbox" id="confirmCheckbox" required> I confirm that the student details are correct<span style="color: red;">*</span>
                                                                    </label>
                                                                   
                                                            </div>
                                                           
                                                    </div>

                                                    <div class="card-footer">
                                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
        </div>
        <!-- /.content-wrapper -->
        <?php include 'include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php include 'include/importjs.php'; ?>
</body>

</html>
<script>
    $(document).ready(function() {
        $('select[name="certificate_id"]').on('change', function() {
            // Get the selected value
            var selectedValue = $(this).val();

            // Hide all divs with class "dive"
            $('.dive').hide();

            // Show the div corresponding to the selected value
            switch (selectedValue) {
                case '1':
                    $('.dive#div1').show();
                    break;
                case '2':
                    $('.dive#div2').show();
                    break;
                case '3':
                    $('.dive#div3').show();
                    break;
            }
        });
    });
</script>
>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>