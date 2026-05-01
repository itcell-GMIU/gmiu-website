<?php
    include './include/checklogin.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>
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
                            <h1 class="m-0">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard v1</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">IMPORTANT CIRCULAR</h3>




                    <!--     
                        temporary
          -->


                    <div class="form-group" data-select2-id="52">
                        <label>Faculty :</label>
                        <select class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;" data-select2-id="25" tabindex="-1" aria-hidden="true" id="list" name="list" onchange="getSelectValue()">
                            <option selected="selected" data-select2-id="27">select faculty</option>

                            <option data-select2-id="56">Undergradution</option>
                            <option data-select2-id="57">gradution</option>
                            <option data-select2-id="58">postgradution</option>

                        </select>
                    </div>


                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>

                                <th>SUBJECT</th>
                                <th>DATE</th>
                                <th>DESCRPTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php




                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "circular";

                            $conn = new mysqli($servername, $username, $password, $dbname);
                            $sql = "SELECT * FROM `upload_file`";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_array($result)) {
                                    $name = $row["file_name"]; ?>


                                    <tr>
                                        <td>XYZ</td>
                                        <td>11-7-2014</td>
                                        <td><a href="../admin_portal/files/<?php echo $name; ?>" target="_blank"><?php echo $row["file_name"]; ?></a></td>
                                    </tr>


                            <?php
                                }
                            } ?>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>

            <!-- /.content -->
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


    <div class="form-group">
        <label for="exampleInputEmail1">SUBJECT</label>
        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Subject">
    </div>







    <?php include 'include/importjs.php'; ?>
</body>

<script type="text/javascript">
    function getSelectValue() {
        var selectedValue = document.getElementById("list").value;
        console.log(selectedValue);

    }
    var level = getSelectValue();
    document.cookie = "item=" + level;
</script>

</html>