<?php
// Include the checklogin.php file
include 'include/checklogin.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {

    $student_id = mysqli_real_escape_string($con, $_GET['id']);
    $student_id = only_digits($student_id);
    if ($student_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='view_student.php'},1000)</script>";
    }

    $cmd2 = "SELECT `faculty_id`, `level_id`,`first_name`,`middle_name`,`last_name`,`gr_number` FROM tbl_admission_student WHERE id = ? ";
    $stmt2 = $con->prepare($cmd2);
    $stmt2->bind_param("i", $_GET['id']);
    $stmt2->execute();
    $result2 = $stmt2->get_result(); // get the mysqli result
    if ($result2->num_rows == 1) {
        $row2 = $result2->fetch_assoc();
        $stu_faculty_id = $row2['faculty_id'];
        $stu_level_id = $row2['level_id'];
        $stu_first_name = $row2['first_name'];
        $stu_middle_name = $row2['middle_name'];
        $stu_last_name = $row2['last_name'];
        $stu_gr_no = $row2['gr_number'];
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Header  -->
    <?php include 'include/importhead.php'; ?>`

    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>
</head>



<body class="hold-transition sidebar-mini layout-fixed">

    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div> <!-- /.Preloader -->

    <!-- wrapper -->
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
                <!-- Container-fluid -->
                <div class="container-fluid">
                    <!-- row -->
                    <div class="row mb-2">
                        <!-- col -->
                        <div class="col-sm-8">
                            <h4 class="m-0">Student : <?php echo $stu_first_name.' '.$stu_middle_name.' '.$stu_last_name.'('.$stu_gr_no.')'?></h4>
                        </div><!-- /.col -->
                        <div class="col-sm-4">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Document</li>
                            </ol>
                        </div> <!-- /.col -->
                    </div> <!-- /.row -->
                </div> <!-- /.container-fluid -->
            </div> <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <!-- container-fluid -->
                <div class="container-fluid">
                    <!-- row -->
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- card -->
                            <div class="card card-gmiu">
                                <!-- card header -->
                                <div class="card-header">
                                    <h3 class="card-title">Edit Document</h3>
                                </div> <!-- /.card-header -->

                                <table class="table table-bordered">
                                    <tr>
                                        <td class="center"><b><span>Instructions For Uploading Document </span></b><br></td>
                                    </tr>
                                    <tr>
                                        <td><span style="color: red">Allowed file type :- pdf , jpeg , jpg , png</span><br>
                                            <span style="color: red">Maximum Allowed File Size :- 5 MB </span>
                                        </td>
                                    </tr>
                                </table>
                                <hr>
                                <!-- <form id="form" action="ajaxupload.php" method="POST" enctype="multipart/form-data"> -->

                                <table class="table table-bordered">

                                    <form id="form" action="ajaxupload.php" method="POST" enctype="multipart/form-data">
                                        <!-- <table class="table table-bordered"><tr>  -->
                                        <tr>

                                            <td class="center">
                                                <span style="color: red">*</span>
                                                <b><span>Passport Size Photo</span></b></b>
                                            </td>
                                            <td><input id="uploadImage1" type="file" name="image" class="up_a" required /></td>
                                            <td style="padding-left: 10px;"> <input class="btn up_b " id="btn1" type="submit" value="Upload" name="myButton"><input style="display:none;" type="button" data-col_name="photo" class="btn up_b remove_document" id="rm1" value="Remove">
                                            </td>
                                            <td class="view_photo" style="display:none;"><a target="_blank" id="view_photo" download><i class="fa fa-download" aria-hidden="true"></a></td>

                                            <!-- </tr></table> -->
                                        </tr>
                                        <input type="hidden" id="hidden1" name="fileno" value="Photo">
                                        <input type="hidden" id="student_id" name="student_id" value="<?php echo $student_id;?> ">
                               
                                    </form>

                                    <form id="form2" action="ajaxupload.php" method="POST" enctype="multipart/form-data">
                                        <!-- <table class="table table-bordered"><tr>  -->

                                        <tr>
                                            <td class="center"><b>
                                                    <span style="color: red">*</span>
                                                    <b><span>Aadhar card</span></b></b></td>
                                            <td><input id="uploadImage2" type="file" name="image" class="up_a" required /></td>
                                            <td style="padding-left: 10px;"> <input class="btn up_b  " id="btn2" type="submit" value="Upload" name="myButton"><input style="display:none;" type="button" data-col_name="aadharcard" class="btn up_b remove_document" id="rm2" value="Remove" /></td>
                                            <td class="view_aadharcard" style="display:none;"><a target="_blank" id="view_aadharcard" download><i class="fa fa-download" aria-hidden="true"></a target="_blank"></td>
                                            <!-- </tr></table> -->
                                        </tr>
                                        <input type="hidden" id="hidden2" name="fileno" value="Aadhar_card" required>
                                        <input type="hidden" id="student_id" name="student_id" value="<?php echo $student_id;?> ">
                                    </form>

                                    <form id="form3" action="ajaxupload.php" method="POST" enctype="multipart/form-data">
                                        <!-- <table class="table table-bordered"><tr>  -->

                                        <tr>
                                            <td class="center"><b>
                                                    <span style="color: red">*</span>
                                                    <b><span>Parent Aadhar card</span></b></b></td>
                                            <td><input id="uploadImage3" type="file" name="image" class="up_a" required /></td>
                                            <td style="padding-left: 10px;"> <input class="btn up_b  " id="btn3" type="submit" value="Upload" name="myButton"><input style="display:none;" type="button" data-col_name="parent_aadharcard" class="btn up_b remove_document" id="rm3" value="Remove" /></td>
                                            <td class="view_parent_aadharcard" style="display:none;"><a target="_blank" id="view_parent_aadharcard" download><i class="fa fa-download" aria-hidden="true"></a target="_blank"></td>
                                            <!-- </tr></table> -->
                                        </tr>
                                        <input type="hidden" id="hidden3" name="fileno" value="Parent_Aadhar_card" required>
                                        <input type="hidden" id="student_id" name="student_id" value="<?php echo $student_id;?> ">
                                    </form>

                                    <form id="form4" action="ajaxupload.php" method="POST" enctype="multipart/form-data">
                                        <!-- <table class="table table-bordered"><tr>  -->
                                        <tr>
                                            <td class="center"><b>

                                                    <b><span>School Leaving Certificate</span></b></b></td>
                                            <td><input id="uploadImage4" type="file" name="image" class="up_a" required /></td>
                                            <td style="padding-left: 10px;"> <input class="btn up_b " id="btn4" type="submit" value="Upload" name="myButton"><input style="display:none;" type="button" data-col_name="school_leaving" class="btn up_b remove_document " id="rm4" value="Remove"></td>
                                            <td class="view_school_leaving" style="display:none;"><a target="_blank" id="view_school_leaving" download><i class="fa fa-download" aria-hidden="true"></a></td>

                                            <!-- </tr></table> -->
                                        </tr>
                                        <input type="hidden" id="hidden4" name="fileno" value="school_leaving_certificate">
                                        <input type="hidden" id="student_id" name="student_id" value="<?php echo $student_id;?> ">
                                    </form>

                                    <form id="form5" action="ajaxupload.php" method="POST" enctype="multipart/form-data">
                                        <!-- <table class="table table-bordered"><tr>  -->
                                        <tr>
                                            <td class="center"><b>

                                                    <b><span>SSC Marksheet</span></b></b></td>
                                            <td><input id="uploadImage5" type="file" name="image" class="up_a" required /></td>
                                            <td style="padding-left: 10px;"> <input class="btn up_b " id="btn5" type="submit" value="Upload" name="myButton"><input style="display:none;" type="button" data-col_name="ssc_marksheet" class="btn up_b remove_document " id="rm5" value="Remove"></td>
                                            <td class="view_ssc_marksheet" style="display:none;"><a target="_blank" id="view_ssc_marksheet" download><i class="fa fa-download" aria-hidden="true"></a></td>

                                            <!-- </tr></table> -->
                                        </tr>
                                        <input type="hidden" id="hidden5" name="fileno" value="SSC_Marksheet">
                                        <input type="hidden" id="student_id" name="student_id" value="<?php echo $student_id;?> ">
                                    </form>

                                    <form id="form6" action="ajaxupload.php" method="POST" enctype="multipart/form-data">
                                        <!-- <table class="table table-bordered"><tr>  -->
                                        <tr>
                                            <td class="center"><b>

                                                    <b><span>HSC Marksheet</span></b></b></td>
                                            <td><input id="uploadImage6" type="file" name="image" class="up_a" required /></td>
                                            <td style="padding-left: 10px;"> <input class="btn up_b " id="btn6" type="submit" value="Upload" name="myButton"><input style="display:none;" type="button" data-col_name="hsc_marksheet" class="btn up_b remove_document" id="rm6" value="Remove"></td>
                                            <td class="view_hsc_marksheet" style="display:none;"><a target="_blank" id="view_hsc_marksheet" download><i class="fa fa-download" aria-hidden="true"></a></td>

                                            <!-- </tr></table> -->
                                        </tr>
                                        <input type="hidden" id="hidden6" name="fileno" value="HSC_Marksheet">
                                        <input type="hidden" id="student_id" name="student_id" value="<?php echo $student_id;?> ">
                                    </form>
                                    <?php if ($stu_level_id == 2 || $stu_level_id == 4) {
                                    ?>
                                        <form id="form7" action="ajaxupload.php" method="POST" enctype="multipart/form-data">
                                            <!-- <table class="table table-bordered"><tr>  -->
                                            <tr>
                                                <td class="center"><b>

                                                        <b><span>Graduation Marksheets & Degree Certificate</span></b></b></td>
                                                <td><input id="uploadImage7" type="file" name="image" class="up_a" required /></td>
                                                <td style="padding-left: 10px;"> <input class="btn up_b " id="btn7" type="submit" value="Upload" name="myButton"><input style="display:none;" type="button" data-col_name="graduation_marksheet" class="btn up_b remove_document" id="rm7" value="Remove"></td>
                                                <td class="view_graduation_marksheet" style="display:none;"><a target="_blank" id="view_graduation_marksheet" download><i class="fa fa-download" aria-hidden="true"></a></td>

                                                <!-- </tr></table> -->
                                            </tr>
                                            <input type="hidden" id="hidden7" name="fileno" value="Graduation_Marksheet">
                                            <input type="hidden" id="student_id" name="student_id" value="<?php echo $student_id;?> ">
                                        </form>
                                    <?php
                                    }
                                    if ($stu_faculty_id == 1 || $stu_faculty_id == 15) {
                                    ?>

                                        <form id="form8" action="ajaxupload.php" method="POST" enctype="multipart/form-data">
                                            <!-- <table class="table table-bordered"><tr>  -->
                                            <tr>
                                                <td class="center"><b>

                                                        <b><span>Gujcet Result</span></b></b></td>
                                                <td><input id="uploadImage8" type="file" name="image" class="up_a" required /></td>
                                                <td style="padding-left: 10px;"> <input class="btn up_b " id="btn8" type="submit" value="Upload" name="myButton"><input style="display:none;" type="button" data-col_name="gujcet_result" class="btn up_b remove_document" id="rm8" value="Remove"></td>
                                                <td class="view_gujcet_result" style="display:none;"><a target="_blank" id="view_gujcet_result" download><i class="fa fa-download" aria-hidden="true"></a target="_blank"></td>

                                                <!-- </tr></table> -->
                                            </tr>
                                            <input type="hidden" id="hidden8" name="fileno" value="Gujcet_Result">
                                            <input type="hidden" id="student_id" name="student_id" value="<?php echo $student_id;?> ">
                                        </form>

                                        <form id="form9" action="ajaxupload.php" method="POST" enctype="multipart/form-data">
                                            <!-- <table class="table table-bordered"><tr>  -->
                                            <tr>
                                                <td class="center"><b>

                                                        <b><span>JEE Result</span></b></b></td>
                                                <td><input id="uploadImage9" type="file" name="image" class="up_a" required /></td>
                                                <td style="padding-left: 10px;"> <input class="btn up_b " id="btn9" type="submit" value="Upload" name="myButton"><input style="display:none;" type="button" data-col_name="jee_result" class="btn up_b remove_document " id="rm9" value="Remove"></td>
                                                <td class="view_jee_result" style="display:none;"><a target="_blank" id="view_jee_result" download><i class="fa fa-download" aria-hidden="true"></a></td>

                                                <!-- </tr></table> -->
                                            </tr>
                                            <input type="hidden" id="hidden9" name="fileno" value="JEE_Result" required>
                                            <input type="hidden" id="student_id" name="student_id" value="<?php echo $student_id;?> ">
                                        </form>

                                        <form id="form10" action="ajaxupload.php" method="POST" enctype="multipart/form-data">
                                            <!-- <table class="table table-bordered"><tr>  -->
                                            <tr>
                                                <td class="center"><b>

                                                        <b><span>NEET Result</span></b></b></td>
                                                <td><input id="uploadImage10" type="file" name="image" class="up_a" required /></td>
                                                <td style="padding-left: 10px;"> <input class="btn up_b " id="btn10" type="submit" value="Upload" name="myButton"><input style="display:none;" type="button" data-col_name="neet_result" class="btn up_b remove_document" id="rm10" value="Remove"></td>
                                                <td class="view_neet_result" style="display:none;"><a target="_blank" id="view_neet_result" download><i class="fa fa-download" aria-hidden="true"></a></td>

                                                <!-- </tr></table> -->
                                            </tr>
                                            <input type="hidden" id="hidden10" name="fileno" value="NEET_Result" required>
                                            <input type="hidden" id="student_id" name="student_id" value="<?php echo $student_id;?> ">
                                        </form>
                                    <?php
                                    }
                                    ?>
                                    <form id="form11" action="ajaxupload.php" method="POST" enctype="multipart/form-data">
                                        <!-- <table class="table table-bordered"><tr>  -->
                                        <tr>
                                            <td class="center"><b>
                                                    <b><span>Migration Certificate</span></b></b></td>
                                            <td><input id="uploadImage11" type="file" name="image" class="up_a" /></td>
                                            <td style="padding-left: 10px;"> <input class="btn up_b " id="btn11" type="submit" value="Upload" name="myButton"><input style="display:none;" type="button" data-col_name="migration_certificate" class="btn up_b remove_document" id="rm11" value="Remove"></td>
                                            <td class="view_migration_certificate" style="display:none;"><a target="_blank" id="view_migration_certificate" download><i class="fa fa-download" aria-hidden="true"></a></td>

                                            <!-- </tr></table> -->
                                        </tr>
                                        <input type="hidden" id="hidden11" name="fileno" value="Migration_Certificate">
                                        <input type="hidden" id="student_id" name="student_id" value="<?php echo $student_id;?> ">
                                    </form>

                                    <form id="form12" action="ajaxupload.php" method="POST" enctype="multipart/form-data">
                                        <!-- <table class="table table-bordered"><tr>  -->
                                        <tr>
                                            <td class="center"><b>
                                                    <b><span>Caste Certificate</span></b></b></td>
                                            <td><input id="uploadImage12" type="file" name="image" class="up_a" /></td>
                                            <td style="padding-left: 10px;"> <input class="btn up_b " id="btn12" type="submit" value="Upload" name="myButton"><input style="display:none;" type="button" data-col_name="caste_certificate" class="btn up_b remove_document" id="rm12" value="Remove"></td>
                                            <td class="view_caste_certificate" style="display:none;"><a target="_blank" id="view_caste_certificate" download><i class="fa fa-download" aria-hidden="true"></a></td>

                                            <!-- </tr></table> -->
                                        </tr>
                                        <input type="hidden" id="hidden12" name="fileno" value="Cast_Certificate">
                                        <input type="hidden" id="student_id" name="student_id" value="<?php echo $student_id;?> ">
                                    </form>

                                    <form id="form13" action="ajaxupload.php" method="POST" enctype="multipart/form-data">
                                        <!-- <table class="table table-bordered"><tr>  -->
                                        <tr>
                                            <td class="center"><b>
                                                    <b><span>Other Documents</span></b></b></td>
                                            <td><input id="uploadImage13" type="file" name="image" class="up_a" /></td>
                                            <td style="padding-left: 10px;"> <input class="btn up_b " id="btn13" type="submit" value="Upload" name="myButton"><input style="display:none;" type="button" data-col_name="other_documents" class="btn up_b remove_document" id="rm13" value="Remove"></td>
                                            <td class="view_other_documents" style="display:none;"><a target="_blank" id="view_other_documents" download><i class="fa fa-download" aria-hidden="true"></a target="_blank"></td>

                                            <!-- </tr></table> -->
                                        </tr>
                                        <input type="hidden" id="hidden13" name="fileno" value="Other_Documents">
                                        <input type="hidden" id="student_id" name="student_id" value="<?php echo $student_id;?> ">
                                    </form>

                                </table>
                            </div> <!-- /.card -->
                        </div> <!--/.left column -->
                    </div> <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section> <!-- /.content -->
        </div> <!-- /.content-wrapper -->

        <!-- footer -->
        <?php include 'include/importfooter.php'; ?>
        <!-- /.footer -->

    </div> <!-- ./wrapper -->

    <!-- Import JavaScript -->
    <?php include 'include/importjs.php'; ?>

<!---upload docuemnt-->
<script>
    $(document).ready(function() {

load_education_document();

});
/*  load all document ajax  call */
function load_education_document(col_name, dl) {
    var path = '<?php echo "$base_url_student_section"; ?>';
    var student_id = <?php echo $student_id; ?>;
    var upload_document_url = "<?php echo $upload_document_url; ?>";
    $.ajax({
        type: "POST",
        url: path + "ajaxgetdocument.php",
        data: {
            student_id: student_id,
        },
        dataType: 'json',
        cache: false,
        success: function(data) {
            if (data.status == 200) {
                var photo = data.data.photo;
                var aadharcard = data.data.aadharcard;
                var parent_aadharcard = data.data.parent_aadharcard;
                var school_leaving = data.data.school_leaving;
                var ssc_marksheet = data.data.ssc_marksheet;
                var hsc_marksheet = data.data.hsc_marksheet;
                var caste_certificate = data.data.caste_certificate;
                var gujcet_result = data.data.gujcet_result;
                var jee_result = data.data.jee_result;
                var neet_result = data.data.neet_result;
                var graduation_marksheet = data.data.graduation_marksheet;
                var migration_certificate = data.data.migration_certificate;
                var other_documents = data.data.other_documents;

                if (photo != null && photo != "") {
                    $(".view_photo").show();
                    $("#rm1").show();
                    $("#btn1").hide();

                    $("#view_photo").attr("href", upload_document_url + student_id + "/" + photo);
                } else {
                    $(".view_photo").hide();
                    $("#rm1").hide();
                    $("#btn1").show();
                }

                if (aadharcard != null && aadharcard != "") {

                    $(".view_aadharcard").show();
                    $("#rm2").show();
                    $("#btn2").hide();

                    $("#view_aadharcard").attr("href", upload_document_url + student_id + "/" + aadharcard);
                } else {
                    $(".view_aadharcard").hide();
                    $("#rm2").hide();
                    $("#btn2").show();
                }

                if (parent_aadharcard != null && parent_aadharcard != "") {

                    $(".view_parent_aadharcard").show();
                    $("#rm3").show();
                    $("#btn3").hide();

                    $("#view_parent_aadharcard").attr("href", upload_document_url + student_id + "/" +
                        parent_aadharcard);
                } else {
                    $(".view_parent_aadharcard").hide();
                    $("#rm3").hide();
                    $("#btn3").show();
                }

                if (school_leaving != null && school_leaving != "") {

                    $(".view_school_leaving").show();
                    $("#rm4").show();
                    $("#btn4").hide();

                    $("#view_school_leaving").attr("href", upload_document_url + student_id + "/" +
                        school_leaving);
                } else {
                    $(".view_school_leaving").hide();
                    $("#rm4").hide();
                    $("#btn4").show();
                }

                if (ssc_marksheet != null && ssc_marksheet != "") {

                    $(".view_ssc_marksheet").show();
                    $("#rm5").show();
                    $("#btn5").hide();

                    $("#view_ssc_marksheet").attr("href", upload_document_url + student_id + "/" +
                        ssc_marksheet);
                } else {
                    $(".view_ssc_marksheet").hide();
                    $("#rm5").hide();
                    $("#btn5").show();
                }

                if (hsc_marksheet != null && hsc_marksheet != "") {

                    $(".view_hsc_marksheet").show();
                    $("#rm6").show();
                    $("#btn6").hide();

                    $("#view_hsc_marksheet").attr("href", upload_document_url + student_id + "/" +
                        hsc_marksheet);
                } else {
                    $(".view_hsc_marksheet").hide();
                    $("#rm6").hide();
                    $("#btn6").show();

                }
                if (graduation_marksheet != null && graduation_marksheet != "") {

                    $(".view_graduation_marksheet").show();
                    $("#rm7").show();
                    $("#btn7").hide();

                    $("#view_graduation_marksheet").attr("href", upload_document_url + student_id + "/" +
                        graduation_marksheet);
                } else {
                    $(".view_graduation_marksheet").hide();
                    $("#rm7").hide();
                    $("#btn7").show();
                }

                if (gujcet_result != null && gujcet_result != "") {

                    $(".view_gujcet_result").show();
                    $("#rm8").show();
                    $("#btn8").hide();

                    $("#view_gujcet_result").attr("href", upload_document_url + student_id + "/" +
                        gujcet_result);
                } else {
                    $(".view_gujcet_result").hide();
                    $("#rm8").hide();
                    $("#btn8").show();
                }
                if (jee_result != null && jee_result != "") {

                    $(".view_jee_result").show();
                    $("#rm9").show();
                    $("#btn9").hide();

                    $("#view_jee_result").attr("href", upload_document_url + student_id + "/" +
                        jee_result);
                } else {
                    $(".view_jee_result").hide();
                    $("#rm9").hide();
                    $("#btn9").show();
                }
                if (neet_result != null && neet_result != "") {

                    $(".view_neet_result").show();
                    $("#rm10").show();
                    $("#btn10").hide();

                    $("#view_neet_result").attr("href", upload_document_url + student_id + "/" +
                        neet_result);
                } else {

                    $(".view_neet_result").hide();
                    $("#rm10").hide();
                    $("#btn10").show();
                }

                if (migration_certificate != null && migration_certificate != "") {

                    $(".view_migration_certificate").show();
                    $("#rm11").show();
                    $("#btn11").hide();

                    $("#view_migration_certificate").attr("href", upload_document_url + student_id + "/" +
                        migration_certificate);
                } else {
                    $(".view_migration_certificate").hide();
                    $("#rm11").hide();
                    $("#btn11").show();
                }

                if (caste_certificate != null && caste_certificate != "") {

                    $(".view_caste_certificate").show();
                    $("#rm12").show();
                    $("#btn12").hide();

                    $("#view_caste_certificate").attr("href", upload_document_url + student_id + "/" +
                        caste_certificate);
                } else {
                    $(".view_caste_certificate").hide();
                    $("#rm12").hide();
                    $("#btn12").show();
                }
                if (other_documents != null && other_documents != "") {

                    $(".view_other_documents").show();
                    $("#rm13").show();
                    $("#btn13").hide();

                    $("#view_other_documents").attr("href", upload_document_url + student_id + "/" +
                        other_documents);
                } else {
                    $(".view_other_documents").hide();
                    $("#rm13").hide();
                    $("#btn13").show();
                }
            }
        },
        error: function(e) {
            $("#err").html(e).fadeIn();
            Swal.fire('Invalid', 'error');
        }

    });

}
</script>
<script>
/* Remove Document Ajax Call */
$(".remove_document").on('click', function(event) {
    var col_name = $(this).data("col_name");
    var path = '<?php echo "$base_url_student_section"; ?>';
    var student_id = <?php echo $student_id; ?>;
    $.ajax({
        type: "POST",
        url: path + 'ajaxremovedocument.php',
        dataType: 'json',
        data: {
            student_id: student_id,
            col_name:col_name
        },
        cache: false,
        success: function(data) {
            //  alert(data.status);
            if (data.status == 200) {
                Swal.fire('Removed Successfully');
                load_education_document();
            } else {
                Swal.fire('Something Went Wrong', 'error');
            }

        }
    });

    //(... rest of your JS code)
});
</script>
<script>
/* upload document ajax function */
function rmAndDl(form, rm, dl, btn, name_file, file_name) {


    $(document).ready(function(e) {

        $(form).on('submit', (function(e) {
            var path = '<?php echo "$base_url_student_section"; ?>';
            e.preventDefault();
            $.ajax({
                url: path + "ajaxupload.php",
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $("#err").fadeOut();
                },
                success: function(data) {
                    if (data.status == 200) {

                        load_education_document();

                        $("#preview").html(data).fadeIn();
                        $(form)[0].reset();
                        Swal.fire(name_file + ' Updated Successfully!',
                            'File Uploaded Successfully');
                        //}
                    } else if (data.status == 400) {
                        Swal.fire('Invalid File Size!',
                            'Please look at the above mentioned Instructions for File upload '
                        );
                    } else if (data.status == 300) {
                        Swal.fire('Something Went Wrong!',
                            'Please look at the above mentioned Instructions for File upload'
                        );
                    } else if (data.status == 500) {
                        Swal.fire('Invalid File  Format !',
                            'Please look at the above mentioned Instructions for File upload'
                        );
                    }


                },

            });
        }));
    });

}

rmAndDl("#form", "#rm1", "#dl1", "#btn1", "Photo", "photo");
rmAndDl("#form2", "#rm2", "#dl2", "#btn2", "Aadhar Card", "aadharcard");
rmAndDl("#form3", "#rm3", "#dl3", "#btn3", "Parent Aadhar Card", "parent_aadharcard");
rmAndDl("#form4", "#rm4", "#dl4", "#btn4", "School Leaving Certificate", "school_leaving");
rmAndDl("#form5", "#rm5", "#dl5", "#btn5", "SSC Marksheet", "ssc_marksheet");
rmAndDl("#form6", "#rm6", "#dl6", "#btn6", "HSC Marksheet", "hsc_marksheet");
rmAndDl("#form7", "#rm7", "#dl7", "#btn7", "Graduation Marksheet", "graduation_marksheet");
rmAndDl("#form8", "#rm8", "#dl8", "#btn8", "Gujcet result", "gujcet_result");
rmAndDl("#form9", "#rm9", "#dl9", "#btn9", "JEE Result", "jee_result");
rmAndDl("#form10", "#rm10", "#dl10", "#btn10", "NEET Result", "neet_result");
rmAndDl("#form11", "#rm11", "#dl11", "#btn11", "Migration Certificate", "migration_certificate");
rmAndDl("#form12", "#rm12", "#dl12", "#btn12", "Cast Certificate", "caste_certificate");
rmAndDl("#form13", "#rm13", "#dl13", "#btn13", "Other Documents", "other_documents");
</script>
<!--end -->

</body>

</html>