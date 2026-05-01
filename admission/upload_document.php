<style>
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px) {

    /* Force table to not be like tables anymore */
    table,
    thead,
    tbody,
    th,
    td,
    tr {
        display: block;
    }

    /* Hide table headers (but not display: none;, for accessibility) */
    thead tr {
        position: absolute;
        top: -9999px;
        left: -9999px;
    }

    tr {
        border: 1px solid #ccc;
    }

    td {
        /* Behave  like a "row" */
        border: none;
        border-bottom: 1px solid #eee;
        position: relative;
        padding-left: 50%;
    }

    td:before {
        /* Now like a table header */
        position: absolute;
        /* Top/left values mimic padding */
        top: 6px;
        left: 6px;
        width: 45%;
        padding-right: 10px;
        white-space: nowrap;
    }
}
</style>

<!-- code for remove -->
<form id="remove_document_form"></form>

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
<!-- <form id="form" action="ajaxupload.php" method="post" enctype="multipart/form-data"> -->

<table class="table table-bordered">

    <form id="form" action="ajaxupload.php" method="post" enctype="multipart/form-data">
        <!-- <table class="table table-bordered"><tr>  -->
        <tr>

            <td class="center">
                <span style="color: red">*</span>
                <b><span>Passport Size Photo</span></b></b>
            </td>
            <td><input id="uploadImage1" type="file" name="image" class="up_a" required /></td>
            <td style="padding-left: 10px;"> <input class="btn up_b " id="btn1" type="submit" value="Upload"
                    name="myButton"><input style="display:none;" type="button" data-col_name="photo"
                    class="btn up_b remove_document" id="rm1" value="Remove">
            </td>
            <td class="view_photo" style="display:none;"><a target="_blank" id="view_photo" download><i
                        class="fa fa-download" aria-hidden="true"></a></td>

            <!-- </tr></table> -->
        </tr>
        <input type="hidden" id="hidden1" name="fileno" value="Photo">
    </form>

    <form id="form2" action="ajaxupload.php" method="post" enctype="multipart/form-data">
        <!-- <table class="table table-bordered"><tr>  -->

        <tr>
            <td class="center"><b>
                    <span style="color: red">*</span>
                    <b><span>Aadhar card</span></b></b></td>
            <td><input id="uploadImage2" type="file" name="image" class="up_a" required /></td>
            <td style="padding-left: 10px;"> <input class="btn up_b  " id="btn2" type="submit" value="Upload"
                    name="myButton"><input style="display:none;" type="button" data-col_name="aadharcard"
                    class="btn up_b remove_document" id="rm2" value="Remove" /></td>
            <td class="view_aadharcard" style="display:none;"><a target="_blank" id="view_aadharcard" download><i
                        class="fa fa-download" aria-hidden="true"></a target="_blank"></td>
            <!-- </tr></table> -->
        </tr>
        <input type="hidden" id="hidden2" name="fileno" value="Aadhar_card" required>
    </form>

    <form id="form3" action="ajaxupload.php" method="post" enctype="multipart/form-data">
        <!-- <table class="table table-bordered"><tr>  -->

        <tr>
            <td class="center"><b>
                    <span style="color: red">*</span>
                    <b><span>Parent Aadhar card</span></b></b></td>
            <td><input id="uploadImage3" type="file" name="image" class="up_a" required /></td>
            <td style="padding-left: 10px;"> <input class="btn up_b  " id="btn3" type="submit" value="Upload"
                    name="myButton"><input style="display:none;" type="button" data-col_name="parent_aadharcard"
                    class="btn up_b remove_document" id="rm3" value="Remove" /></td>
            <td class="view_parent_aadharcard" style="display:none;"><a target="_blank" id="view_parent_aadharcard"
                    download><i class="fa fa-download" aria-hidden="true"></a target="_blank"></td>
            <!-- </tr></table> -->
        </tr>
        <input type="hidden" id="hidden3" name="fileno" value="Parent_Aadhar_card" required>
    </form>

    <form id="form4" action="ajaxupload.php" method="post" enctype="multipart/form-data">
        <!-- <table class="table table-bordered"><tr>  -->
        <tr>
            <td class="center"><b>

                    <b><span>School Leaving Certificate</span></b></b></td>
            <td><input id="uploadImage4" type="file" name="image" class="up_a" required /></td>
            <td style="padding-left: 10px;"> <input class="btn up_b " id="btn4" type="submit" value="Upload"
                    name="myButton"><input style="display:none;" type="button" data-col_name="school_leaving"
                    class="btn up_b remove_document " id="rm4" value="Remove"></td>
            <td class="view_school_leaving" style="display:none;"><a target="_blank" id="view_school_leaving"
                    download><i class="fa fa-download" aria-hidden="true"></a></td>

            <!-- </tr></table> -->
        </tr>
        <input type="hidden" id="hidden4" name="fileno" value="school_leaving_certificate">
    </form>

    <form id="form5" action="ajaxupload.php" method="post" enctype="multipart/form-data">
        <!-- <table class="table table-bordered"><tr>  -->
        <tr>
            <td class="center"><b>

                    <b><span>SSC Marksheet</span></b></b></td>
            <td><input id="uploadImage5" type="file" name="image" class="up_a" required /></td>
            <td style="padding-left: 10px;"> <input class="btn up_b " id="btn5" type="submit" value="Upload"
                    name="myButton"><input style="display:none;" type="button" data-col_name="ssc_marksheet"
                    class="btn up_b remove_document " id="rm5" value="Remove"></td>
            <td class="view_ssc_marksheet" style="display:none;"><a target="_blank" id="view_ssc_marksheet" download><i
                        class="fa fa-download" aria-hidden="true"></a></td>

            <!-- </tr></table> -->
        </tr>
        <input type="hidden" id="hidden5" name="fileno" value="SSC_Marksheet">
    </form>

    <form id="form6" action="ajaxupload.php" method="post" enctype="multipart/form-data">
        <!-- <table class="table table-bordered"><tr>  -->
        <tr>
            <td class="center"><b>

                    <b><span>HSC Marksheet</span></b></b></td>
            <td><input id="uploadImage6" type="file" name="image" class="up_a" required /></td>
            <td style="padding-left: 10px;"> <input class="btn up_b " id="btn6" type="submit" value="Upload"
                    name="myButton"><input style="display:none;" type="button" data-col_name="hsc_marksheet"
                    class="btn up_b remove_document" id="rm6" value="Remove"></td>
            <td class="view_hsc_marksheet" style="display:none;"><a target="_blank" id="view_hsc_marksheet" download><i
                        class="fa fa-download" aria-hidden="true"></a></td>

            <!-- </tr></table> -->
        </tr>
        <input type="hidden" id="hidden6" name="fileno" value="HSC_Marksheet">
    </form>
    <?php if ($stu_level_id == 2 || $stu_level_id == 4) 
    {
                ?>
    <form id="form7" action="ajaxupload.php" method="post" enctype="multipart/form-data">
        <!-- <table class="table table-bordered"><tr>  -->
        <tr>
            <td class="center"><b>

                    <b><span>Graduation Marksheets & Degree Certificate</span></b></b></td>
            <td><input id="uploadImage7" type="file" name="image" class="up_a" required /></td>
            <td style="padding-left: 10px;"> <input class="btn up_b " id="btn7" type="submit" value="Upload"
                    name="myButton"><input style="display:none;" type="button" data-col_name="graduation_marksheet"
                    class="btn up_b remove_document" id="rm7" value="Remove"></td>
            <td class="view_graduation_marksheet" style="display:none;"><a target="_blank"
                    id="view_graduation_marksheet" download><i class="fa fa-download" aria-hidden="true"></a></td>

            <!-- </tr></table> -->
        </tr>
        <input type="hidden" id="hidden7" name="fileno" value="Graduation_Marksheet">
    </form>
    <?php
    }
    if ($stu_faculty_id == 1 || $stu_faculty_id == 15) {
        ?>

    <form id="form8" action="ajaxupload.php" method="post" enctype="multipart/form-data">
        <!-- <table class="table table-bordered"><tr>  -->
        <tr>
            <td class="center"><b>

                    <b><span>Gujcet Result</span></b></b></td>
            <td><input id="uploadImage8" type="file" name="image" class="up_a" required /></td>
            <td style="padding-left: 10px;"> <input class="btn up_b " id="btn8" type="submit" value="Upload"
                    name="myButton"><input style="display:none;" type="button" data-col_name="gujcet_result"
                    class="btn up_b remove_document" id="rm8" value="Remove"></td>
            <td class="view_gujcet_result" style="display:none;"><a target="_blank" id="view_gujcet_result" download><i
                        class="fa fa-download" aria-hidden="true"></a target="_blank"></td>

            <!-- </tr></table> -->
        </tr>
        <input type="hidden" id="hidden8" name="fileno" value="Gujcet_Result">
    </form>

    <form id="form9" action="ajaxupload.php" method="post" enctype="multipart/form-data">
        <!-- <table class="table table-bordered"><tr>  -->
        <tr>
            <td class="center"><b>

                    <b><span>JEE Result</span></b></b></td>
            <td><input id="uploadImage9" type="file" name="image" class="up_a" required /></td>
            <td style="padding-left: 10px;"> <input class="btn up_b " id="btn9" type="submit" value="Upload"
                    name="myButton"><input style="display:none;" type="button" data-col_name="jee_result"
                    class="btn up_b remove_document " id="rm9" value="Remove"></td>
            <td class="view_jee_result" style="display:none;"><a target="_blank" id="view_jee_result" download><i
                        class="fa fa-download" aria-hidden="true"></a></td>

            <!-- </tr></table> -->
        </tr>
        <input type="hidden" id="hidden9" name="fileno" value="JEE_Result" required>
    </form>

    <form id="form10" action="ajaxupload.php" method="post" enctype="multipart/form-data">
        <!-- <table class="table table-bordered"><tr>  -->
        <tr>
            <td class="center"><b>

                    <b><span>NEET Result</span></b></b></td>
            <td><input id="uploadImage10" type="file" name="image" class="up_a" required /></td>
            <td style="padding-left: 10px;"> <input class="btn up_b " id="btn10" type="submit" value="Upload"
                    name="myButton"><input style="display:none;" type="button" data-col_name="neet_result"
                    class="btn up_b remove_document" id="rm10" value="Remove"></td>
            <td class="view_neet_result" style="display:none;"><a target="_blank" id="view_neet_result" download><i
                        class="fa fa-download" aria-hidden="true"></a></td>

            <!-- </tr></table> -->
        </tr>
        <input type="hidden" id="hidden10" name="fileno" value="NEET_Result" required>
    </form>
    <?php
                }
                ?>
    <form id="form11" action="ajaxupload.php" method="post" enctype="multipart/form-data">
        <!-- <table class="table table-bordered"><tr>  -->
        <tr>
            <td class="center"><b>
                    <b><span>Migration Certificate</span></b></b></td>
            <td><input id="uploadImage11" type="file" name="image" class="up_a" /></td>
            <td style="padding-left: 10px;"> <input class="btn up_b " id="btn11" type="submit" value="Upload"
                    name="myButton"><input style="display:none;" type="button" data-col_name="migration_certificate"
                    class="btn up_b remove_document" id="rm11" value="Remove"></td>
            <td class="view_migration_certificate" style="display:none;"><a target="_blank"
                    id="view_migration_certificate" download><i class="fa fa-download" aria-hidden="true"></a></td>

            <!-- </tr></table> -->
        </tr>
        <input type="hidden" id="hidden11" name="fileno" value="Migration_Certificate">
    </form>

    <form id="form12" action="ajaxupload.php" method="post" enctype="multipart/form-data">
        <!-- <table class="table table-bordered"><tr>  -->
        <tr>
            <td class="center"><b>
                    <b><span>Caste Certificate</span></b></b></td>
            <td><input id="uploadImage12" type="file" name="image" class="up_a" /></td>
            <td style="padding-left: 10px;"> <input class="btn up_b " id="btn12" type="submit" value="Upload"
                    name="myButton"><input style="display:none;" type="button" data-col_name="caste_certificate"
                    class="btn up_b remove_document" id="rm12" value="Remove"></td>
            <td class="view_caste_certificate" style="display:none;"><a target="_blank" id="view_caste_certificate"
                    download><i class="fa fa-download" aria-hidden="true"></a></td>

            <!-- </tr></table> -->
        </tr>
        <input type="hidden" id="hidden12" name="fileno" value="Cast_Certificate">
    </form>

    <form id="form13" action="ajaxupload.php" method="post" enctype="multipart/form-data">
        <!-- <table class="table table-bordered"><tr>  -->
        <tr>
            <td class="center"><b>
                    <b><span>Other Documents</span></b></b></td>
            <td><input id="uploadImage13" type="file" name="image" class="up_a" /></td>
            <td style="padding-left: 10px;"> <input class="btn up_b " id="btn13" type="submit" value="Upload"
                    name="myButton"><input style="display:none;" type="button" data-col_name="other_documents"
                    class="btn up_b remove_document" id="rm13" value="Remove"></td>
            <td class="view_other_documents" style="display:none;"><a target="_blank" id="view_other_documents"
                    download><i class="fa fa-download" aria-hidden="true"></a target="_blank"></td>

            <!-- </tr></table> -->
        </tr>
        <input type="hidden" id="hidden13" name="fileno" value="Other_Documents">
    </form>

</table>