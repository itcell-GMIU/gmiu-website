<?php
include 'include/checklogin.php';
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php include 'include/importhead.php'; ?>
    <?php include 'include/importcss.php'; ?>
</head>
<style>
.badge {
    border-radius: 4px;
}

.tab-pane {
    position: relative;
    padding: 20px;
    border-radius: 9px;
    margin: 25px 0;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.13);
}
</style>

<body>
    <!-- Preloader -->
    <!-- <div id="preloader">
    <div id="status">&nbsp;</div>
</div> -->
    <?php include 'include/importheader.php'; ?>

    <!-- Start Welcome Area section -->
    <section class="Welcome-area">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 Welcome-area-text">
                    <div class="row">
                        <div class="col-sm-12 section-header-box">
                            <div class="section-header section-header-l">
                                <h2>Application Status</h2>
                            </div><!-- ends: .section-header -->
                        </div>
                    </div>
                    <div class="tab-pane">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td colspan="2" class="dp"><b>Please Note this GR Number for further process.</b>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="center"><b>GR Number</b></td>
                                    <td>
                                        <?php echo $gr_number; ?>
                                    </td>
                                    <!-- <td>@mdo</td> -->
                                </tr>
                                <tr>

                                    <td class="center"><b>Faculty</b></td>
                                    <td>
                                        <?php echo $stu_faculty_name; ?>
                                    </td>
                                    <!-- <td>@mdo</td> -->
                                </tr>
                                <tr>
                                    <td class="center"><b>Level</b></td>
                                    <td>
                                        <?php echo $stu_level_name; ?>
                                    </td>
                                    <!-- <td>@mdo</td> -->
                                </tr>
                                <tr>

                                    <td class="center"><b>Program</b></td>
                                    <td>
                                        <?php echo $stu_program_name; ?>
                                    </td>
                                    <!-- <td>@mdo</td> -->
                                </tr>
                                <tr>

                                    <td class="center"><b>Payment Status</b></td>
                                    <td><span style="background-color:green" class="badge badge-success">
                                            <?php echo $payment_status; ?>
                                        </span>
                                    </td>
                                    <!-- <td>@mdo</td> -->
                                </tr>
                             
                                  <tr>
                                      <th scope="row">Payment Receipt</th>
                                        <td class="center">
                                            <?php 
                                            if (strtolower($payment_status) === 'success') {
                                                echo '<a href="receipt.php" target="_blank">View Receipt</a>';
                                            } else {
                                                echo 'Receipt not generated, please contact account section. accounts@gmiu.edu.in';
                                            }
                                            ?>
                                        </td>
                                    </tr>

                                <tr>

                                    <td class="center"><b>Application Status</b></td>
                                    <td>
                                        <?php if ($stu_cluster_status == "submitted") {
                                        echo '<span style="background-color:#17a2b8" class="badge badge-success">Submitted</span>';
                                        } elseif ($stu_cluster_status == "approved") {
                                        if($stu_admission_status == "approved")
                                        {
                                            echo '<span style="background-color:#28a745" class="badge badge-success">Approved</span>';

                                        }
                                        else
                                        {
                                            echo '<span style="background-color:#17a2b8" class="badge badge-success">Submitted</span>';
                                        }
                                        
                                    } elseif ($stu_admission_status == "rejected" || $stu_cluster_status == "rejected") {
                                        echo '<span style="background-color:#dc3545" class="badge badge-success">Rejected</span>';
                                    } else {
                                        echo '<span style="background-color:yellow;color:black;" class="badge badge-success">Pending</span>';
                                    }
                                    ?>
                                    <td>
                                        <!-- <td>@mdo</td> -->
                                </tr>
                                <?php
                                if ($stu_cluster_status == "rejected" ) {
                                   
                                    ?>
                                <tr>
                                    <td class="center"><b>Comment By Cluster</b></td>
                                    <td>
                                        <?php echo $comment; ?>
                                    </td>
                                    <!-- <td>@mdo</td> -->
                                </tr>
                                <tr>
                                    <td class="center"><b>Edit Application</b></td>
                                    <td><a href="dashboard.php">Edit and Resubmit</td>
                                    <!-- <td>@mdo</td> -->
                                </tr>
                                <?php } else { ?>
                                <tr>
                                    <td class="center"><b>View Application</b></td>
                                    <td><a href="view_application.php">View</td>
                                    <!-- <td>@mdo</td> -->
                                </tr>
                                <?php }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div><!-- Ends: . -->
            </div>
        </div>
    </section><!-- Ends: . -->
    <!-- ./ End Welcome Area section -->
    <!-- ./ End Instraction Area section -->

    <!-- Footer Area section -->
    <?php include 'include/importfooter.php'; ?>
    <!-- ./ End Footer Area-->

    <!-- ============================
    JavaScript Files
    ============================= -->
    <?php include 'include/importjs.php'; ?>
</body>

</html>