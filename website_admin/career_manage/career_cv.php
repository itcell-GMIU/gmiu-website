<?php
// Include the checklogin.php file
include '../include/checklogin.php';
include '../include/dbconfig.php';

date_default_timezone_set("Asia/Kolkata");
$query = "
    SELECT a.*, r.name AS role_name ,
      d.name AS designation
    FROM tbl_career_applications a 
    LEFT JOIN tbl_career_role r ON a.role = r.id 
    LEFT JOIN 
    tbl_designation d ON a.designation = d.id
    WHERE a.is_active = '1' 
    ORDER BY a.id DESC
";
$result = $con->query($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <title>Career Applications</title>
 
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include '../include/importnav.php'; ?>
        <?php include '../include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Career Applications</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Career Applications</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Career Applications</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="dataTableLoad table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>CV File</th>
                                            <th>Mobile</th>
                                            <th>Alt Mobile</th>
                                            <th>DOB</th>
                                            <th>Gender</th>
                                            <th>Role</th>
                                            <th>Designation</th>
                                            <th>Address</th>
                                            <th>Pin</th>
                                            <th>Degree</th>
                                            <th>University</th>
                                            <th>CGPA</th>
                                            <th>Passing Year</th>
                                            <th>Academic Exp</th>
                                            <th>Industry Exp</th>
                                            <th>Research Exp</th>
                                            <th>Total Exp</th>
                                            <th>Other</th>
                                            <th>Join Availability</th>
                                          
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['full_name']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td>
                                                    <a href="https://gmiu.edu.in/gmiu/website_admin/uploads/career/cv/<?php echo $row['cv_file']; ?>" target="_blank">Download</a>
                                                </td>
                                                <td><?php echo $row['mobile']; ?></td>
                                                <td><?php echo $row['alt_mobile']; ?></td>
                                                <td><?php echo $row['dob']; ?></td>
                                                <td><?php echo $row['gender']; ?></td>
                                                <td><?php echo $row['role_name']; ?></td>
                                                <td><?php echo $row['designation']; ?></td>
                                                <td><?php echo $row['address']; ?></td>
                                                <td><?php echo $row['pin']; ?></td>
                                                <td><?php echo $row['degree']; ?></td>
                                                <td><?php echo $row['university']; ?></td>
                                                <td><?php echo $row['cgpa']; ?></td>
                                                <td><?php echo $row['passing_year']; ?></td>
                                                <td><?php echo $row['academic_exp']; ?></td>
                                                <td><?php echo $row['industry_exp']; ?></td>
                                                <td><?php echo $row['research_exp']; ?></td>
                                                <td><?php echo $row['total_exp']; ?></td>
                                                <td><?php echo $row['other']; ?></td>
                                                <td><?php echo $row['join_availability']; ?></td>
                                               

                                                <td>
                                                    <!--<a href="edit.php?id=<?php //echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>-->
                                                    <!--<a href="delete.php?id=<?php //echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>-->
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>CV File</th>
                                            <th>Mobile</th>
                                            <th>Alt Mobile</th>
                                            <th>DOB</th>
                                            <th>Gender</th>
                                            <th>Role</th>
                                            <th>Address</th>
                                            <th>Pin</th>
                                            <th>Degree</th>
                                            <th>Designation</th>
                                            <th>University</th>
                                            <th>CGPA</th>
                                            <th>Passing Year</th>
                                            <th>Academic Exp</th>
                                            <th>Industry Exp</th>
                                            <th>Research Exp</th>
                                            <th>Total Exp</th>
                                            <th>Other</th>
                                            <th>Join Availability</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <?php include '../include/importfooter.php'; ?>
    <?php include '../include/importjs.php'; ?>
</body>
</html>
